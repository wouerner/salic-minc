<?php

namespace Application\Modules\Analise\Service\AnaliseAprovacao;

use Seguranca;

class Aprovacao implements \MinC\Servico\IServicoRestZend
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

    public function buscarAprovacao()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        $tblProjeto = new \Projetos();
        $rsProjeto = $tblProjeto->buscar(array("IdPronac=?"=>$idPronac))->current();
        $pronac = $rsProjeto->AnoProjeto.$rsProjeto->Sequencial;

        $tblAprovacao = new \Aprovacao();
        $rsAprovacao = $tblAprovacao->buscaCompleta(array('a.AnoProjeto + a.Sequencial = ?'=>$pronac), array('a.idAprovacao ASC'));

        // $Projetos = new \Projetos();
        // $rs = $Projetos->buscar(array('IdPRONAC = ?' => $idPronac))->current();



        $resultArray = [];

        return $resultArray;
    }
}
