<?php

namespace Application\Modules\Readequacao\Service\TransferenciaRecursos;

class TransferenciaRecursos
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

    public function buscarValoresTransferidos()
    {
        $parametros = $this->request->getParams();
        $idPronac = $parametros['idPronac'];
        $mapper = new \Readequacao_Model_TbSolicitacaoTransferenciaRecursosMapper();
        $mapper->obterTransferenciaRecursosEntreProjetos($idPronac);
    }
}
