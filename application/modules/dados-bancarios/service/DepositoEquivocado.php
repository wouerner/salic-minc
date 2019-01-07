<?php

namespace Application\Modules\DadosBancarios\Service\DepositoEquivocado;

class DepositoEquivocado
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

    public function buscarDepositosEquivocados()
    {
        $idPronac = $this->request->idPronac;
        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        $whereData = ['idPronac = ?' => $idPronac, 'nrLote = ?' => -1];
        $aporteModel = new \tbAporteCaptacao();
        $dados = $aporteModel->pesquisarDepositoEquivocado($whereData)->toArray();

        return $dados;
    }
}
