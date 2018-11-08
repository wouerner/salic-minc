<?php

namespace Application\Modules\Projeto\Service\Tramitacao;

use Seguranca;

class UltimaTramitacao implements \MinC\Servico\IServicoRestZend
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

    public function buscarUltimaTramitacaoProjeto()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        $tblProjetos = new \Projetos();
        $rst = $tblProjetos->buscarDadosUC75($idPronac);

        $tramitacoes = $this->obterUltimaTramitacao($rst);

        $tramitacoes = \TratarArray::utf8EncodeArray($tramitacoes);

        return $tramitacoes;
    }

    private function obterUltimaTramitacao($tramitacoes)
    {
        $resultArray = [];
        foreach ($tramitacoes as $tramitacao) {
            $Emissor = $tramitacao['Emissor'];
            $Receptor = $tramitacao['Receptor'];
            $meDespacho = $tramitacao['meDespacho'];
            $objDateTimeDtTramitacaoEnvio = new \DateTime($tramitacao['DtTramitacaoEnvio']);
            $objDateTimedtTramitacaoRecebida = new \DateTime($tramitacao['dtTramitacaoRecebida']);

            $resultArray[] = [
                'Emissor' => $Emissor,
                'dtTramitacaoEnvio' => $objDateTimeDtTramitacaoEnvio->format('d/m/Y H:i:s'),
                'Receptor' => $Receptor,
                'dtTramitacaoRecebida' => $objDateTimedtTramitacaoRecebida->format('d/m/Y H:i:s'),
                'Estado' => $tramitacao['Estado'],
                'Destino' => $tramitacao['Destino'],
                'meDespacho' => $meDespacho,
            ];
        }

        return $resultArray;
    }

}
