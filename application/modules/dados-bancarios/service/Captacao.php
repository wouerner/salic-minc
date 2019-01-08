<?php

namespace Application\Modules\DadosBancarios\Service\Captacao;

class Captacao
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

    public function buscarCaptacao()
    {
        $idPronac = $this->request->idPronac;
        $dtReciboInicio = $this->request->dtReciboInicio;
        $dtReciboFim = $this->request->dtReciboFim;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }
        if (!empty($idPronac)) {
            $Captacao = new \Captacao();

            $where = array();
            $where['p.idPronac = ?'] = $idPronac;

            if (!empty($dtReciboInicio) && !empty($dtReciboFim)) {
                $di = ConverteData($dtReciboInicio, 13)." 00:00:00";
                $df = ConverteData($dtReciboFim, 13)." 00:00:00";
                $where["dtLancamento BETWEEN '$di' AND '$df'"] = '';
            }

            $result = $Captacao->painelDadosBancariosCaptacao($where, null, null, null, false)->toArray();

            return $result;
        }
    }
}

