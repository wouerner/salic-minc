<?php

class Readequacao_LocalRealizacaoController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        parent::init();
    }

    public function obterLocaisReadequacaoAjaxAction() {
        $this->_helper->layout->disableLayout();

        $idPronac = $this->_request->getParam('idPronac');

        $arrBusca = array();
        $arrBusca['idprojeto'] = $idPronac;
        $arrBusca['stabrangencia'] = 1;
        $tblAbrangencia = new Proposta_Model_DbTable_Abrangencia();
        $locais = $tblAbrangencia->buscar($arrBusca);

        foreach ($locais as $key => $dado) {
            $locais[$key] = array_map('utf8_encode', $dado);
        }

        $this->_helper->json(array('data' => $locais, 'success' => 'true'));

    }

}