<?php

/**
 * Class Proposta_Model_TbCustosVinculadosMapper
 *
 * @name Proposta_Model_TbCustosVinculadosMapper
 * @package Modules/Proposta
 * @subpackage Models
 *
 * @link http://salic.cultura.gov.br
 */
class Proposta_Model_TbCustosVinculadosMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Proposta_Model_DbTable_TbCustosVinculados');
    }

    public function save($model)
    {
        return parent::save($model);
    }

    public function obterValoresPecentuaisELimitesCustosVinculados($idPreProjeto)
    {
        $ModelCustosVinculados = new Proposta_Model_TbCustosVinculados();

        $whereCustosVinculados = [
            'a.idPlanilhaItens not in (?)' => array(
                $ModelCustosVinculados::ID_DIREITOS_AUTORAIS,
                $ModelCustosVinculados::ID_CONTROLE_E_AUDITORIA
            )
        ];

        $tbItensPlanilhaProduto = new tbItensPlanilhaProduto();
        $itensCustosVinculados = $tbItensPlanilhaProduto->buscarItens(
            $whereCustosVinculados,
            $ModelCustosVinculados::ID_ETAPA_CUSTOS_VINCULADOS,
            null,
            Zend_DB::FETCH_ASSOC
        );

        $percentualRemuneracaoCaptacao = $ModelCustosVinculados::PERCENTUAL_PADRAO_REMUNERACAO_CAPTACAO_DE_RECURSOS;
        $limiteRemuneracaoCaptacao = $ModelCustosVinculados::LIMITE_PADRAO_CAPTACAO_DE_RECURSOS;
        $percentualDivulgacao = $ModelCustosVinculados::PERCENTUAL_DIVULGACAO_ATE_VALOR_LIMITE;

        $tbPlanilhaProposta = new Proposta_Model_DbTable_TbPlanilhaProposta();
//        $valorCustoDoProjeto = $tbPlanilhaProposta->somarPlanilhaPropostaPorEtapa(
//            $idPreProjeto,
//            Mecanismo::INCENTIVO_FISCAL,
//            null,
//            ['e.idPlanilhaEtapa in (?)' => [1,2,7,8]]
//        );

        $whereRegional1 = array(
            "uf.Regiao in (?)" => ['Norte', 'Nordeste', 'Centro Oeste']
        );

        $whereRegional2 = array(
            "uf.Sigla in (?)" => ['SC', 'RS', 'PR', 'ES', 'MG']
        );

        $tbAbrangencia = new Proposta_Model_DbTable_Abrangencia();
        $propostaDaRegiao1 = $tbAbrangencia->buscarUfRegionalizacao($idPreProjeto, $whereRegional1);
        $propostaDaRegiao2 = $tbAbrangencia->buscarUfRegionalizacao($idPreProjeto, $whereRegional2);

        if (!empty($propostaDaRegiao1)) {
            $percentualRemuneracaoCaptacao = $ModelCustosVinculados::PERCENTUAL_REGIOES_N_NE_CO_REMUNERACAO_CAPTACAO_DE_RECURSOS;
//            $limiteRemuneracaoCaptacao = ($valorCustoDoProjeto * $percentualRemuneracaoCaptacao / 100) + $limiteRemuneracaoCaptacao;
        } else if($propostaDaRegiao2) {
            $percentualRemuneracaoCaptacao = $ModelCustosVinculados::PERCENTUAL_UFS_RS_PR_SC_MG_ES_REMUNERACAO_CAPTACAO_DE_RECURSOS;
//            $limiteRemuneracaoCaptacao = ($valorCustoDoProjeto * $percentualRemuneracaoCaptacao / 100) + $limiteRemuneracaoCaptacao;
        }

        $valorDoProjeto = $tbPlanilhaProposta->somarPlanilhaPropostaPorEtapa(
            $idPreProjeto,
            Mecanismo::INCENTIVO_FISCAL,
            null,
            [
                'e.tpCusto = ?' => 'P',
                'e.tpGrupo = ?' => 'A',
            ]
        );

        if($valorDoProjeto > $ModelCustosVinculados::VALOR_LIMITE_DIVULGACAO) {
            $percentualDivulgacao = $ModelCustosVinculados::PERCENTUAL_DIVULGACAO_MAIOR_QUE_VALOR_LIMITE;
        }

        $custosVinculados = array();
        foreach ($itensCustosVinculados as $item) {
            switch ($item['idPlanilhaItens']) {
                case $ModelCustosVinculados::ID_CUSTO_ADMINISTRATIVO:
                    $item['Percentual'] = $ModelCustosVinculados::PERCENTUAL_CUSTO_ADMINISTRATIVO;
                    break;
                case $ModelCustosVinculados::ID_DIVULGACAO:
                    $item['Percentual'] = $percentualDivulgacao;
                    break;
                case $ModelCustosVinculados::ID_REMUNERACAO_CAPTACAO:
                    $item['Percentual'] = $percentualRemuneracaoCaptacao;
                    $item['Limite'] = $limiteRemuneracaoCaptacao;
                    break;
            }

            $custoVinculadoProponente = $this->findBy(
                array(
                    'idProjeto' => $idPreProjeto,
                    'idPlanilhaItem' => $item['idPlanilhaItens']
                )
            );

            if ($custoVinculadoProponente) {
                $item['PercentualProponente'] = $custoVinculadoProponente['pcCalculo'];
                $item['idCustosVinculados'] = $custoVinculadoProponente['idCustosVinculados'];
            }

            $custosVinculados[] = $item;
        }

        return $custosVinculados;
    }

    public function atualizarCustosVinculadosDaPlanilha($idPreProjeto)
    {
        $idEtapa = '8'; // Custos Vinculados
        $tipoCusto = 'A';

        if (empty($idPreProjeto)) {
            return false;
        }

        $TPP = new Proposta_Model_DbTable_TbPlanilhaProposta();
        $somaPlanilhaPropostaProdutos = $TPP->somarPlanilhaPropostaPorEtapa($idPreProjeto, Mecanismo::INCENTIVO_FISCAL, null, ['e.tpCusto = ?' => 'P']);

        if (empty($somaPlanilhaPropostaProdutos) || (is_numeric($somaPlanilhaPropostaProdutos) && $somaPlanilhaPropostaProdutos <= 0)) {
            $TPP->excluirCustosVinculados($idPreProjeto);
            return true;
        }

        $itens = $this->calcularCustosVinculadosPlanilhaProposta($idPreProjeto, $somaPlanilhaPropostaProdutos);

        foreach ($itens as $item) {
            $custosVinculados = null;

            //fazer uma nova busca com o essencial para este caso
            $custosVinculados = $TPP->buscarCustos($idPreProjeto, $tipoCusto, $idEtapa, $item['idplanilhaitem']);

            if (isset($custosVinculados[0]->idItem)) {
                $where = 'idPlanilhaProposta = ' . $custosVinculados[0]->idPlanilhaProposta;
                $TPP->update($item, $where);
            } else {
                $TPP->insert($item);
            }
        }
    }

    public function calcularCustosVinculadosPlanilhaProposta($idPreProjeto, $valorTotalProdutos = null)
    {
        if (empty($idPreProjeto)) {
            return false;
        }

        $idEtapa = Proposta_Model_TbCustosVinculados::ID_ETAPA_CUSTOS_VINCULADOS;
        $fonteRecurso = Proposta_Model_TbCustosVinculados::ID_FONTE_RECURSO_CUSTOS_VINCULADOS;

        $idUf = 1;
        $idMunicipio = 1;
        $dados = array();

        $TPP = new Proposta_Model_DbTable_TbPlanilhaProposta();

        if (empty($valorTotalProdutos)) {
            $somaPlanilhaPropostaProdutos = $TPP->somarPlanilhaPropostaPorEtapa(
                $idPreProjeto,
                Mecanismo::INCENTIVO_FISCAL,
                null, ['e.tpCusto = ?' => 'P']);
            $valorTotalProdutos = $somaPlanilhaPropostaProdutos;
        }

        if (!is_numeric($valorTotalProdutos)) {
            return 0;
        }

        $itensCustosVinculados = $this->obterValoresPecentuaisELimitesCustosVinculados($idPreProjeto);

        foreach ($itensCustosVinculados as $item) {
            if ($item['PercentualProponente'] > 0) {
                $valorCustoItem = ($valorTotalProdutos * ($item['PercentualProponente'] / 100));

                if (isset($item['Limite']) && $valorCustoItem > $item['Limite']) {
                    $valorCustoItem = $item['Limite'];
                }
            } elseif ($item['PercentualProponente'] == 0) {
                $valorCustoItem = 0;
            }

            $dados[] = array(
                'idprojeto' => $idPreProjeto,
                'idetapa' => $idEtapa,
                'idplanilhaitem' => $item['idPlanilhaItens'],
                'descricao' => '',
                'unidade' => '1',
                'quantidade' => '1',
                'ocorrencia' => '1',
                'valorunitario' => $valorCustoItem,
                'qtdedias' => '1',
                'tipodespesa' => '0',
                'tipopessoa' => '0',
                'contrapartida' => '0',
                'fonterecurso' => $fonteRecurso,
                'ufdespesa' => $idUf,
                'municipiodespesa' => $idMunicipio,
                'idusuario' => 462,
                'dsjustificativa' => ''
            );
        }

        return $dados;
    }

    public function somarTotalCustosVinculados($idPreProjeto, $valorTotalProdutos = null)
    {
        $itens = $this->calcularCustosVinculadosPlanilhaProposta($idPreProjeto, $valorTotalProdutos);
        $soma = '';

        if ($itens == 0) {
            return 0;
        }

        if ($itens) {
            $soma = 0;
            foreach ($itens as $item) {
                $soma = $item['valorunitario'] + $soma;
            }
        }
        return $soma;
    }

}
