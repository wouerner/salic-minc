<?php

namespace Application\Modules\Readequacao\Service\Readequacao;

use MinC\Servico\IServicoRestZend;

class Readequacao implements IServicoRestZend
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscar($idReadequacao)
    {
        $modelTbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $where = [
            'idReadequacao' => $idReadequacao
        ];

        return $modelTbReadequacao->findBy($where);
    }

    public function buscarReadequacoes($idPronac)
    {
        $modelTbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $where = [
            'idPronac' => $idPronac
        ];

        return $modelTbReadequacao->findBy($where);
    }
    
    public function salvar()
    {
        $parametros = $this->request->getParams();
        $modelTbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao($parametros);
        $mapper = new \Readequacao_Model_TbReadequacaoMapper();
        $idReadequacao = $mapper->save($modelTbReadequacao);
        
        return $this->buscar($idReadequacao);
    }
}
