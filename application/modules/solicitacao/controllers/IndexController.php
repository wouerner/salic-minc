<?php

class Solicitacao_IndexController extends Solicitacao_GenericController
{

    private $grupoAtivo;

    private $cod_usuario;

    public function init()
    {
        parent::init();

        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
//        parent::perfil();

//        $this->cod_usuario = $this->auth->getIdentity()->usu_codigo;

//        $this->definirModuloDeOrigem();
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

    }

    public function listarAction()
    {
        $this->_helper->layout->disableLayout();
        $idPronac = $this->getRequest()->getParam('idPronac', null);
        $idPreProjeto = $this->getRequest()->getParam('idPreProjeto', null);


        $vwSolicitacoes = new Solicitacao_Model_vwPainelDeSolicitacaoProponente();

        $where = [];
        if($idPronac) {
            $where['idPronac = ?'] = $idPronac;
        }

        if($idPreProjeto) {
            $where['idProjeto = ?'] = $idPreProjeto;
        }

        if($this->usuario['cpf']) {
            $where['idSolicitante = ?'] = $this->_idUsuario;
        }

       $solicitacoes =  $vwSolicitacoes->buscar($where);

        $this->view->arrResult = $solicitacoes;


//        $intUsuOrgao = $grupoAtivo->codGrupo;
        //var_dump($intUsuOrgao, $grupoAtivo->codOrgao);die;
        $dbTable = new Admissibilidade_Model_DbTable_TbMensagemProjeto();
//        if (empty($idPronac)) {
//            $arrWhere = array('tbMensagemProjeto.idMensagemOrigem IS NULL AND tbMensagemProjeto.idDestinatario = ?' => $intUsuCodigo);
//            $arrOrWhere = array("tbMensagemProjeto.idMensagemOrigem IS NULL AND tbMensagemProjeto.idDestinatario = {$intUsuCodigo} AND tbMensagemProjeto.idDestinatarioUnidade = ?" => $intUsuOrgao);
//            $this->view->arrResult = $dbTable->getAllBy($arrWhere, $arrOrWhere);
//        } else {
//            $arrWhere = array('tbMensagemProjeto.idMensagemOrigem IS NULL' => '');
//            $arrWhere['tbMensagemProjeto.IdPRONAC'] = $idPronac;
//            $this->view->arrResult = $dbTable->getAllBy($arrWhere);
//        }
//        $this->view->usuCodigo = $this->_idUsuario;
//        $this->view->usuOrgao = $intUsuOrgao;
        $this->view->idPronac = $idPronac;

    }

    public function solicitarAction()
    {
        $this->view->urlAction = $this->_urlPadrao . "/solicitacao/index/salvar";

        $params = $this->getRequest()->getParams();

        try {

            if (empty($this->idPronac) && empty($this->idPreProjeto)) {
                throw new Exception("Informe o projeto ou proposta para realizar uma solicita&ccedil;&atilde;o");
            }

            $dataForm = [
                'idPronac' => $this->idPronac,
                'idProjeto' => $this->idPreProjeto,
                'siEncaminhamento' => Solicitacao_Model_TbSolicitacao::SOLICITACAO_CADASTRADA
            ];

            if ($this->_projeto) {
                $dataForm['idOrgao'] = $this->_projeto->Orgao;
            } else if ($this->_proposta) {
                $dataForm['idOrgao'] = $this->_proposta->AreaAbrangencia == 0 ? 171 : 262;
            }

            if (isset($params['idSolicitacao'])) {
                $tbSolicitacao = new Solicitacao_Model_DbTable_TbSolicitacao();
                $dataForm = (array) $tbSolicitacao->findBy(['idSolicitacao' => $params['idSolicitacao']]);
            }

            if (!empty($dataForm['idDocumento'])) {
                $tbl = new Arquivo_Model_DbTable_TbDocumento();
                $anexo = $tbl->buscarDocumento($dataForm['idDocumento']);
            }

            $this->view->dataForm = $dataForm;
            $this->view->anexo = $anexo;

        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/solicitacao/", "ERROR");
        }
    }

    public function salvarAction()
    {

        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $arrayForm = $this->getRequest()->getPost();

            $strUrl = '/solicitacao/index/solicitar';
            $strUrl .= ($arrayForm['idPronac']) ? '/idPronac/' . $arrayForm['idPronac'] : '';
            $strUrl .= ($arrayForm['idProposta']) ? '/idproposta/' . $arrayForm['idproposta'] : '';

            # verificar permissao de acesso


            $mapperSolicitacao = new Solicitacao_Model_TbSolicitacaoMapper();
            $this->_helper->json(array('status' => $mapperSolicitacao->salvar($arrayForm), 'msg' => $mapperSolicitacao->getMessages(), 'redirect' => $strUrl));

        }
    }


}