<?php

namespace Application\Modules\Projeto\Service\PlanoDistribuicao;

use Seguranca;
//vai ser usado para ins2018
class PlanoDistribuicao
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

    public function buscaPlanoDistribuicao()
    {
        $idPreProjeto = $this->request->idPreProjeto;

        $tbPlanoDistribuicao = new \Proposta_Model_DbTable_PlanoDistribuicaoProduto();
        $dados['planodistribuicaoproduto'] = $tbPlanoDistribuicao->buscar(array('idProjeto = ?' => $idPreProjeto))->toArray();
        $dados['tbdetalhaplanodistribuicao'] = $tbPlanoDistribuicao->buscarPlanoDistribuicaoDetalhadoByIdProjeto($idPreProjeto);
        $dados = \TratarArray::utf8EncodeArray($dados);

        return $dados;

    }
}
