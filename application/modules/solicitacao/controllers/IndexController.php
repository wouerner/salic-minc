<?php

class Solicitacao_IndexController extends Solicitacao_GenericController
{

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {

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

        $intId = $this->getRequest()->getParam('id', null);

        $vwSolicitacao = new Solicitacao_Model_vwPainelDeSolicitacaoProponente();
        if ($intId && empty($dataForm)) {
            $dataForm = $vwSolicitacao->findBy(['idSolicitacao' => $intId]);
        }

        if (!empty($dataForm['idDocumento'])) {
            $tbl = new Arquivo_Model_DbTable_TbDocumento();
            $dataForm['arquivo'] = $tbl->buscarDocumento($dataForm['idDocumento'])->toArray();
        }

        if ($this->_proposta) {
            $dataForm['idProjeto'] = $this->_idPreProjeto;
            $dataForm['NomeProjeto'] = isset($this->_proposta->NomeProjeto) ? $this->_proposta->NomeProjeto : '';
        }

        if ($this->_projeto) {
            $dataForm['Pronac'] = $this->_projeto->AnoProjeto . $this->_projeto->Sequencial;
            $dataForm['NomeProjeto'] = isset($this->_projeto->NomeProjeto) ? $this->_projeto->NomeProjeto : '';
            $dataForm['idPronac'] = $this->_idPronac;
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

        if ($this->_usuario['cpf']) {
            $where['idSolicitante = ?'] = $this->_idUsuario;
        }

        $solicitacoes = $vwSolicitacoes->buscar($where);

        $this->view->arrResult = $solicitacoes;
        $this->view->idPronac = $idPronac;

    }

    public function visualizarAction()
    {
        $urlAction = $this->_urlPadrao . "/solicitacao/index/salvar";

        try {

            $idSolicitacao = $this->getRequest()->getParam('id', null);

            if (empty($idSolicitacao))
                throw new Exception("Informe o id da solicita&ccedil;&atilde;o para visualizar!");

            $arrConfig['dsResposta']['show'] = true;

            self::prepareForm([], $arrConfig, $urlAction);

        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/solicitacao/", "ALERT");
        }
    }


    public function solicitarAction()
    {
        $urlAction = $this->_urlPadrao . "/solicitacao/index/salvar";
        $urlCallBack = $this->_urlPadrao . "/solicitacao/index/index";

        try {

            if (empty($this->_idPronac) && empty($this->_idPreProjeto))
                throw new Exception("Informe o projeto ou proposta para realizar uma solicita&ccedil;&atilde;o");

            $dataForm = [
                'siEncaminhamento' => Solicitacao_Model_TbSolicitacao::SOLICITACAO_CADASTRADA
            ];

            $arrConfig['dsSolicitacao']['disabled'] = false;
            $arrConfig['actions']['show'] = true;

            if ($this->_projeto) {
                $dataForm['idOrgao'] = $this->_projeto->Orgao;
                $urlCallBack .= '/idPronac/' . $this->_idPronac;
                $dataForm['idPronac'] = $this->_idPronac;
            } else if ($this->_proposta) {
                $dataForm['idOrgao'] = $this->_proposta->AreaAbrangencia == 0 ? 171 : 262;
                $urlCallBack .= '/idPreProjeto/' . $this->_idPreProjeto;
                $dataForm['idProjeto'] = $this->_idPreProjeto;
            }

            $mapperSolicitacao = new Solicitacao_Model_TbSolicitacaoMapper();

            if($mapperSolicitacao->existeSolicitacaoNaoRespondida($dataForm))
                throw new Exception("Voc&ecirc; j&aacute; possui uma solicita&ccedil;&atilde;o aguardando resposta para este projeto!");

            self::prepareForm($dataForm, $arrConfig, $urlAction, $urlCallBack);


        } catch (Exception $objException) {
            parent::message($objException->getMessage(), $urlCallBack, "ALERT");
        }
    }

    public function salvarAction()
    {
        # verificar permissao de acesso
        $status = false;

        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $arrayForm = $this->getRequest()->getPost();

            $strUrl = '/solicitacao/index/solicitar';
            $strUrl .= ($arrayForm['idPronac']) ? '/idPronac/' . $arrayForm['idPronac'] : '';
            $strUrl .= ($arrayForm['idProposta']) ? '/idproposta/' . $arrayForm['idproposta'] : '';

            $mapperSolicitacao = new Solicitacao_Model_TbSolicitacaoMapper();

            $idSolicitacao = $mapperSolicitacao->salvar($arrayForm);

            if ($idSolicitacao) {
                $strUrl = '/solicitacao/index/visualizar/id/' . $idSolicitacao;
                $status = true;
            }

            $this->_helper->json(array('status' => $status, 'msg' => $mapperSolicitacao->getMessages(), 'redirect' => $strUrl));

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
        $idSolicitacao = $this->getRequest()->getParam('id');
        $strActionBack = $this->getRequest()->getParam('actionBack');
        $strActionBack = ($strActionBack) ? $strActionBack : 'solicitacao';
        try {

            if ($this->getRequest()->isPost()) {
                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);

                $strUrl = '/solicitacao/index/' . $strActionBack;
                $strUrl .= ($this->arrProjeto) ? '?idPronac=' . $this->arrProjeto['IdPRONAC'] : '';
                $mapperSolicitacao = new Solicitacao_Model_TbSolicitacaoMapper();
                $this->_helper->json(array('status' => $mapperSolicitacao->responder($this->getRequest()->getPost()), 'msg' => $mapperSolicitacao->getMessages(), 'redirect' => $strUrl));
            } else {

                $arrConfig = [
                    'dsSolicitacao' => ['disabled' => true],
                    'dsResposta' => ['disabled' => false]
                ];

                $mapperSolicitacao = new Solicitacao_Model_TbSolicitacaoMapper();

                if ($mapperSolicitacao->existeSolicitacaoNaoRespondida($dataForm['idSolicitacao'] = $idSolicitacao))
                    throw new Exception("Voc&ecirc; j&aacute; possui uma solicita&ccedil;&atilde;o aguardando resposta para este projeto!");

                self::prepareForm([], $arrConfig, '', $strActionBack);
            }

            $this->view->arrConfig['dsMensagem'] = ['disabled' => true];

        } catch (Exception $objException) {
            parent::message($objException->getMessage(), $strActionBack, "ALERT");
        }
    }

    public function abrirdocumentosolicitacaoAction()
    {
        # verificar se o usuario tem permissao para acessar este documento

        $idDocumento = $this->getRequest()->getParam('id', null);

        parent::abrirDocumento($idDocumento);
    }
}