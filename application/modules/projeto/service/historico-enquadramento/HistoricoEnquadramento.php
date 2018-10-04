<?php

namespace Application\Modules\Projeto\Service\HistoricoEnquadramento;

use Seguranca;

class HistoricoEnquadramento
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

    public function buscaHistoricoEnquadramento()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        if (!empty($idPronac)) {
            //****** Dados do Projeto - Cabecalho *****//
            $projetos = new \Projetos();
            $DadosProjeto = $projetos->dadosProjeto(array('idPronac = ?' => $idPronac))->current();

            $tbDistribuirParecer = new \tbDistribuirParecer();
            $historicoEnquadramento = $tbDistribuirParecer->buscarHistoricoEncaminhamento(array('a.idPRONAC = ?'=>$idPronac));
        }
        $resultArray = [];

        $enquadramentos = $this->montaArrayHistoricoEnquadramento($historicoEnquadramento);

        $informacoes['Pronac'] = $DadosProjeto['AnoProjeto'] + $DadosProjeto['Sequencial'];
        $informacoes['NomeProjeto'] = $DadosProjeto['NomeProjeto'];

        $resultArray['enquadramentos'] = $enquadramentos;
        $resultArray['informacoes'] = $informacoes;

        return $resultArray;
    }

    private function montaArrayHistoricoEnquadramento($historicoEnquadramento) {
        $result = [];

        foreach ($historicoEnquadramento as $item) {
            $produto = html_entity_decode(utf8_encode($item['Produto']));
            $unidade = html_entity_decode(utf8_encode($item['Unidade']));
            $observacao = html_entity_decode(utf8_encode($item['Observacao']));

            $result[] = [
                'Produto' => $produto,
                'Unidade' => $unidade,
                'Observacao' => $observacao,
                'DtEnvio' => $item['DtEnvio'],
                'DtRetorno' => $item['DtRetorno'],
                'qtDias' => $item['qtDias']
            ];

        }
        return $result;
    }

}
