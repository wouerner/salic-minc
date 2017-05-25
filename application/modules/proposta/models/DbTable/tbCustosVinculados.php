<?php

/**
 * Class Proposta_Model_DbTable_TbCustosVinculados
 *
 * @name Proposta_Model_DbTable_TbCustosVinculados
 * @package Modules/proposta
 * @subpackage Models/DbTable
 * @version $Id$
 *
 */
class Proposta_Model_DbTable_TbCustosVinculados extends MinC_Db_Table_Abstract
{

    protected $_schema = 'sac';
    protected $_name = 'tbCustosVinculados';

    public function obterPadroesCustosVinculados($idPreProjeto) {

        $TPP = new Proposta_Model_DbTable_TbPlanilhaProposta();

        # trocar e pegar pelo local de realizacao cadastrado
        $ufRegionalizacaoPlanilha = $TPP->buscarItensUfRegionalizacao($idPreProjeto);

        $TPCV = new Proposta_Model_TbCustosVinculados();

        # definindo os criterios de regionalizacao
        if (!empty($ufRegionalizacaoPlanilha)) {
            $calcDivugacao = $TPCV::DIVULGACAO_SUL_SUDESTE;
            $calcCaptacao =  $TPCV::REMUNERACAO_CAPTACAO_DE_RECURSOS_SUL_SUDESTE;
            $limiteCaptacao = $TPCV::LIMITE_CAPTACAO_DE_RECURSOS_SUL_SUDESTE;

            $idUf = $ufRegionalizacaoPlanilha->idUF;
            $idMunicipio = $ufRegionalizacaoPlanilha->idMunicipio;
        } else { # demais regiões
            $calcDivugacao = $TPCV::DIVULGACAO_OUTRAS_REGIOES;
            $calcCaptacao = $TPCV::REMUNERACAO_CAPTACAO_DE_RECURSOS_OUTRAS_REGIOES;
            $limiteCaptacao = $TPCV::LIMITE_CAPTACAO_DE_RECURSOS_OUTRAS_REGIOES;

            $arrBusca['idprojeto'] = $idPreProjeto;
            $arrBusca['stabrangencia'] = 1;

            $idUf = 1;
            $idMunicipio = 1;
        }
    }
}
