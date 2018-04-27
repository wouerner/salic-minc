<?php

class Readequacao_PlanodistribuicaoController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        parent::init();
    }

    public function obterPlanoDistribuicaoReadequacaoAjaxAction() {
        $this->_helper->layout->disableLayout();

        try {
            $idPreProjeto = $this->_request->getParam('idPreProjeto');

            $arrBusca = array();
            $arrBusca['idProjeto'] = $idPreProjeto;
            $arrBusca['stAbrangencia'] = 1;
            $tblAbrangencia = new Proposta_Model_DbTable_Abrangencia();
            $locais = $tblAbrangencia->buscar($arrBusca);

            foreach ($locais as $key => $dado) {
                $locais[$key] = array_map('utf8_encode', $dado);
            }

            $this->_helper->json(array('data' => $locais, 'success' => 'true'));
        }catch (Exception $e) {
            $this->_helper->json(array('data' => $locais, 'success' => 'false', 'msg' => $e->getMessage()));
        }
    }
}