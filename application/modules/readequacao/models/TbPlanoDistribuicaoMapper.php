<?php

class Proposta_Model_TbPlanoDistribuicaoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Readequacao_Model_DbTable_TbPlanoDistribuicao');
    }

    public function save($model)
    {
        return parent::save($model);
    }
}
