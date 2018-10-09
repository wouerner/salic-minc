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

    public function buscaDiligenciaProjeto()
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
                xd($diligenciasProposta);
            }
        }
            $diligencias = $tblProjeto->listarDiligencias(array('pro.IdPRONAC = ?' => $idPronac, 'dil.stEnviado = ?' => 'S'));

            $tbAvaliarAdequacaoProjeto = new \Analise_Model_DbTable_TbAvaliarAdequacaoProjeto();
            $diligenciasAdequacao = $tbAvaliarAdequacaoProjeto->obterAvaliacoesDiligenciadas(['a.idPronac = ?' => $idPronac]);
    }

    private function montarArrayDiligenciaProposta($diligenciasProposta)
    {
        $resultArray = [];

        foreach ($diligenciasProposta as $diligencia) {
            $resultArray[] = [
                'idPreprojeto' => $diligencia['pronac'],
                'nomeProposta' => $diligencia['nomeProjeto'],
                'dataSolicitacao' => $diligencia['dataSolicitacao'],
                'dataResposta' => $diligencia['dataResposta'],
                'Solicitacao' => $diligencia['Solicitacao'],
                'Resposta' => $diligencia['Resposta'],
            ];
        }

        return $resultArray;
    }

    private function montarArrayDiligenciaProjeto($diligencias)
    {
        $resultArray = [];

        foreach ($diligencias as $diligencia) {
            $qtdia = 40;
            $resultArray[] = [
                'pronac' => $diligencia['pronac'],
                'produto' => $diligencia['produto'],
                'tipoDiligencia' => $diligencia['tipoDiligencia'],
                'dataSolicitacao' => $diligencia['dataSolicitacao'],
                'dataResposta' => $diligencia['dataResposta'],
                'prazoResposta' => strtotime($diligencia['dataSolicitacao'].' +'.$qtdia.' day'),
                'nomeProjeto' => $diligencia['nomeProjeto'],
                'Solicitacao' => $diligencia['Solicitacao'],
                'Resposta' => $diligencia['Resposta'],
            ];
        }

        return $resultArray;
    }

    private function buscarAnexosDiligenciasProjeto($idDiligencia)
    {
        $arquivo = new \Arquivo();
        $arquivos = $arquivo->buscarAnexosDiligencias($idDiligencia);

        return $arquivos;
    }
}
