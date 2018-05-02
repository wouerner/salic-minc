<?php

class Readequacao_Model_TbDetalhaPlanoDistribuicaoReadequacaoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Readequacao_Model_DbTable_TbDetalhaPlanoDistribuicaoReadequacao');
    }

    public function save($model)
    {
        return parent::save($model);
    }

    public function obterDetalhamentosParaReadequacao(Projeto_Model_TbProjetos $projeto)
    {
        if (empty($projeto)) {
            throw new Exception("Projeto &eacute; obrigat&oacute;rio");
        }

        $tbDetalhaReadequacao = new Readequacao_Model_DbTable_TbDetalhaPlanoDistribuicaoReadequacao();
        $paramsBuscarDetalhamentos = [
            'idPronac = ?' => $projeto->getIdPRONAC(),
            'stAtivo = ?' => 'S'
        ];

        $detalhamentosReadequacao = $tbDetalhaReadequacao->buscar($paramsBuscarDetalhamentos)->toArray();

        if (count($detalhamentosReadequacao) == 0) {
            $tbDetalhaPlanoDistribuicao = new Proposta_Model_DbTable_TbDetalhaPlanoDistribuicao();
            $detalhamentosReadequacao = $tbDetalhaPlanoDistribuicao->obterDetalhamentosDaProposta($projeto->getidProjeto());

            try {
                $this->beginTransaction();
                foreach ($detalhamentosReadequacao as $key => $detalhamento) {
                    unset($detalhamento['idDetalhaPlanoDistribuicao']);
                    $detalhamento['idReadequacao'] = null;
                    $detalhamento['tpSolicitacao'] = 'N';
                    $detalhamento['stAtivo'] = 'S';
                    $detalhamento['idPronac'] = $projeto->getIdPRONAC();

                    $this->save(new Readequacao_Model_TbDetalhaPlanoDistribuicaoReadequacao($detalhamento));
                }
                $this->commit();

                $detalhamentosReadequacao = $tbDetalhaReadequacao->buscar($paramsBuscarDetalhamentos)->toArray();

            } catch (Exception $e) {
                $this->rollBack();
                throw new $e;
            }
        }

        return $detalhamentosReadequacao;
    }

    public function salvarDetalhamento($dados, Projeto_Model_TbProjetos $projeto)
    {
        if (empty($projeto)) {
            throw new Exception("Projeto &eacute; obrigat&oacute;rio");
        }

        if (empty($dados['idPlanoDistribuicao'])) {
            throw new Exception("Produto é obrigatório");
        }

        $dados['idReadequacao'] = null;
        $dados['stAtivo'] = 'S';
        $dados['idPronac'] = $projeto->getIdPRONAC();

        if($dados['tpSolicitacao'] !== 'I') {
            $dados['tpSolicitacao'] = 'A';
        }

        if (empty($dados['idDetalhaPlanoDistribuicao'])) {
            unset($dados['idDetalhaPlanoDistribuicao']);
            $dados['tpSolicitacao'] = 'I';
        }

        $id = $this->save(new Readequacao_Model_TbDetalhaPlanoDistribuicaoReadequacao($dados));

        if (!empty($id)) {
            $dados['idDetalhaPlanoDistribuicao'] = $id;
        }

        return $dados;
    }
}