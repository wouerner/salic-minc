<?php

use Application\Modules\Foo\Service\Foo\Bar as BarService;

class Foo_FooRestController extends Zend_Rest_Controller
{
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

    public function indexAction()
    {
        $barService = new BarService($this->getRequest(), $this->getResponse());
        $resposta = $barService->buscarTodos();

        $this->view->assign('data', $resposta);

        $this->getResponse()->setHttpResponseCode(200);
    }

    public function getAction()
    {
        $parametros = $this->getRequest()->getParams();
        $barService = new BarService($this->getRequest(), $this->getResponse());
        $resposta = $barService->buscar($parametros['id']);

        $this->view->assign('data', $resposta);

        $this->getResponse()->setHttpResponseCode(200);
    }

    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function postAction()
    {
        $barService = new BarService($this->getRequest(), $this->getResponse());
        $resposta = $barService->salvarRegistro();

        $this->view->assign('data', $resposta);
        $this->getResponse()->setHttpResponseCode(201);
    }

    public function putAction()
    {
        $barService = new BarService($this->getRequest(), $this->getResponse());
        $resposta = $barService->atualizarRegistro();

        $this->view->assign('data', $resposta);
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function deleteAction()
    {
        $barService = new BarService($this->getRequest(), $this->getResponse());
        $resposta = $barService->removerRegistro();

        $this->getResponse()->setHttpResponseCode(204);
    }
}
