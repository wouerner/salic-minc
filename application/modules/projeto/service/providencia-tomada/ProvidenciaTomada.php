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

        $pronacArray = [];
        $pronacArray['p.IdPRONAC = ?'] = $idPronac;

        $tblHisSituacao = new \HistoricoSituacao();
        $result = $tblHisSituacao->buscarHistoricosEncaminhamentoIdPronac($pronacArray, null, null, null, false);

        $providenciaTomada = $this->montaArrayProvidenciaTomada($result);

        return $resultArray;
    }

    private function montaArrayProvidenciaTomada($providenciaTomada)
    {
        $resultArray = [];

        foreach ($providenciaTomada as $providencia) {
            $resultArray[] = [
                'DtSituacao' => $providencia['DtSituacao'],
                'Situacao' => $providencia['Situacao'],
                'ProvidenciaTomada' => $providencia['ProvidenciaTomada'],
                'cnpjcpf' => $providencia['cnpjcpf'],
                'usuario' => $providencia['usuario']
            ];
        }

        return $resultArray;
    }

}
