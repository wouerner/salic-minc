<?php

class Foo_FooRestController extends Zend_Rest_Controller
{
    public function init()
    {
        $this->_helper->getHelper('contextSwitch')
            ->addActionContext('index', 'json')
            ->addActionContext('post', 'json')
            ->addActionContext('get', 'json')
            ->addActionContext('head', 'json')
            ->addActionContext('put', 'json')
            ->addActionContext('delete', 'json')
            ->initContext('json');
    }

    public function indexAction()
    {
//        $fooModel = new Foo_Model_Foo();
//        $this->view->foos = $fooModel->listar();
//
//        $tooModel = new Foo_Model_Too();
//        $this->view->toos = $tooModel->listar();
//        $dataAux = $_GET;
//        $this->view->assign('data', $dataAux);
//        $this->getResponse()->setHttpResponseCode(200);
    }

    public function getAction()
    {
        $dataAux = $_REQUEST;
        $this->view->assign('data', $dataAux);
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function postAction()
    {
        $this->getResponse()->setHttpResponseCode(201);
    }

    public function putAction()
    {
        $dataAux = $_REQUEST;
        $this->view->assign('data', $dataAux);
        $this->getResponse()->setHttpResponseCode(200);
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function deleteAction()
    {
        $this->getResponse()->setHttpResponseCode(204);
    }
}
