<?php

class PrestacaoContas_FornecedorController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        Zend_Json::$useBuiltinEncoderDecoder = true;
        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout

        parent::init();
    }

    public function indexAction()
    {

    }

    private function retornaJson($dados) {
        $data = [];
        foreach ($dados as $index => $dado) {

            $data[$index]['id']= utf8_encode($dado->id);
            $data[$index]['descricao'] = utf8_encode($dado->descricao);
        };

        return  $this->_helper->json($data);
    }

    public function ufAction() {
        $estados = new Agente_Model_DbTable_UF();
        $lista = $this->view->comboEstados = $estados->listar();
        $this->retornaJson($lista);
    }

    public function cidadeAction() {
        $id = $this->_request->getParam("id");
        $cidade = new Cidade();
        $dados = $this->view->combocidades = $cidade->buscar($id);
        $this->retornaJson($dados);

    }
}
