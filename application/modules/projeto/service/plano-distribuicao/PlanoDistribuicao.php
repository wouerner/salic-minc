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
        $planoDistribuicao = $Projetos->buscar(array('IdPRONAC = ?'=>$idPronac))->current();

        xd($planoDistribuicao);
        if (!empty($idPronac)) {
            $buscarDistribuicao = \RealizarAnaliseProjetoDAO::planodedistribuicao($idPronac);
        }

//        return $itemArray;
    }
}
