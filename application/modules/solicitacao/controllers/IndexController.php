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

    private function definirModuloDeOrigem() {
//        $this->view->module = $this->moduleName;
        $get = Zend_Registry::get('get');
        $post = (object)$this->getRequest()->getPost();
        $this->view->origin = "{$this->moduleName}/index";
        if(!empty($get->origin) || !empty($post->origin)) {
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

        $arrAuth = array_change_key_case((array) $auth->getIdentity());
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

    public function novaAction() {

        $strActionBack = $this->getRequest()->getParam('actionBack');
        $strActionBack = ($strActionBack) ? $strActionBack : 'index';

        $params = $this->getRequest()->getParams();

        $solicitacao = [];
        $params['idSolicitacao'] = 1;
        if(isset($params['idSolicitacao'])) {


            $tbSolicitacao = new Solicitacao_Model_DbTable_TbSolicitacao();
            $dataForm = $tbSolicitacao->findBy(['idSolicitacao' => $params['idSolicitacao']]);
        }

        // Plano de execução imediata #novain
        if ($this->_proposta["stproposta"] == '618') { // proposta execucao imediata edital
            $idDocumento = 248;
        } elseif ($this->_proposta["stproposta"] == '619') { // proposta execucao imediata contrato de patrocínio
            $idDocumento = 162;
        }

        $tbl = new Proposta_Model_DbTable_TbDocumentosPreProjeto();

        if (!empty($idDocumento))
            $arquivoExecucaoImediata = $tbl->buscarDocumentos(array("idprojeto = ?" => $this->idPreProjeto, "CodigoDocumento = ?" => $idDocumento));

        $this->view->arquivoExecucaoImediata = $arquivoExecucaoImediata;

    }

    public function salvarAction() {

        $idProjeto = $this->idProjeto;
        $idPreProjeto = $this->idPreProjeto;

        if (!empty($idDocumento)) {

            $arrayFile = array(
                'idPreProjeto' => $idPreProjeto,
                'documento' => $idDocumento,
                'tipoDocumento' => 2,
                'observacao' => ''
            );

            $mapperTbDocumentoAgentes = new Proposta_Model_TbDocumentosAgentesMapper();
            $file = new Zend_File_Transfer();
            $mapperTbDocumentoAgentes->saveCustom($arrayFile, $file);
        }
    }


}