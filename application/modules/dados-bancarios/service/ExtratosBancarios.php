<?php

namespace Application\Modules\DadosBancarios\Service\ExtratosBancarios;

class ExtratosBancarios
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

    public function buscarExtratosBancarios()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }
        if (!empty($idPronac)) {
            $DadosExtrato = new \Projetos();
            $result = $DadosExtrato->painelDadosBancariosExtrato(["idPronac = ?" => $idPronac], null, null, null, false)->toArray();
            return $result;
        }
    }
}

