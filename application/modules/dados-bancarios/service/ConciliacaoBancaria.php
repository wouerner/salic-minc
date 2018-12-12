<?php

namespace Application\Modules\DadosBancarios\Service\ConciliacaoBancaria;

class ConciliacaoBancaria
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

    public function buscarConciliacaoBancaria()
    {
        $idPronac = $this->request->idPronac;
        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        if (!empty($idPronac)) {
            $where = array();
            $where['idPronac = ?'] = $idPronac;
            $DadosConciliacao = new \Projetos();

            $buscaDadosConciliacao = $DadosConciliacao->painelDadosConciliacaoBancaria($where, ['dtPagamento DESC'], null, null)->toArray();

            return $buscaDadosConciliacao;
        }
    }
}

