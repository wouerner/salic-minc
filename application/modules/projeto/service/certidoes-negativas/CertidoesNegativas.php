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
        foreach ($resultado as $item) {
            $dsCertidao = html_entity_decode($item['dsCertidao']);
            $situacao = html_entity_decode($item['Situacao']);
            $objDateTimeDtEmissao = new \DateTime($item['DtEmissao']);
            $objDateTimeDtValidade = new \DateTime($item['DtValidade']);

            $itemaArray = [
                'dsCertidao' => $dsCertidao,
                'CodigoCertidao' => $item['CodigoCertidao'],
                'DtEmissao' => $objDateTimeDtEmissao->format('d/m/Y H:i:s'),
                'DtValidade' => $objDateTimeDtValidade->format('d/m/Y H:i:s'),
                'Pronac' => $item['Pronac'],
                'Situacao' => $situacao,
            ];

            $resultArray[] = $itemaArray;
        }

        $resultArray['Pronac'] = $resultado[0]['Pronac'];
        $resultArray['NomeProjeto'] = $rs['NomeProjeto'];

        return $resultArray;
    }
}
