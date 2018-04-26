<?php

class Readequacao_PlanodistribuicaoController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
    }

    public function obterAbrangenciasReadequacaoAjaxAction() {
        $this->_helper->layout->disableLayout();

        $idPreProjeto = $this->_request->getParam('idPreProjeto');

        $arrBusca = array();
        $arrBusca['idprojeto'] = $idPreProjeto;
        $arrBusca['stabrangencia'] = 1;
        $tblAbrangencia = new Proposta_Model_DbTable_Abrangencia();
        $locais = $tblAbrangencia->buscar($arrBusca);

        foreach ($locais as $key => $dado) {
            $locais[$key] = array_map('utf8_encode', $dado);
        }

        $this->_helper->json(array('data' => $locais, 'success' => 'true'));

    }
}