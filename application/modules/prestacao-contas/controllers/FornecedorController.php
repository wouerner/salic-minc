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

    private function retornaJson($dados) {

        $data = [];
        foreach ($dados as $index => $dado) {
            if(is_array($dado)){
                $data[$index]['id'] = utf8_encode($dado["idVerificacao"]);
                $data[$index]['descricao'] = utf8_encode($dado["Descricao"]);
            } elseif (is_object($dado)){
                $data[$index]['id']= utf8_encode($dado->id);
                $data[$index]['descricao'] = utf8_encode($dado->descricao);
            }elseif(!is_array($dado) and !is_object($dado)){
                $data[$index]['descricao'] = utf8_encode($dado);

            }
        };

        return  $this->_helper->json($data);
    }

    public function ufAction() {
        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout
        $estados = new PrestacaoContas_Model_DbTable_Enderecos();
        var_dump($estados->ufRetorno());
        die;
        $this->retornaJson($estados->ufRetorno());
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

    public function logradouroTipoAction(){
        $mapperVerificacao = new Agente_Model_VerificacaoMapper();
        $tipos = $mapperVerificacao->fetchPairs('idVerificacao', 'Descricao', array('idtipo' => 13));
        $this->retornaJson($tipos);
    }

    public function enderecoTipoAction(){
        $mapperVerificacao = new Agente_Model_VerificacaoMapper();
        $endereco = $mapperVerificacao->fetchPairs('idVerificacao', 'Descricao', array('idtipo' => 2));
        $this->retornaJson($endereco);
    }
}
