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

        $Aprovacao = $this->montaArrayAprovacao($rsAprovacao);
        $resultArray['Aprovacao'] = $Aprovacao;

        return $resultArray;
    }

    private function montaArrayAprovacao($aprovacoes)
    {
        $resultArray = [];

        foreach ($aprovacoes as $aprovacao) {
            $TipoAprovacao = html_entity_decode(utf8_encode($aprovacao['TipoAprovacao']));
            $ResumoAprovacao = html_entity_decode(utf8_encode($aprovacao['ResumoAprovacao']));
            $objDateTimeDtAprovacao = new \DateTime($aprovacao['DtAprovacao']);
            $objDateTimeDtPortariaAprovacao = new \DateTime($aprovacao['DtPortariaAprovacao']);
            $objDateTimeDtPublicacaoAprovacao = new \DateTime($aprovacao['DtPublicacaoAprovacao']);
            $objDateTimeDtInicioCaptacao = new \DateTime($aprovacao['DtInicioCaptacao']);
            $objDateTimeDtFimCaptacao = new \DateTime($aprovacao['DtFimCaptacao']);
            $resultArray[] = [
                'TipoAprovacao' => $TipoAprovacao,
                'DtAprovacao' => $objDateTimeDtAprovacao->format('d/m/Y'),
                'DtPortariaAprovacao' => $objDateTimeDtPortariaAprovacao->format('d/m/Y'),
                'PortariaAprovacao' => $aprovacao['PortariaAprovacao'],
                'DtPublicacaoAprovacao' => $objDateTimeDtPublicacaoAprovacao->format('d/m/Y'),
                'DtInicioCaptacao' => $objDateTimeDtInicioCaptacao->format('d/m/Y'),
                'DtFimCaptacao' => $objDateTimeDtFimCaptacao->format('d/m/Y'),
                'Mecanismo' => $aprovacao['Mecanismo'],
                'ResumoAprovacao' => $ResumoAprovacao
            ];
        }

        return $resultArray;
    }
}
