<?php

namespace Application\Modules\Proposta\Service\Proposta;

class Visualizar
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

    public function obterSugestaoEnquadramento()
    {
        $idPreProjeto = $this->request->idPreProjeto;

        $sugestaoEnquadramentoDbTable = new \Admissibilidade_Model_DbTable_SugestaoEnquadramento();
        $sugestaoEnquadramentoDbTable->sugestaoEnquadramento->setIdPreprojeto($idPreProjeto);
        $sugestao_enquadramento = $sugestaoEnquadramentoDbTable->obterHistoricoEnquadramento();
        xd($sugestao_enquadramento);
        return $sugestao_enquadramento;
    }
}
