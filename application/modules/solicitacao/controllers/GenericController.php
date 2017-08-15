<?php

abstract class Solicitacao_GenericController extends MinC_Controller_Action_Abstract
{
    protected $_proposta = null;

    protected $_projeto = null;

    protected $_idPreProjeto = null;

    protected $_idPronac = null;

    protected $_idUsuario = null;

    protected $_usuario = null;

    public function init()
    {
        parent::init();

        $auth = Zend_Auth::getInstance();
        $PermissoesGrupo = array();

        //Da permissao de acesso a todos os grupos do usuario logado afim de atender o UC75
        if (isset($auth->getIdentity()->usu_codigo)) {
            //Recupera todos os grupos do Usuario
            $Usuario = new Autenticacao_Model_Usuario();
            $grupos = $Usuario->buscarUnidades($auth->getIdentity()->usu_codigo, 21);
            foreach ($grupos as $grupo) {
                $PermissoesGrupo[] = $grupo->gru_codigo;
            }
        }

        isset($auth->getIdentity()->usu_codigo) ? parent::perfil(1, $PermissoesGrupo) : parent::perfil(4, $PermissoesGrupo);

        $arrAuth = array_change_key_case((array)$auth->getIdentity());

//        $this->usuario = $arrAuth;


        $this->_idPreProjeto = $this->getRequest()->getParam('idPreProjeto');
        $this->_idPronac = $this->getRequest()->getParam('idPronac');
        if (!empty($this->_idPronac)) {
            $tbProjetos = new Projeto_Model_DbTable_Projetos();
            $this->_projeto = $tbProjetos->buscar(array('IdPRONAC = ?' => $this->_idPronac))->current();
            $this->view->projeto = $this->_projeto;
        }

        if (!empty($this->_idPreProjeto)) {
            $tblPreProjeto = new Proposta_Model_DbTable_PreProjeto();
            $this->_proposta = $tblPreProjeto->buscar(array('idPreProjeto = ?' => $this->_idPreProjeto))->current();
            $this->view->proposta = $this->_proposta;
        }

        $this->_idUsuario = !empty($arrAuth['usu_codigo']) ? $arrAuth['usu_codigo'] : $arrAuth['idusuario'];
        $this->_usuario = $arrAuth;
        $this->view->usuario = $auth->getIdentity(); //@todo padronizar o usuario no header do layout
    }
}

