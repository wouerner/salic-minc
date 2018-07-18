<?php

class PrestacaoContas_FornecedorController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
//        Zend_Json::$useBuiltinEncoderDecoder = true;

        parent::init();
    }

    public function indexAction()
    {

    }

    private function retornaJson($dados) {

        $data = [];
        foreach ($dados as $index => $dado) {
            if(is_array($dado)){
                $data[$index]['id'] = utf8_encode($dado["idVerificacao"]);
                $data[$index]['descricao'] = utf8_encode($dado["Descricao"]);
            } elseif (is_object($dado)){
                $data[$index]['id']= utf8_encode($dado->id);
                $data[$index]['descricao'] = utf8_encode($dado->descricao);
            }
        };

        return  $this->_helper->json($data);
    }

    public function ufAction() {
        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout
        $estados = new Agente_Model_DbTable_UF();
        $this->retornaJson($estados->listar());
    }

    public function cidadeAction() {
        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout
        $id = $this->_request->getParam("id");
        $cidade = new Cidade();
        $this->retornaJson($cidade->buscar($id));
    }

    public function fornecedoresTipoAction(){
        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout
        $consulta = new Agente_Model_DbTable_Visao();
        $this->retornaJson($consulta->buscarVisoes());
    }
}
