<?php

class Readequacao_Model_TbPlanoDistribuicaoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Readequacao_Model_DbTable_TbPlanoDistribuicao');
    }

    public function save($model)
    {
        return parent::save($model);
    }

    public function criarReadequacaoPlanoDistribuicao(Projeto_Model_TbProjetos $projeto)
    {
        $TbReadequacaoMapper = new Readequacao_Model_TbReadequacaoMapper();
        $readequacaoAtiva = $TbReadequacaoMapper->findBy([
            'idPronac = ?' => $projeto->getIdPRONAC(),
            'idTipoReadequacao = ?' => Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_PLANO_DISTRIBUICAO,
            'stEstado = ?' => 0
        ]);

        if (empty($readequacaoAtiva)) {
            $idReadequacao = $TbReadequacaoMapper->salvarSolicitacaoReadequacao([
                'idPronac' => $projeto->getIdPRONAC(),
                'idTipoReadequacao' => Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_PLANO_DISTRIBUICAO,
                'dsJustificativa' => ' ',
            ]);
        } else {
            $idReadequacao = $readequacaoAtiva['idReadequacao'];
        }

        $tbPlanoDistribuicaoMapper = new Readequacao_Model_TbPlanoDistribuicaoMapper();
        $planosDistribuicao = $tbPlanoDistribuicaoMapper->findBy(
            ['idPronac = ?' => $projeto->getidProjeto(), 'stAtivo = ?' => 'S', 'idReadequacao IS NULL' => '']
        );

        if (empty($planosDistribuicao)) {
            $tbDetalhaPlanoMapper = new Readequacao_Model_TbDetalhaPlanoDistribuicaoReadequacaoMapper();
            $tbDetalhaPlanoMapper->copiarDetalhamentosDaProposta($projeto, $idReadequacao);
            $this->copiarPlanoDistribuicaoDaProposta($projeto, $idReadequacao);
        }

        return true;
    }

    public function obterPlanosDistribuicao(Projeto_Model_TbProjetos $projeto)
    {
        $tbPlanoDistribuicao = new Readequacao_Model_DbTable_TbPlanoDistribuicao();
        $planosDistribuicao = $tbPlanoDistribuicao->obterPlanosDistribuicaoReadequacao($projeto->getIdPRONAC());

        return $planosDistribuicao->toArray();
    }

    public function copiarPlanoDistribuicaoDaProposta(Projeto_Model_TbProjetos $projeto, $idReadequacao = null)
    {
        $tbPlanoDistribuicao = new Readequacao_Model_DbTable_TbPlanoDistribuicao();
        $distribuicaoDaProposta = $tbPlanoDistribuicao->buscarPlanosDistribuicaoReadequacao($projeto->getIdPRONAC());

        if (empty($distribuicaoDaProposta)) {
            throw new Exception("Nenhum plano de distribui&ccedil;&atilde;o encontrado!");
        }

        try {
            $novoPlanoDistribuicao = [];
            $tbDetalhaReadequacao = new Readequacao_Model_DbTable_TbDetalhaPlanoDistribuicaoReadequacao();
            foreach ($distribuicaoDaProposta as $value) {
                $novoPlanoDistribuicao['idReadequacao'] = $idReadequacao;
                $novoPlanoDistribuicao['idProduto'] = $value->idProduto;
                $novoPlanoDistribuicao['cdArea'] = $value->idArea;
                $novoPlanoDistribuicao['cdSegmento'] = $value->idSegmento;
                $novoPlanoDistribuicao['idPosicaoLogo'] = $value->idPosicaoDaLogo;
                $novoPlanoDistribuicao['qtProduzida'] = $value->QtdeProduzida;
                $novoPlanoDistribuicao['qtPatrocinador'] = $value->QtdePatrocinador;
                $novoPlanoDistribuicao['qtOutros'] = $value->QtdeOutros;
                $novoPlanoDistribuicao['qtProponente'] = $value->QtdeProponente;
                $novoPlanoDistribuicao['qtVendaNormal'] = $value->QtdeVendaNormal;
                $novoPlanoDistribuicao['qtVendaPromocional'] = $value->QtdeVendaPromocional;
                $novoPlanoDistribuicao['vlUnitarioNormal'] = $value->PrecoUnitarioNormal;
                $novoPlanoDistribuicao['vlUnitarioPromocional'] = $value->PrecoUnitarioPromocional;
                $novoPlanoDistribuicao['stPrincipal'] = $value->stPrincipal;
                $novoPlanoDistribuicao['canalAberto'] = $value->canalAberto;
                $novoPlanoDistribuicao['tpSolicitacao'] = 'N'; # N - nenhuma, I - inclusao, A - alteracao
                $novoPlanoDistribuicao['stAtivo'] = 'S';
                $novoPlanoDistribuicao['idPronac'] = $projeto->getIdPRONAC();

                $idNovoPlanoDistribuicao = $tbPlanoDistribuicao->inserir($novoPlanoDistribuicao);

                # tem que atualizar os detalhamentos do plano antigo para o novo
                $where = [];
                $where[] = $tbDetalhaReadequacao->getAdapter()->quoteInto(
                    'idPlanoDistribuicao = ?', $value->idPlanoDistribuicao
                );

                $where[] = $tbDetalhaReadequacao->getAdapter()->quoteInto(
                    'stAtivo = ?', 'S'
                );

                $tbDetalhaReadequacao->update(
                    ['idPlanoDistribuicao' => $idNovoPlanoDistribuicao],
                    $where
                );
            }
        } catch (Exception $e) {
            throw new $e;
        }

        return true;
    }

    public function incluirIdReadequacaoNasSolicitacoesAtivas($idPronac, $idReadequacao)
    {
        $tbPlanoDistribuicao = new Readequacao_Model_DbTable_TbPlanoDistribuicao();
        $whereDistribuicao = "idPronac = {$idPronac} AND idReadequacao IS NULL";
        return $tbPlanoDistribuicao->update(['idReadequacao' => $idReadequacao], $whereDistribuicao);
    }

    public function excluirReadequacaoPlanoDistribuicaoAtiva($idPronac)
    {
        if (empty($idPronac)) {
            throw new Exception("Pronac é obrigatório");
        }

        $tbReadequacao = new Readequacao_Model_DbTable_TbReadequacao();
        $readequacaoAtiva = $tbReadequacao->buscar(array(
            'idPronac = ?' => $idPronac,
            'idTipoReadequacao = ?' => Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_PLANO_DISTRIBUICAO,
            'siEncaminhamento = ?' => Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_CADASTRADA_PROPONENTE,
            'stEstado = ?' => 0,
            'stAtendimento = ?' => 'N'
        ))->current();

        if (empty($readequacaoAtiva)) {
            throw new Exception("Nenhuma readequa&ccedil;&atilde;o encontrada!");
        }

        if (!empty($readequacaoAtiva->idDocumento)) {
            $tbDocumento = new tbDocumento();
            $dadosArquivo = $tbDocumento->buscar(array('idDocumento =?' => $readequacaoAtiva->idDocumento))->current();

            if ($dadosArquivo) {
                $tbDocumento = new tbDocumento();
                $tbDocumento->excluir("idArquivo = {$dadosArquivo->idArquivo} and idDocumento= {$readequacaoAtiva->idDocumento} ");

                $tbArquivoImagem = new tbArquivoImagem();
                $tbArquivoImagem->excluir("idArquivo =  {$dadosArquivo->idArquivo} ");

                $tbArquivo = new tbArquivo();
                $tbArquivo->excluir("idArquivo = {$dadosArquivo->idArquivo} ");
            }
        }

        $tbPlanoDistribuicao = new Readequacao_Model_DbTable_TbPlanoDistribuicao();
        $tbPlanoDistribuicao->delete(array(
            'idReadequacao = ?' => $readequacaoAtiva->idReadequacao, 'idPronac = ?' => $idPronac, 'stAtivo = ?' => 'S'
        ));

        $tbDetalhaPlanoDistribuicao = new Readequacao_Model_DbTable_TbDetalhaPlanoDistribuicaoReadequacao();
        $tbDetalhaPlanoDistribuicao->delete(array(
            'idReadequacao = ?' => $readequacaoAtiva->idReadequacao, 'idPronac = ?' => $idPronac, 'stAtivo = ?' => 'S'
        ));

        return $tbReadequacao->delete(array('idPronac =?' => $idPronac, 'idReadequacao = ?' => $readequacaoAtiva->idReadequacao));
    }

    public function consolidarDadosPlanoDistribuicao($idPronac, $idReadequacao)
    {

        $PlanoDistribuicaoProduto = new Proposta_Model_DbTable_PlanoDistribuicaoProduto();
        $tbPlanoDistribuicao = new Readequacao_Model_DbTable_TbPlanoDistribuicao();
        $tbDetalhaPlanoDistribuicao = new Proposta_Model_DbTable_TbDetalhaPlanoDistribuicao();
        $tbDetalhaPlanoDistribuicaoReadequacao = new Readequacao_Model_DbTable_TbDetalhaPlanoDistribuicaoReadequacao();

        $planosDistribuicaoReadequados = $tbPlanoDistribuicao->buscar(array('idReadequacao=?'=>$idReadequacao));
        $detalhamentosReadequados = $tbDetalhaPlanoDistribuicaoReadequacao->buscar(
            ['idReadequacao = ?' => $idReadequacao, 'tpSolicitacao <> ?' => 'E']
        )->toArray();

        $Projetos = new Projetos();
        $projeto = $Projetos->buscar(array('IdPRONAC=?'=>$idPronac))->current();

        // lista todos os planos originais
        $planosDistribuicaoOriginais = $PlanoDistribuicaoProduto->buscar(array('idProjeto=?' => $projeto->idProjeto));
        $planosExistentes = array();
        foreach ($planosDistribuicaoOriginais as $planoOriginal) {
            $idsPlanosExistentes[] = $planoOriginal->idPlanoDistribuicao;
        }

        foreach ($planosDistribuicaoReadequados as $planoReadequado) {

            //Se não houve avalição do conselheiro, pega a avaliação técnica como referencia.
            $avaliacao = $planoReadequado->tpAnaliseComissao;
            if ($planoReadequado->tpAnaliseComissao == 'N') {
                $avaliacao = $planoReadequado->tpAnaliseTecnica;
            }

            //Se a avaliação foi deferida, realiza as mudanças necessárias na tabela original.
            if ($avaliacao == 'D') {
                $registroExiste = false;

                if (in_array($planoReadequado->idPlanoDistribuicao, $idsPlanosExistentes)) {
                    $registroExiste = true;
                }
                // workaround para barrar update de projetos antigos: faz update somente quando tem o id na tabela

                if ($registroExiste) {
                    // pega dados da tabela temporria (tbPlanoDistribuicao) e faz update em PlanoDistribuicaoProduto
                    $updatePlanoDistr = array();
                    $updatePlanoDistr['idProjeto'] = $projeto->idProjeto;
                    $updatePlanoDistr['idProduto'] = $planoReadequado->idProduto;
                    $updatePlanoDistr['Area'] = $planoReadequado->cdArea;
                    $updatePlanoDistr['Segmento'] = $planoReadequado->cdSegmento;
                    $updatePlanoDistr['idPosicaoDaLogo'] = $planoReadequado->idPosicaoLogo;
                    $updatePlanoDistr['stPrincipal'] = 0;
                    $updatePlanoDistr['QtdeProduzida'] = $planoReadequado->qtProduzida;
                    $updatePlanoDistr['QtdePatrocinador'] = $planoReadequado->qtPatrocinador;
                    $updatePlanoDistr['QtdeProponente'] = $planoReadequado->qtProponente;
                    $updatePlanoDistr['QtdeOutros'] = $planoReadequado->qtOutros;
                    $updatePlanoDistr['QtdeVendaNormal'] = $planoReadequado->qtVendaNormal;
                    $updatePlanoDistr['QtdeVendaPromocional'] = $planoReadequado->qtVendaPromocional;
                    $updatePlanoDistr['PrecoUnitarioNormal'] = $planoReadequado->vlUnitarioNormal;
                    $updatePlanoDistr['PrecoUnitarioPromocional'] = $planoReadequado->vlUnitarioPromocional;
                    $updatePlanoDistr['Usuario'] = $auth->getIdentity()->usu_codigo;
                    $updatePlanoDistr['dsJustificativaPosicaoLogo'] = null;
                    $updatePlanoDistr['stPlanoDistribuicaoProduto'] = 1;

                    $wherePlanoDistr = array();
                    $wherePlanoDistr['idPlanoDistribuicao = ?'] = $planoOriginal->idPlanoDistribuicao;


                    # remove os detalhamentos originais
//                    $tbDetalhaPlanoDistribuicao->delete([
//                        'idPlanoDistribuicao = ?' => $planoOriginal->idPlanoDistribuicao,
//                    ]);

                    # adiciona os novos
                    $detalhamentos = array_walk($detalhamentosReadequados, function($detalhamento) {

                        if ($detalhamento['idPlanoDistribuicao'] == $planoReadequado->idPlanoDistribuicao)
                        unset($detalhamento['tpSolicitacao']);
                        unset($detalhamento['stAtivo']);
                        unset($detalhamento['idPronac']);
                        $detalhamento['idPlanoDistribuicao'] = $planoOriginal->idPlanoDistribuicao;
                        x($detalhamento);
//                        $tbDetalhaPlanoDistribuicao->inserir($detalhamento);
                    });

xd('teste');
//                    $PlanoDistribuicaoProduto->update($updatePlanoDistr, $wherePlanoDistr);
                }
            }
        }

xd('ttes222');
        $dadosPDD = array();
        $dadosPDD['stAtivo'] = 'N';
        $wherePDD = array();
        $wherePDD['idPronac = ? '] = $idPronac;
        $wherePDD['idReadequacao = ?'] = $idReadequacao;

        $tbDetalhaPlanoDistribuicaoReadequacao->update($dadosPDD, $wherePDD);
        $tbPlanoDistribuicao->update($dadosPDD, $wherePDD);
    }

    public function consolidarPelaComissaoCnic()
    {

        $PlanoDistribuicaoProduto = new Proposta_Model_DbTable_PlanoDistribuicaoProduto();
        $tbPlanoDistribuicao = new Readequacao_Model_DbTable_TbPlanoDistribuicao();
        $planosDistribuicao = $tbPlanoDistribuicao->buscar(array('idReadequacao=?'=>$idReadequacao));

        foreach ($planosDistribuicao as $plano) {
            $Projetos = new Projetos();
            $dadosPrj = $Projetos->buscar(array('IdPRONAC=?'=>$read->idPronac))->current();

            //Se não houve avalição do conselheiro, pega a avaliação técnica como referencia.
            $avaliacao = $plano->tpAnaliseComissao;
            if ($plano->tpAnaliseComissao == 'N') {
                $avaliacao = $plano->tpAnaliseTecnica;
            }

            //Se a avaliação foi deferida, realiza as mudanças necessárias na tabela original.
            if ($avaliacao == 'D') {
                if ($plano->tpSolicitacao == 'E') { //Se o plano de distribuição foi excluído, atualiza os status do plano na SAC.dbo.PlanoDistribuicaoProduto
                    $PlanoDistribuicaoProduto->delete(array('idProjeto = ?'=>$dadosPrj->idProjeto, 'idProduto = ?'=>$plano->idProduto, 'Area = ?'=>$plano->cdArea, 'Segmento = ?'=>$plano->cdSegmento));
                } elseif ($plano->tpSolicitacao == 'I') { //Se o plano de distribuição foi incluído, cria um novo registro na tabela SAC.dbo.PlanoDistribuicaoProduto
                    $novoPlanoDistRead = array();
                    $novoPlanoDistRead['idProjeto'] = $dadosPrj->idProjeto;
                    $novoPlanoDistRead['idProduto'] = $plano->idProduto;
                    $novoPlanoDistRead['Area'] = $plano->cdArea;
                    $novoPlanoDistRead['Segmento'] = $plano->cdSegmento;
                    $novoPlanoDistRead['idPosicaoDaLogo'] = $plano->idPosicaoLogo;
                    $novoPlanoDistRead['QtdeProduzida'] = $plano->qtProduzida;
                    $novoPlanoDistRead['QtdePatrocinador'] = $plano->qtPatrocinador;
                    $novoPlanoDistRead['QtdeProponente'] = $plano->qtProponente;
                    $novoPlanoDistRead['QtdeOutros'] = $plano->qtOutros;
                    $novoPlanoDistRead['QtdeVendaNormal'] = $plano->qtVendaNormal;
                    $novoPlanoDistRead['QtdeVendaPromocional'] = $plano->qtVendaPromocional;
                    $novoPlanoDistRead['PrecoUnitarioNormal'] = $plano->vlUnitarioNormal;
                    $novoPlanoDistRead['PrecoUnitarioPromocional'] = $plano->vlUnitarioPromocional;
                    $novoPlanoDistRead['stPrincipal'] = 0;
                    $novoPlanoDistRead['Usuario'] = $this->idUsuario;
                    $novoPlanoDistRead['dsJustificativaPosicaoLogo'] = null;
                    $novoPlanoDistRead['stPlanoDistribuicaoProduto'] = 1;
                    $PlanoDistribuicaoProduto->inserir($novoPlanoDistRead);
                }
            }
        }

        $dadosPDD = array();
        $dadosPDD['stAtivo'] = 'N';
        $wherePDD = "idPronac = $read->idPronac AND idReadequacao = $idReadequacao";
        $tbPlanoDistribuicao->update($dadosPDD, $wherePDD);
    }
}
