<?php

class Readequacao_Model_TbReadequacaoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Readequacao_Model_DbTable_TbReadequacao');
    }

    public function save($model)
    {
        return parent::save($model);
    }
}
