<?php

class Recurso_Model_TbRecursoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Recurso_Model_DbTable_TbRecurso');
    }

    public function save($model)
    {
        return parent::save($model);
    }
}
