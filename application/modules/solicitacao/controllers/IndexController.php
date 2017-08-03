<?php

class Solicitacao_IndexController extends Solicitacao_GenericController
{
    private $idTipoDoAtoAdministrativo;

    private $grupoAtivo;

    private $cod_usuario;

    public function init()
    {
        parent::init();

        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
        parent::perfil();

        $this->cod_usuario = $this->auth->getIdentity()->usu_codigo;

        $this->definirModuloDeOrigem();
    }

    private function definirModuloDeOrigem()
    {
//        $this->view->module = $this->moduleName;
        $get = Zend_Registry::get('get');
        $post = (object)$this->getRequest()->getPost();
        $this->view->origin = "{$this->moduleName}/index";
        if (!empty($get->origin) || !empty($post->origin)) {
            $this->view->origin = (!empty($post->origin)) ? $post->origin : $get->origin;
        }
    }

    public function indexAction()
    {
        // listar solicitacoes
    }

    public function listarAction()
    {
        $this->_helper->layout->disableLayout();
        $intIdPronac = $this->getRequest()->getParam('idPronac', null);
        $auth = Zend_Auth::getInstance(); // pega a autenticacao

        $arrAuth = array_change_key_case((array)$auth->getIdentity());
        $intUsuCodigo = $arrAuth['usu_codigo'];
        $grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');

        $intUsuOrgao = $grupoAtivo->codGrupo;
        //var_dump($intUsuOrgao, $grupoAtivo->codOrgao);die;
        $dbTable = new Admissibilidade_Model_DbTable_TbMensagemProjeto();
        if (empty($intIdPronac)) {
            $arrWhere = array('tbMensagemProjeto.idMensagemOrigem IS NULL AND tbMensagemProjeto.idDestinatario = ?' => $intUsuCodigo);
            $arrOrWhere = array("tbMensagemProjeto.idMensagemOrigem IS NULL AND tbMensagemProjeto.idDestinatario = {$intUsuCodigo} AND tbMensagemProjeto.idDestinatarioUnidade = ?" => $intUsuOrgao);
            $this->view->arrResult = $dbTable->getAllBy($arrWhere, $arrOrWhere);
        } else {
            $arrWhere = array('tbMensagemProjeto.idMensagemOrigem IS NULL' => '');
            $arrWhere['tbMensagemProjeto.IdPRONAC'] = $intIdPronac;
            $this->view->arrResult = $dbTable->getAllBy($arrWhere);
        }
        $this->view->usuCodigo = $intUsuCodigo;
        $this->view->usuOrgao = $intUsuOrgao;
        $this->view->idPronac = $intIdPronac;
    }

    public function novaAction()
    {

        $strActionBack = $this->getRequest()->getParam('actionBack');
        $strActionBack = ($strActionBack) ? $strActionBack : 'index';

        $this->view->urlAction = $this->_urlPadrao . "/solicitacao/index/salvar";

        $params = $this->getRequest()->getParams();
        $anexo = null;

        try {

            if (empty($this->idPronac) && empty($this->idPreProjeto)) {
                throw new Exception("Informe o projeto ou proposta para realizar uma solicita&ccedil;&atilde;o");
            }

            $dataForm = [
                'idPronac' => $this->idPronac,
                'idProjeto' => $this->idPreProjeto,
                'siEncaminhamento' => Solicitacao_Model_TbSolicitacao::SOLICITACAO_CADASTRADA
            ];

            if (isset($params['idSolicitacao'])) {
                $tbSolicitacao = new Solicitacao_Model_DbTable_TbSolicitacao();
                $dataForm = $tbSolicitacao->findBy(['idSolicitacao' => $params['idSolicitacao']]);
            }

            if (!empty($dataForm['idDocumento'])) {
                $tbl = new Proposta_Model_DbTable_TbDocumentosPreProjeto();
                $anexo = $tbl->buscarDocumentos(array($dataForm['idDocumento']));
            }

            $this->view->dataForm = $dataForm;
            $this->view->anexo = $anexo;

        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/solicitacao/");
        }
    }

    public function salvarAction()
    {
        $params = $this->getRequest()->getParams();


        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);


//            $strUrl = '/admissibilidade/mensagem/index';
//            $strUrl .= ($this->arrProjeto)? '?idPronac=' . $this->arrProjeto['IdPRONAC'] : '';
//            $arrayForm = $this->getRequest()->getPost();

            $mapper = new Solicitacao_Model_TbSolicitacaoMapper();
            $mapper->salvar($this->getRequest()->getPost());

//            $this->_helper->json(array('status' => $mapper->salvar($this->getRequest()->getPost()), 'msg' => $mapper->getMessages(), 'redirect' => $strUrl));



        }
    }


}