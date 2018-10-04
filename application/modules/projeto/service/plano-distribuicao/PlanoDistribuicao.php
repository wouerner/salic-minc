<?php

namespace Application\Modules\Projeto\Service\PlanoDistribuicao;

use Seguranca;

class PlanoDistribuicao
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

    public function buscaPlanoDistribuicao()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        $Projetos = new \Projetos();
        $projeto = $Projetos->buscar(array('IdPRONAC = ?'=>$idPronac))->current();

        $informacoes['Pronac'] = $projeto['AnoProjeto'] . $projeto['Sequencial'];
        $informacoes['NomeProjeto'] = $projeto['NomeProjeto'];
        $resultArray['informacoes'] = $informacoes;

        if (!empty($idPronac)) {
            $buscarDistribuicao = \RealizarAnaliseProjetoDAO::planodedistribuicao($idPronac);
        }

        foreach ($buscarDistribuicao as $item) {

            $resultArray[] = [
                'idPlanoDistribuicao' => $item->idPlanoDistribuicao,
                'idProjeto' => $item->idProjeto,
                'idProduto' => $item->idProduto,
                'stPrincipal' => $item->stPrincipal,
                'QtdeProduzida' => $item->QtdeProduzida,
                'QtdeProponente' => $item->QtdeProponente,
                'QtdeVendaNormal' => $item->QtdeVendaNormal,
                'QtdePatrocinador' => $item->QtdePatrocinador,
                'QtdeOutros' => $item->QtdeOutros,
                'QtdeVendaPromocional' => $item->QtdeVendaPromocional,
                'Produto' => utf8_encode($item->Produto),
                'Area' => utf8_encode($item->Area),
                'Segmento' => utf8_encode($item->Segmento),
                'PosicaoDaLogo' => utf8_encode($item->PosicaoDaLogo)
            ];
        }

        return $resultArray;
    }
}
