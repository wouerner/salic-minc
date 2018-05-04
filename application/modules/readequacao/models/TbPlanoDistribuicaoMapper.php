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

    public function copiarPlanoDistribuicaoDaProposta(Projeto_Model_TbProjetos $projeto)
    {
        $tbPlanoDistribuicao = new Readequacao_Model_DbTable_TbPlanoDistribuicao();
        $distribuicaoDaProposta = $tbPlanoDistribuicao->buscarPlanosDistribuicaoReadequacao($projeto->getIdPRONAC());

        if (empty($distribuicaoDaProposta)) {
            throw new Exception("Nenhum plano de distribui&ccedil;&atilde;o encontrado!");
        }

        $tbDetalhaReadequacao = new Readequacao_Model_DbTable_TbDetalhaPlanoDistribuicaoReadequacao();
        $novoPlanoDistribuicao = [];
        try {

            foreach ($distribuicaoDaProposta as $value) {
                $novoPlanoDistribuicao['idReadequacao'] = null;
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

    public function consolidarPlanosDeDistribuicaoReadequado(Projeto_Model_TbProjetos $projeto)
    {
        $tbPlanoDistribuicao = new Readequacao_Model_DbTable_TbPlanoDistribuicao();
        $planosDistribuicaoReadequados = $tbPlanoDistribuicao->buscar(['idPronac=?' => $projeto->getIdPRONAC(), 'stAtivo = ?' => 'S']);

        if (count($planosDistribuicaoReadequados) == 0) {
            $this->copiarPlanoDistribuicaoDaProposta($projeto);
            $planosDistribuicaoReadequados = $tbPlanoDistribuicao->buscar(['idPronac=?' => $projeto->getIdPRONAC(), 'stAtivo = ?' => 'S']);
        }

        if (count($planosDistribuicaoReadequados) == 0) {
            throw new Exception("Nenhum plano de distribui&ccedil;&atilde;o foi encontrado!");
        }

        foreach ($planosDistribuicaoReadequados as $planosDistribuicaoReadequado) {
            $tbPlanoDistribuicao->updateConsolidacaoPlanoDeDistribuicao($planosDistribuicaoReadequado->idPlanoDistribuicao);
        }

        return true;
    }


}
