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
}