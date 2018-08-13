<?php
use Application\Modules\Projeto\Service\Proponente\Proponente as ProponenteService;

class Projeto_ProponenteRestController extends Zend_Rest_Controller
{
    protected $idAgente = 0;
    private $idPreProjeto = 0;

    public function init()
    {
        $this->_helper->getHelper('contextSwitch')
            ->addActionContext('get', 'json')
            ->addActionContext('index', 'json')
            ->addActionContext('post', 'json')
            ->addActionContext('put', 'json')
            ->addActionContext('delete', 'json')
            ->initContext('json');
    }

    public function getAction()
    {
        // xd('Agora foi aqui');
        $this->_helper->layout->disableLayout(); // Desabilita o Zend Layout
        $ProponenteService = new ProponenteService($this->getRequest(), $this->getResponse());
        $resposta = $ProponenteService->buscarDadosAgenteProponente();
        xd($resposta);
        $this->view->assign('data', $resposta);
    }
    
    public function indexAction()
    {
        $this->getResponse()
             ->setHttpResponseCode(200);
    }

    public function postAction()
    {
        $this->getResponse()
             ->setHttpResponseCode(201);
    }

    public function putAction()
    {
        $this->getResponse()
             ->setHttpResponseCode(200);
    }

    public function deleteAction()
    {
        $this->getResponse()
             ->setHttpResponseCode(204);
    }

    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(200);
    }
}