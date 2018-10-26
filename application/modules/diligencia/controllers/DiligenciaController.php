<?php

class Diligencia_DiligenciaController extends Zend_Rest_Controller
{
    public function init()
    {
        $this->_helper->getHelper('contextSwitch')
            ->addActionContext('index', 'json')
            ->addActionContext('post', 'json')
            ->initContext('json');
    }

    public function headAction(){}

    public function indexAction()
    {
         $data = array(1 => "to", 12 => 2);
         $this->view->assign('nozes', $data);
         $this->getResponse()->setHttpResponseCode(200);
    }

    public function getAction()
    {}

    public function postAction()
    {
        $idagente = (Zend_Auth::getInstance())->getIdentity()->usu_codigo;
        $idPronac = $this->getRequest()->getParam('idPronac');
        $solicitacao = $this->getRequest()->getParam('solicitacao');
        $idTipoDiligencia = $this->getRequest()->getParam('tpDiligencia');

        if (!$idPronac) {
            throw new Exception('Falta pronac');
        }

        $diligenciaDAO = new Diligencia();
        $auth = Zend_Auth::getInstance();

        if ($diligenciaDAO->existeDiligenciaAberta($idPronac)) {
            $this->view->assign('data',['message' => 'Existe dilig&ecirc;ncia aguardando resposta!']);
            $this->getResponse()->setHttpResponseCode(405);
            return;
        }

        $dados = array(
            'idPronac' => $idPronac,
            'DtSolicitacao' => new Zend_Db_Expr('GETDATE()'),
            'Solicitacao' => $solicitacao,
            'idTipoDiligencia' => $idTipoDiligencia,
            'idProduto' => null,
            'stEstado' => 0,
            'stEnviado' => 'S',
            'idSolicitante' => $idagente
        );

        $rowDiligencia = $diligenciaDAO->inserir($dados);

        $projeto = new Projetos();
        $projeto->alterarSituacao($idPronac, null, 'E17', 'Diligência na prestação de contas');

        $this->view->assign('data',['message' => 'criado!']);
        $this->getResponse()->setHttpResponseCode(201);
    }

    public function putAction()
    {
         $this->getResponse()->setHttpResponseCode(400);
    }

    public function deleteAction()
    {}
}
