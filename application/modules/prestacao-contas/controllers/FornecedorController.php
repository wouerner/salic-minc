<?php

class PrestacaoContas_FornecedorController extends MinC_Controller_Action_Abstract
{
    public function init()
    {


        parent::init();
    }

    public function indexAction()
    {


    }

    public function cidadeAction()
    {
        Zend_Json::$useBuiltinEncoderDecoder = true;

        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout

        $id = $this->_request->getParam("id");

        $cidade = new Cidade();

        $dados = $this->view->combocidades = $cidade->buscar($id);

        $data = [];

        foreach ($dados as $index => $dado) {

                $data[$index]['id']= utf8_encode($dado->id);
                $data[$index]['descricao'] = utf8_encode($dado->descricao);
        };

        $this->_helper->json($data);

    }
}
