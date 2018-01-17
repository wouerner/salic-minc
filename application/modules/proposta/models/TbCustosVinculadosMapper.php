<?php

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
        if (empty($idPreProjeto)) {
            return [];
        }

        $tbPlanilhaProposta = new Proposta_Model_DbTable_TbPlanilhaProposta();
        $valorDoProjeto = $tbPlanilhaProposta->somarPlanilhaPropostaPorEtapa(
            $idPreProjeto,
            Mecanismo::INCENTIVO_FISCAL,
            null,
            [
                'e.tpCusto = ?' => 'P',
                'e.tpGrupo = ?' => 'A',
            ]
        );

        if (empty($valorDoProjeto)) {
            return [];
        }

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

        $whereRegional1 = array(
            "uf.Regiao in (?)" => ['Norte', 'Nordeste', 'Centro Oeste']
        );

        $whereRegional2 = array(
            "uf.Sigla in (?)" => ['SC', 'RS', 'PR', 'ES', 'MG']
        );

        $tbAbrangencia = new Proposta_Model_DbTable_Abrangencia();
        $propostaDaRegiao1 = $tbAbrangencia->buscarUfRegionalizacao($idPreProjeto, $whereRegional1);
        $propostaDaRegiao2 = $tbAbrangencia->buscarUfRegionalizacao($idPreProjeto, $whereRegional2);

        $percentualRemuneracaoCaptacao = $ModelCustosVinculados::PERCENTUAL_PADRAO_REMUNERACAO_CAPTACAO_DE_RECURSOS;

        if (!empty($propostaDaRegiao1)) {
            $percentualRemuneracaoCaptacao = $ModelCustosVinculados::PERCENTUAL_REGIOES_N_NE_CO_REMUNERACAO_CAPTACAO_DE_RECURSOS;
        } else if ($propostaDaRegiao2) {
            $percentualRemuneracaoCaptacao = $ModelCustosVinculados::PERCENTUAL_UFS_RS_PR_SC_MG_ES_REMUNERACAO_CAPTACAO_DE_RECURSOS;
        }

        $percentualDivulgacao = $ModelCustosVinculados::PERCENTUAL_DIVULGACAO_ATE_VALOR_LIMITE;
        if ($valorDoProjeto > $ModelCustosVinculados::VALOR_LIMITE_DIVULGACAO) {
            $percentualDivulgacao = $ModelCustosVinculados::PERCENTUAL_DIVULGACAO_MAIOR_QUE_VALOR_LIMITE;
        }

        $custosVinculados = array();
        foreach ($itensCustosVinculados as $item) {
            switch ($item['idPlanilhaItens']) {
                case $ModelCustosVinculados::ID_CUSTO_ADMINISTRATIVO:
                    $item['percentualPadrao'] = $ModelCustosVinculados::PERCENTUAL_CUSTO_ADMINISTRATIVO;
                    break;
                case $ModelCustosVinculados::ID_DIVULGACAO:
                    $item['percentualPadrao'] = $percentualDivulgacao;
                    break;
                case $ModelCustosVinculados::ID_REMUNERACAO_CAPTACAO:
                    $item['percentualPadrao'] = $percentualRemuneracaoCaptacao;
                    $item['limitePadrao'] = $ModelCustosVinculados::LIMITE_PADRAO_CAPTACAO_DE_RECURSOS;
                    break;
            }

            $custoVinculadoProponente = $this->findBy(
                array(
                    'idProjeto' => $idPreProjeto,
                    'idPlanilhaItem' => $item['idPlanilhaItens']
                )
            );

            if ($custoVinculadoProponente) {
                $item['percentualProponente'] = $custoVinculadoProponente['pcCalculo'];
                $item['idCustosVinculados'] = $custoVinculadoProponente['idCustosVinculados'];
            }

            if (!empty($valorDoProjeto)) {
                $item['valorDoProjeto'] = $valorDoProjeto;
            }

            $custosVinculados[] = $item;
        }

        return $custosVinculados;
    }

    public function atualizarCustosVinculadosDaPlanilha($idPreProjeto)
    {

        if (empty($idPreProjeto)) {
            return false;
        }

        $idEtapaCustosVinculados = Proposta_Model_TbPlanilhaEtapa::CUSTOS_VINCULADOS;
//        $idEtapaRemuneracao = Proposta_Model_TbPlanilhaEtapa::REMUNERACAO_CAPTACAO;
        $tipoCusto = Proposta_Model_TbPlanilhaEtapa::TIPO_CUSTO_ADMINISTRATIVO;

//        $valorDoProjeto = $tbPlanilhaProposta->somarPlanilhaPropostaPorEtapa(
//            $idPreProjeto,
//            Mecanismo::INCENTIVO_FISCAL,
//            null,
//            [
//                'e.tpCusto = ?' => 'P',
//                'e.tpGrupo = ?' => 'A',
//            ]
//        );
//
//        if (empty($valorDoProjeto) || (is_numeric($valorDoProjeto) && $valorDoProjeto <= 0)) {
//            $tbPlanilhaProposta->excluirCustosVinculadosERemuneracao($idPreProjeto);
//            return true;
//        }

        $tbPlanilhaProposta = new Proposta_Model_DbTable_TbPlanilhaProposta();
        $itens = $this->calcularCustosVinculadosERemuneracaoPlanilhaProposta($idPreProjeto);

        foreach ($itens as $item) {
            $custosVinculados = null;

            //fazer uma nova busca com o essencial para este caso
            $custosVinculados = $tbPlanilhaProposta->buscarCustos($idPreProjeto, $tipoCusto, $idEtapaCustosVinculados, $item['idPlanilhaItem']);

            if (isset($custosVinculados[0]->idItem)) {
                $where = 'idPlanilhaProposta = ' . $custosVinculados[0]->idPlanilhaProposta;
                $tbPlanilhaProposta->update($item, $where);
            } else {
                $tbPlanilhaProposta->insert($item);
            }
        }
    }

    public function calcularCustosVinculadosERemuneracaoPlanilhaProposta($idPreProjeto)
    {
        if (empty($idPreProjeto)) {
            return false;
        }

        $idUf = 1;
        $idMunicipio = 1;
        $dados = array();

        $tbPlanilhaProposta = new Proposta_Model_DbTable_TbPlanilhaProposta();
        $municipioUF = $tbPlanilhaProposta->obterMunicipioUFdoProdutoPrincipalComMaiorCusto($idPreProjeto);
        if ($municipioUF) {
            $idUf = $municipioUF->UfDespesa;
            $idMunicipio = $municipioUF->MunicipioDespesa;
        }

        $itensCustosVinculados = $this->obterValoresPecentuaisELimitesCustosVinculados($idPreProjeto);

        $valorCustoDoProjeto = $tbPlanilhaProposta->somarPlanilhaPropostaPorEtapa(
            $idPreProjeto,
            Mecanismo::INCENTIVO_FISCAL,
            null,
            ['e.idPlanilhaEtapa in (?)' => [1, 2, 7, 8]]
        );

        foreach ($itensCustosVinculados as $item) {

            $percentual = $item['percentualPadrao'];

            if (!empty($item['percentualProponente'])) {
                $percentual = $item['percentualProponente'];
            }

            $valorTotal = $item['valorDoProjeto'];
            if ($item['idPlanilhaEtapa'] != Proposta_Model_TbPlanilhaEtapa::CUSTOS_VINCULADOS) {
                $valorTotal = $valorCustoDoProjeto;
            }

            $valorUnitario = ($valorTotal * ($percentual / 100));

            if (isset($item['limitePadrao']) && $valorUnitario > $item['limitePadrao']) {
                $valorUnitario = $item['limitePadrao'];
            }

            $dados[] = array(
                'idProjeto' => $idPreProjeto,
                'idEtapa' => $item['idPlanilhaEtapa'],
                'idPlanilhaItem' => $item['idPlanilhaItens'],
                'Descricao' => '',
                'Unidade' => '1',
                'Quantidade' => '1',
                'Ocorrencia' => '1',
                'valorUnitario' => $valorUnitario,
                'QtdeDias' => '1',
                'tipoDespesa' => '0',
                'tipoPessoa' => '0',
                'contraPartida' => '0',
                'FonteRecurso' => Mecanismo::INCENTIVO_FISCAL,
                'UfDespesa' => $idUf,
                'municipioDespesa' => $idMunicipio,
                'idUsuario' => 462,
                'dsJustificativa' => ''
            );
        }

        return $dados;
    }

    /**
     * @todo verificar onde usa e passar
     */
    public function somarTotalCustosVinculados($idPreProjeto, $valorTotalProdutos = null)
    {
        $itens = $this->calcularCustosVinculadosERemuneracaoPlanilhaProposta($idPreProjeto, $valorTotalProdutos);
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
