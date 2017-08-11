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
        if ($idPronac) {
            $where['idPronac = ?'] = $idPronac;
        }

        if ($idPreProjeto) {
            $where['idProjeto = ?'] = $idPreProjeto;
        }

        if ($this->usuario['cpf']) {
            $where['idSolicitante = ?'] = $this->_idUsuario;
        }

        $solicitacoes = $vwSolicitacoes->buscar($where);

        $this->view->arrResult = $solicitacoes;
        $this->view->idPronac = $idPronac;

    }

    /**
     * Metodo responsavel por preparar o formulario conforme cada acao.
     *
     * @name prepareForm
     * @param array $arrConfig
     *
     */
    public function prepareForm($dataForm = [], $arrConfig = array(), $strUrlAction = '', $strActionBack = 'index')
    {
        if ($this->arrProjeto) {
            $arrConfig['idDestinatario'] = array('show' => true);
            $arrConfig['idDestinatario'] = array('show' => false);
        }
        $intId = $this->getRequest()->getParam('id', null);

        $vwSolicitacao = new Solicitacao_Model_vwPainelDeSolicitacaoProponente();
        if ($intId && empty($dataForm)) {
            $dataForm = $vwSolicitacao->findBy(['idSolicitacao' => $intId]);
        }

        if (!empty($dataForm['idDocumento'])) {
            $tbl = new Arquivo_Model_DbTable_TbDocumento();
            $dataForm['arquivo'] = $tbl->buscarDocumento($dataForm['idDocumento'])->toArray();
        }

        if( $this->_proposta) {
            $dataForm['idProjeto'] = $this->idPreProjeto;
            $dataForm['NomeProjeto'] = isset($this->_proposta->NomeProjeto) ? $this->_proposta->NomeProjeto : '';
        }

        if ($this->_projeto) {
            $dataForm['Pronac'] = $this->_projeto->AnoProjeto . $this->_projeto->Sequencial;
            $dataForm['NomeProjeto'] = isset($this->_projeto->NomeProjeto) ? $this->_projeto->NomeProjeto : '';
            $dataForm['idPronac'] = $this->idPronac;
        }

        $this->view->arrPartial = array(
            'dataForm' => $dataForm,
            'arrConfig' => $arrConfig,
            'id' => $intId,
            'urlAction' => $strUrlAction,
            'strActionBack' => $strActionBack,
            'currentUrl' => Zend_Controller_Front::getInstance()->getRequest()->getRequestUri()
        );
    }

    public function solicitarAction()
    {

        $params = $this->getRequest()->getParams();
        $urlAction = $this->_urlPadrao . "/solicitacao/index/salvar";

        try {

            if (empty($this->idPronac) && empty($this->idPreProjeto))
                throw new Exception("Informe o projeto ou proposta para realizar uma solicita&ccedil;&atilde;o");

            $dataForm = [
                'siEncaminhamento' => Solicitacao_Model_TbSolicitacao::SOLICITACAO_CADASTRADA
            ];

            if ($this->_projeto) {
                $dataForm['idOrgao'] = $this->_projeto->Orgao;
            } else if ($this->_proposta) {
                $dataForm['idOrgao'] = $this->_proposta->AreaAbrangencia == 0 ? 171 : 262;
            }

            if (isset($params['idSolicitacao'])) {
                $tbSolicitacao = new Solicitacao_Model_DbTable_TbSolicitacao();
                $dataForm = (array)$tbSolicitacao->findBy(['idSolicitacao' => $params['idSolicitacao']]);
            }

            self::prepareForm($dataForm, [], $urlAction);


        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/solicitacao/", "ERROR");
        }
    }

    public function salvarAction()
    {
        # verificar permissao de acesso

        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $arrayForm = $this->getRequest()->getPost();

            $strUrl = '/solicitacao/index/solicitar';
            $strUrl .= ($arrayForm['idPronac']) ? '/idPronac/' . $arrayForm['idPronac'] : '';
            $strUrl .= ($arrayForm['idProposta']) ? '/idproposta/' . $arrayForm['idproposta'] : '';

            $mapperSolicitacao = new Solicitacao_Model_TbSolicitacaoMapper();
            $this->_helper->json(array('status' => $mapperSolicitacao->salvar($arrayForm), 'msg' => $mapperSolicitacao->getMessages(), 'redirect' => $strUrl));

        }
    }

    /**
     * Acao responsavel por responder uma mensagem
     *
     * @name responderAction
     *
     */
    public function responderAction()
    {
        $strActionBack = $this->getRequest()->getParam('actionBack');
        $strActionBack = ($strActionBack) ? $strActionBack : 'index';

        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

            $strUrl = '/solicitacao/index/' . $strActionBack;
            $strUrl .= ($this->arrProjeto) ? '?idPronac=' . $this->arrProjeto['IdPRONAC'] : '';
            $mapperSolicitacao = new Solicitacao_Model_TbSolicitacaoMapper();
            $this->_helper->json(array('status' => $mapperSolicitacao->salvar($this->getRequest()->getPost()), 'msg' => $mapperSolicitacao->getMessages(), 'redirect' => $strUrl));
        } else {

            $arrConfig = [
                'dsSolicitacao' => ['disabled' => true],
                'dsResposta' => ['disabled' => false]
            ];

            self::prepareForm([], $arrConfig, '', $strActionBack);
        }

        $this->view->arrConfig['dsMensagem'] = ['disabled' => true];
    }

    public function abrirdocumentosolicitacaoAction()
    {
        # verificar se o usuario tem permissao para acessar este documento

        $idDocumento = $this->getRequest()->getParam('id', null);

        parent::abrirDocumento($idDocumento);
    }
}