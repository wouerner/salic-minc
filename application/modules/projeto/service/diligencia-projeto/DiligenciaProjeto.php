<?php

namespace Application\Modules\Projeto\Service\DiligenciaProjeto;

use Seguranca;

class DiligenciaProjeto
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

    public function buscarListaDiligenciaProjeto()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        if (!empty($idPronac)) {
            $tblProjeto = new \Projetos();
            $tblPreProjeto = new \Proposta_Model_DbTable_PreProjeto();
            $projeto = $tblProjeto->buscar(array('IdPRONAC = ?' => $idPronac))->current();

            if (isset($projeto->idProjeto) && !empty($projeto->idProjeto)) {
                $diligenciasProposta = $tblPreProjeto->listarDiligenciasPreProjeto(array('pre.idPreProjeto = ?' => $projeto->idProjeto,'aval.ConformidadeOK = ? '=>0));
                $proposta = $this->montarArrayDiligenciaProposta($diligenciasProposta);
            }
        }
            $diligencias = $tblProjeto->listarDiligencias(array('pro.IdPRONAC = ?' => $idPronac, 'dil.stEnviado = ?' => 'S'));
            $diligencia = $this->montarArrayDiligenciaProjeto($diligencias);

            $tbAvaliarAdequacaoProjeto = new \Analise_Model_DbTable_TbAvaliarAdequacaoProjeto();
            $diligenciasAdequacao = $tbAvaliarAdequacaoProjeto->obterAvaliacoesDiligenciadas(['a.idPronac = ?' => $idPronac]);
            $adequacao = $this->montarArrayDiligenciaAdequacao($diligenciasAdequacao);
            xd($adequacao);
    }

    private function montarArrayDiligenciaProposta($diligenciasProposta)
    {
        $resultArray = [];

        foreach ($diligenciasProposta as $diligencia) {
            $objDateTimedataSolicitacao = new \DateTime($diligencia['dataSolicitacao']);

            $resultArray[] = [
                'idPreprojeto' => $diligencia['pronac'],
                'dataSolicitacao' => $objDateTimedataSolicitacao->format('d/m/Y H:i:s'),
            ];
        }

        return $resultArray;
    }

    private function montarArrayDiligenciaProjeto($diligencias)
    {
        $resultArray = [];

        foreach ($diligencias as $diligencia) {
            $tipoDiligencia = html_entity_decode(utf8_encode($diligencia['tipoDiligencia']));
            $objDateTimedataSolicitacao = new \DateTime($diligencia['dataSolicitacao']);
            $objDateTimedataResposta = new \DateTime($diligencia['dataResposta']);

            $qtdia = 40;
            $resultArray[] = [
                'produto' => $diligencia['produto'],
                'tipoDiligencia' => $tipoDiligencia,
                'dataSolicitacao' => $objDateTimedataSolicitacao->format('d/m/Y H:i:s'),
                'dataResposta' => $objDateTimedataResposta->format('d/m/Y H:i:s'),
                'prazoResposta' => strtotime($diligencia['dataSolicitacao'].' +'.$qtdia.' day'),
            ];
        }

        return $resultArray;
    }

    private function montarArrayDiligenciaAdequacao($diligenciasAdequacao)
    {
        $resultArray = [];

        foreach ($diligenciasAdequacao as $diligencia) {
            $objDateTimedtAvaliacao = new \DateTime($diligencia['dtAvaliacao']);

            $qtdia = 40;
            $resultArray[] = [
                'tipoDiligencia' => 'Dilig&ecirc;ncia na An&aacute;lise da adequa&ccedil;&atilde;o &agrave; realidade do projeto.',
                'dtAvaliacao' => $objDateTimedtAvaliacao->format('d/m/Y H:i:s'),
            ];
        }

        return $resultArray;
    }
}
