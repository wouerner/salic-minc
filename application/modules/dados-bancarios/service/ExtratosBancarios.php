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

    public function buscarPorDataExtratosBancarios()
    {
        $idPronac = $this->request->idPronac;
        $dtLancamento = $this->request->dtLancamento;
        $dtLancamentoFim = $this->request->dtLancamentoFim;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }
        if (!empty($idPronac)) {
            $DadosExtrato = new \Projetos();

            $where = array();
            $where['idPronac = ?'] = $idPronac;

            if (isset($dtLancamentoFim) && isset($dtLancamentoFim)) {
                $di = ConverteData($dtLancamentoFim, 13)." 00:00:00";
                $df = ConverteData($dtLancamentoFim, 13)." 00:00:00";
                $where["dtLancamento BETWEEN '$di' AND '$df'"] = '';
            }

            $result = $DadosExtrato->painelDadosBancariosExtrato($where, null, null, null, false)->toArray();
            return $result;
        }
    }
}

