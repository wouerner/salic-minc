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

        $tbCustosVinculadosMapper = new Proposta_Model_TbCustosVinculadosMapper();

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

            $custoVinculadoProponente = $tbCustosVinculadosMapper->findBy(
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

}
