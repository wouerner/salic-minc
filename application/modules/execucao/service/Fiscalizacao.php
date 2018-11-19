<?php

namespace Application\Modules\Execucao\Service\Fiscalizacao;


class Fiscalizacao implements \MinC\Servico\IServicoRestZend
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

    public function listaFiscalizacao()
    {
        $idPronac = $this->request->idPronac;
        $idFiscalizacao = $this->request->idFiscalizacao;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        $Projetos = new \Projetos();
        $dadosProj = $Projetos->buscar(array('IdPRONAC = ?' => $idPronac))->current();


        if (empty($idFiscalizacao)) {
            $infoProjeto = $Projetos->projetosFiscalizacaoConsultar(array('Projetos.IdPRONAC = ?' => $idPronac), array('tbFiscalizacao.dtInicioFiscalizacaoProjeto ASC', 'tbFiscalizacao.dtFimFiscalizacaoProjeto ASC'));
        } else {
            $infoProjeto = $Projetos->projetosFiscalizacaoConsultar(array('Projetos.IdPRONAC = ?' => $idPronac, 'tbFiscalizacao.idFiscalizacao = ?' => $idFiscalizacao), array('tbFiscalizacao.dtInicioFiscalizacaoProjeto ASC', 'tbFiscalizacao.dtFimFiscalizacaoProjeto ASC'));
        }

        $listaFiscalizacao = $this->montaListaFiscalizacao($infoProjeto);

        return $listaFiscalizacao;
    }

    public function visualizarFiscalizacao()
    {
        $idPronac = $this->request->idPronac;
        $idFiscalizacao = $this->request->idFiscalizacao;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        $Projetos = new \Projetos();
        $dadosProj = $Projetos->buscar(array('IdPRONAC = ?' => $idPronac))->current();


        if (empty($idFiscalizacao)) {
            $infoProjeto = $Projetos->projetosFiscalizacaoConsultar(array('Projetos.IdPRONAC = ?' => $idPronac), array('tbFiscalizacao.dtInicioFiscalizacaoProjeto ASC', 'tbFiscalizacao.dtFimFiscalizacaoProjeto ASC'));
        } else {
            $infoProjeto = $Projetos->projetosFiscalizacaoConsultar(array('Projetos.IdPRONAC = ?' => $idPronac, 'tbFiscalizacao.idFiscalizacao = ?' => $idFiscalizacao), array('tbFiscalizacao.dtInicioFiscalizacaoProjeto ASC', 'tbFiscalizacao.dtFimFiscalizacaoProjeto ASC'));

            $OrgaoFiscalizadorDao = new \OrgaoFiscalizador();
            if ($idFiscalizacao) {
                $dadosOrgaos = $OrgaoFiscalizadorDao->dadosOrgaos(array('tbOF.idFiscalizacao = ?' => $idFiscalizacao));
            }
            $ArquivoFiscalizacaoDao = new \ArquivoFiscalizacao();
            if ($idFiscalizacao) {
                $arquivos = $ArquivoFiscalizacaoDao->buscarArquivo(array('arqfis.idFiscalizacao = ?' => $idFiscalizacao));
            }
            $RelatorioFiscalizacaoDAO = new \RelatorioFiscalizacao();
            $relatorioFiscalizacao = $RelatorioFiscalizacaoDAO->buscaRelatorioFiscalizacao($idFiscalizacao);

        }
        xd($relatorioFiscalizacao);
        return;
    }

    private function montaListaFiscalizacao($dados)
    {
        foreach ($dados as $item) {
            $objDateTimeDtInicio = ' ';
            $objDateTimeDtFim = ' ';

            if (!empty($item['dtInicioFiscalizacaoProjeto'])) {
                $objDateTimeDtInicio = new \DateTime($item['dtInicioFiscalizacaoProjeto']);
                $objDateTimeDtInicio = $objDateTimeDtInicio->format('d/m/Y');
            }

            if (!empty($item['dtFimFiscalizacaoProjeto'])) {
                $objDateTimeDtFim = new \DateTime($item['dtFimFiscalizacaoProjeto']);
                $objDateTimeDtFim = $objDateTimeDtFim->format('d/m/Y');
            }

            $listaFiscalizacao[] = [
                'dtInicio' => $objDateTimeDtInicio,
                'dtFim' => $objDateTimeDtFim,
                'cpfTecnico' => $item['cpfTecnico'],
                'nmTecnico' => $item['nmTecnico'],
            ];

        }
        return $listaFiscalizacao;
    }

    private function montaLocaisFiscalizacao($dados)
    {
        foreach ($dados as $item) {
            $locaisFiscalizacao[] = [
                'regiao' => $item['Regiao'],
                'uf' => $item['uf'],
                'cidade' => $item['cidade'],
            ];

        }
        return $locaisFiscalizacao;
    }

    private function montaOficializarFiscalizacao($dados)
    {
        foreach ($dados as $item) {
            $objDateTimeDtInicio = ' ';
            $objDateTimeDtFim = ' ';
            $objDateTimeDtResposta = ' ';

            if (!empty($item['dtInicioFiscalizacaoProjeto'])) {
                $objDateTimeDtInicio = new \DateTime($item['dtInicioFiscalizacaoProjeto']);
                $objDateTimeDtInicio = $objDateTimeDtInicio->format('d/m/Y');
            }

            if (!empty($item['dtFimFiscalizacaoProjeto'])) {
                $objDateTimeDtFim = new \DateTime($item['dtFimFiscalizacaoProjeto']);
                $objDateTimeDtFim = $objDateTimeDtFim->format('d/m/Y');
            }
            if (!empty($item['dtRespostaSolicitada'])) {
                $objDateTimeDtResposta = new \DateTime($item['dtRespostaSolicitada']);
                $objDateTimeDtResposta = $objDateTimeDtResposta->format('d/m/Y');
            }

            $listaFiscalizacao[] = [
                'dtInicio' => $objDateTimeDtInicio,
                'dtFim' => $objDateTimeDtFim,
                'dtResposta' => $objDateTimeDtResposta,
                'cpfTecnico' => $item['cpfTecnico'],
                'nmTecnico' => $item['nmTecnico'],
                'tpDemandante' => $item['tpDemandante'],
                'dsFiscalizacaoProjeto' => $item['dsFiscalizacaoProjeto'],
            ];

        }
        return $listaFiscalizacao;
    }

    private function montaArquivosFiscalizacao($dados)
    {
        foreach ($dados as $item) {
            $arquivosFiscalizacao[] = [
                'nmArquivo' => $item['nmArquivo'],
                'idArquivo' => $item['idArquivo'],
            ];

        }
        return $arquivosFiscalizacao;
    }

    private function montaFiscalizacaoConcluidaParecer($dados)
    {
        foreach ($dados as $item) {
            $resumoExecucao[] = [
                'dsAcoesProgramadas' => $item['dsAcoesProgramadas'],
                'dsAcoesExecutadas' => $item['dsAcoesExecutadas'],
                'dsBeneficioAlcancado' => $item['dsBeneficioAlcancado'],
                'dsDificuldadeEncontrada' => $item['dsDificuldadeEncontrada'],
            ];
            $utilizacaoRecursos[] = [
                'stApuracaoUFiscalizacao' => $this->statusFiscalizacao($item['stApuracaoUFiscalizacao']),
                'stComprovacaoUtilizacaoRecurso' => $this->statusFiscalizacao($item['stComprovacaoUtilizacaoRecurso']),
                'stCompatibilidadeDesembolsoEvo' => $this->statusFiscalizacao($item['stCompatibilidadeDesembolsoEvo']),
                'stOcorreuDespesas' => $this->statusFiscalizacao($item['stOcorreuDespesas']),
                'stPagamentoServidorPublico' => $this->statusFiscalizacao($item['stPagamentoServidorPublico']),
                'stDespesaAdministracao' => $this->statusFiscalizacao($item['stDespesaAdministracao']),
                'stTransferenciaRecurso' => $this->statusFiscalizacao($item['stTransferenciaRecurso']),
                'stDespesasPublicidade' => $this->statusFiscalizacao($item['stDespesasPublicidade']),
                'stOcorreuAditamento' => $this->statusFiscalizacao($item['stOcorreuAditamento']),
                'stAplicadosRecursos' => $this->statusFiscalizacao($item['stAplicadosRecursos']),
                'stRecursosCaptados' => $this->statusFiscalizacao($item['stRecursosCaptados']),
                'stSaldoAposEncerramento' => $this->statusFiscalizacao($item['stSaldoAposEncerramento']),
                'stSaldoVerificacaoFNC' => $this->statusFiscalizacao($item['stSaldoVerificacaoFNC']),
            ];

            $comprovantesDespesa[] = [
                'stProcessoDocumentado' => $this->statusFiscalizacao($item['stProcessoDocumentado']),
                'stDocumentacaoCompleta' => $this->statusFiscalizacao($item['stDocumentacaoCompleta']),
                'stConformidadeExecucao' => $this->statusFiscalizacao($item['stConformidadeExecucao']),
                'stIdentificaProjeto' => $this->statusFiscalizacao($item['stIdentificaProjeto']),
                'stDespesaAnterior' => $this->statusFiscalizacao($item['stDespesaAnterior']),
                'stDespesaPosterior' => $this->statusFiscalizacao($item['stDespesaPosterior']),
                'stDespesaCoincidem' => $this->statusFiscalizacao($item['stDespesaCoincidem']),
                'stDespesaRelacionada' => $this->statusFiscalizacao($item['stDespesaRelacionada']),
                'stComprovanteFiscal' => $this->statusFiscalizacao($item['stComprovanteFiscal']),
            ];

            $divulgacao[] = [
                'stCienciaLegislativo' => $this->statusFiscalizacao($item['stCienciaLegislativo']),
                'stExigenciaLegal' => $this->statusFiscalizacao($item['stExigenciaLegal']),
                'stMaterialInformativo' => $this->statusFiscalizacao($item['stMaterialInformativo']),
            ];

            $execucao[] = [
                'stFinalidadeEsperada' => $this->statusFiscalizacao($item['stFinalidadeEsperada']),
                'stPlanoTrabalho' => $this->statusFiscalizacao($item['stPlanoTrabalho']),
                'stExecucaoAprovado' => $this->statusFiscalizacao($item['stExecucaoAprovado']),
                'dsObservacao' => $this->statusFiscalizacao($item['dsObservacao']),
            ];

            $empregosGeradosProjeto[] = [
                'qtEmpregoDireto' => $item['qtEmpregoDireto'],
                'qtEmpregoIndireto' => $item['qtEmpregoIndireto'],
                'qtEmpregoTotal' => $item['qtEmpregoDireto'] + $item['qtEmpregoIndireto'],
                'dsEvidencia' => $item['dsEvidencia'],
                'dsRecomendacaoEquipe' => $item['dsRecomendacaoEquipe'],
                'dsConclusaoEquipe' => $item['dsConclusaoEquipe'],
                'dsParecerTecnico' => $item['dsParecerTecnico'],
                'dsParecer' => $item['dsParecer'],
            ];
        }
        return $arquivosFiscalizacao;
    }

    private function statusFiscalizacao($dado)
    {
        switch ($dado) {
            case 1:
                $result = 'Sim';
                break;
            case 2:
                $result = 'N&atilde;o';
                break;
            case 3:
                $result = 'N&atilde;o se aplica.';
                break;
        }

        return $result;
    }
}
