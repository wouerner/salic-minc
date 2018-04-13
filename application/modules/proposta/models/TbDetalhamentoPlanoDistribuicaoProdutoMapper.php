<?php

class Proposta_Model_TbDetalhamentoPlanoDistribuicaoProdutoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Proposta_Model_DbTable_TbDetalhamentoPlanoDistribuicaoProduto');
    }

    public function save(Proposta_Model_TbDetalhamentoPlanoDistribuicaoProduto $model)
    {

        return parent::save($model);
    }
}