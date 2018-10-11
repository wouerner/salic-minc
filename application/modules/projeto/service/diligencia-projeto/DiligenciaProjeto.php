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

    public function listaDiligenciaProjeto()
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
                $proposta = $this->montarArrayListaDiligenciaProposta($diligenciasProposta);
            }
        }
        $diligencias = $tblProjeto->listarDiligencias(array('pro.IdPRONAC = ?' => $idPronac, 'dil.stEnviado = ?' => 'S'));
        $projeto = $this->montarArrayListaDiligenciaProjeto($diligencias);

        $tbAvaliarAdequacaoProjeto = new \Analise_Model_DbTable_TbAvaliarAdequacaoProjeto();
        $diligenciasAdequacao = $tbAvaliarAdequacaoProjeto->obterAvaliacoesDiligenciadas(['a.idPronac = ?' => $idPronac]);
        $adequacao = $this->montarArrayListaDiligenciaAdequacao($diligenciasAdequacao);

        $result['diligenciaProposta'] = $proposta;
        $result['diligenciaProjeto'] = $projeto;
        $result['diligenciaAdequacao'] = $adequacao;

        return $result;
    }

    private function montarArrayListaDiligenciaProposta($diligenciasProposta)
    {
        $resultArray = [];

        foreach ($diligenciasProposta as $diligencia) {
            $objDateTimedataSolicitacao = new \DateTime($diligencia['dataSolicitacao']);

            $resultArray[] = [
                'idPreprojeto' => $diligencia['pronac'],
                'dataSolicitacao' => $objDateTimedataSolicitacao->format('d/m/Y'),
            ];
        }

        return $resultArray;
    }

    private function montarArrayListaDiligenciaProjeto($diligencias)
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
                'dataSolicitacao' => $objDateTimedataSolicitacao->format('d/m/Y'),
                'dataResposta' => $objDateTimedataResposta->format('d/m/Y'),
                'prazoResposta' => date('d/m/Y',strtotime($diligencia['dataSolicitacao'].' +'.$qtdia.' day')),
            ];
        }

        return $resultArray;
    }

    private function montarArrayListaDiligenciaAdequacao($diligenciasAdequacao)
    {
        $resultArray = [];

        foreach ($diligenciasAdequacao as $diligencia) {
            $objDateTimedtAvaliacao = new \DateTime($diligencia['dtAvaliacao']);

            $resultArray[] = [
                'tipoDiligencia' => html_entity_decode('Dilig&ecirc;ncia na An&aacute;lise da adequa&ccedil;&atilde;o &agrave; realidade do projeto.'),
                'dtAvaliacao' => $objDateTimedtAvaliacao->format('d/m/Y'),
            ];
        }

        return $resultArray;
    }

    public function visualizarDiligenciaProjeto()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        $tblProjeto = new \Projetos();
        $tblPreProjeto = new \Proposta_Model_DbTable_PreProjeto();
        $projeto = $tblProjeto->buscar(array('IdPRONAC = ?' => $idPronac))->current();

        if (isset($projeto->idProjeto) && !empty($projeto->idProjeto)) {
            $diligenciasProposta = $tblPreProjeto->listarDiligenciasPreProjeto(array('pre.idPreProjeto = ?' => $projeto->idProjeto,'aval.ConformidadeOK = ? '=>0));
            $proposta = $this->obterDiligenciaProposta($diligenciasProposta);
        }

        $diligencias = $tblProjeto->listarDiligencias(array('pro.IdPRONAC = ?' => $idPronac, 'dil.stEnviado = ?' => 'S'));
        $diligenciaProjeto = $this->obterDiligenciaProjeto($diligencias);

        $tbAvaliarAdequacaoProjeto = new \Analise_Model_DbTable_TbAvaliarAdequacaoProjeto();
        $diligenciasAdequacao = $tbAvaliarAdequacaoProjeto->obterAvaliacoesDiligenciadas(['a.idPronac = ?' => $idPronac]);
        $adequacao = $this->obterDiligenciaAdequaçãoProjeto($diligenciasAdequacao);


        $result['diligenciaProposta'] = $proposta;
        $result['diligenciaProjeto'] = $diligenciaProjeto;
        $result['diligenciaAdequacao'] = $adequacao;

        return $result;
    }

    private function obterDiligenciaProposta($diligenciasProposta)
    {
        $resultArray = [];

        foreach ($diligenciasProposta as $diligencia) {
            $Solicitacao = html_entity_decode(utf8_encode($diligencia['Solicitacao']));
            $Resposta = html_entity_decode(utf8_encode($diligencia['Resposta']));
            $nomeProjeto = html_entity_decode(utf8_encode($diligencia['nomeProjeto']));

            $objDateTimedataSolicitacao = new \DateTime($diligencia['dataSolicitacao']);
            $objDateTimedataResposta = new \DateTime($diligencia['dataResposta']);

            $resultArray[] = [
                'idPreprojeto' => $diligencia['pronac'],
                'dataSolicitacao' => $objDateTimedataSolicitacao->format('d/m/Y'),
                'dataResposta' => $objDateTimedataResposta->format('d/m/Y'),
                'nomeProjeto' => $nomeProjeto,
                'Solicitacao' => $Solicitacao,
                'Resposta' => $Resposta,
            ];
        }

        return $resultArray;
    }

    private function obterDiligenciaAdequaçãoProjeto($diligenciaAdequacao)
    {
        $resultArray = [];

        foreach ($diligenciaAdequacao as $diligencia) {
            $dsAvaliacao = html_entity_decode(utf8_encode($diligencia['dsAvaliacao']));
            $objDateTimeDtAvaliacao = new \DateTime($diligencia['dtAvaliacao']);

            $resultArray[] = [
                'dsAvaliacao' => $dsAvaliacao,
                'dtAvaliacao' => $objDateTimeDtAvaliacao->format('d/m/Y'),
            ];
        }

        return $resultArray;
    }

    private function obterDiligenciaProjeto($diligencias)
    {
        $resultArray = [];
        foreach ($diligencias as $diligencia) {
            $Solicitacao = html_entity_decode(utf8_encode($diligencia['Solicitacao']));
            $Resposta = html_entity_decode(utf8_encode($diligencia['Resposta']));

            $arquivo = $this->obterAnexosDiligencias($diligencia);

            $resultArray[] = [
                'Solicitacao' => $Solicitacao,
                'Resposta' => $Resposta,
                'arquivo' => $arquivo
            ];
        }

        return $resultArray;
    }

    private function obterAnexosDiligencias($diligencia)
    {
        $arquivo = new \Arquivo();
        $arquivos = $arquivo->buscarAnexosDiligencias($diligencia['idDiligencia']);
        $arquivoArray = [];
        foreach ($arquivos as $arquivo) {
            $objdtEnvio = new \DateTime($arquivo->dtEnvio);
            $arquivoArray[] = [
                'idArquivo' => $arquivo->idArquivo,
                'nmArquivo' => utf8_encode($arquivo->nmArquivo),
                'dtEnvio' => $objdtEnvio->format('d/m/Y'),
                'idDiligencia' => $arquivo->idDiligencia,
            ];
        }
        return $arquivoArray;
    }
}
