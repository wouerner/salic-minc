<?php

namespace Application\Modules\Analise\Service\AnaliseAprovacao;

use Seguranca;

class Recurso implements \MinC\Servico\IServicoRestZend
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

    public function buscarRecursos()
    {
        xd( 'ola');
        $idPronac = $this->request->idPronac;

    }
}
