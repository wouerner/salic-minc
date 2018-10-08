<?php

namespace Application\Modules\Projeto\Service\ProvidenciaTomada;

use Seguranca;

class ProvidenciaTomada
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

    public function buscaProvidenciaTomada()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }


        $tblHisSituacao = new \HistoricoSituacao();
        $total = $tblHisSituacao->buscarHistoricosEncaminhamentoIdPronac($idPronac, null, null, null, true);
xd($total);

        return $total;
    }

}
