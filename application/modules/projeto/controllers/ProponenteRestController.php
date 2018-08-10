<?php

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
        xd('chega Aqui');
        $this->_helper->layout->disableLayout(); // Desabilita o Zend Layout
        $barService = new BarService($this->getRequest(), $this->getResponse());
    }
}