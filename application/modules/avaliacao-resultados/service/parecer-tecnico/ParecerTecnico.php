<?php
namespace Application\Modules\AvaliacaoResultados\Service\ParecerTecnico;

class ParecerTecnico
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    function __construct(\Zend_Controller_Request_Abstract $request, \Zend_Controller_Response_Abstract $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarDadosProjeto()
    {
        $tabelaProjetos = new \Projeto_Model_DbTable_Projetos();
        $where = [
            $tabelaProjetos->getPrimary() => $this->request->idPronac
        ];

        return $tabelaProjetos->findBy($where);
    }

//    public function buscarTodos()
//    {
//        $tabelaDbTabela = new \Foo_Model_DbTable_Tabela();
//
//        $registros = $tabelaDbTabela->fetchAll();
//        return $registros->toArray();
//    }
//
//    public function salvar()
//    {
//        $parametros = $this->request->getParams();
//        $tabela = new \Foo_Model_Tabela($parametros);
//        $mapper = new \Foo_Model_TabelaMapper();
//        $codigo = $mapper->save($tabela);
//
//        return $this->buscar($codigo);
//    }
//
//    public function atualizar()
//    {
//        $parametros = $this->request->getParams();
//        $tabela = new \Foo_Model_Tabela($parametros);
//        $mapper = new \Foo_Model_TabelaMapper();
//        $codigo = $mapper->save($tabela);
//
//        return $this->buscar($codigo);
//    }
//
//    public function remover()
//    {
//        $parametros = $this->request->getParams();
//        $tabela = $this->buscar($parametros['id']);
//        $mapper = new \Foo_Model_TabelaMapper();
//        $id = (int) $tabela['Codigo'];
//        $mapper->delete($id);
//    }
}
