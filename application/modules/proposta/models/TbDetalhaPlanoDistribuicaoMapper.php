<?php

class Proposta_Model_TbDetalhaPlanoDistribuicaoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Proposta_Model_DbTable_TbDetalhaPlanoDistribuicao');
    }

    public function save($model)
    {
        return parent::save($model);
    }
}