<?php

abstract class Solicitacao_GenericController extends MinC_Controller_Action_Abstract
{
    protected $_proposta = null;

    protected $_projeto = null;

    protected $_idPreProjeto = null;

    protected $_idPronac = null;

    public function init()
    {
        parent::init();

        $this->idPreProjeto = $this->getRequest()->getParam('idPreProjeto');
        $this->idPronac = $this->getRequest()->getParam('idPronac');

        if (!empty($this->idPreProjeto)) {
            $tblPreProjeto = new Proposta_Model_DbTable_PreProjeto();
            $this->_proposta = $tblPreProjeto->buscar(array('idPreProjeto = ?' => $this->idPreProjeto))->current();
        }

        if (!empty($this->idPronac)) {

            $tbProjetos = new Projeto_Model_DbTable_Projetos();
            $this->_projeto = $tbProjetos->buscar(array('IdPRONAC = ?' => $this->idPronac))->current();
            $this->idPreProjeto = $this->_projeto->idProjeto;
        }

    }
}
