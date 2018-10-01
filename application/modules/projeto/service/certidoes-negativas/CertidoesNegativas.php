<?php

namespace Application\Modules\Projeto\Service\CertidoesNegativas;

use Seguranca;

class CertidoesNegativas
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

    public function buscaCertidoesNegativas()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        $Projetos = new \Projetos();
        $rs = $Projetos->buscar(array('IdPRONAC = ?' => $idPronac))->current();

        $sv = new \certidaoNegativa();
        $resultado = $sv->buscarCertidaoNegativa($rs->CgcCpf);

        $resultArray = [];
        foreach ($resultado as $item){
            $itemaArray = [
                'dsCertidao' => $item['dsCertidao'],
                'CodigoCertidao' => $item['CodigoCertidao'],
                'DtEmissao' => $item['DtEmissao'],
                'DtValidade' => $item['DtValidade'],
                'Pronac' => $item['Pronac'],
                'Situacao' => $item['Situacao']

            ];

            $resultArray[] = $itemaArray;
        }

        return $resultArray;
    }
}
