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
        $mapper = new \Readequacao_Model_TbTransferenciaRecursosEntreProjetosMapper();

        $result = $mapper->obterTransferenciaRecursosEntreProjetos($idPronac);

        return $this->utf8Encode($result);
    }

    private function utf8Encode($result)
    {
        array_walk($result, function (&$value) {
            $value = array_map('utf8_encode', $value->toArray());
        });

        return $result;
    }
}
