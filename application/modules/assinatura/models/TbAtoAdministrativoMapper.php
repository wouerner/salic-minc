<?php

class Assinatura_Model_TbAtoAdministrativoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Assinatura_Model_DbTable_TbAtoAdministrativo');
    }

    public function save(Assinatura_Model_TbAtoAdministrativo $model)
    {
        return parent::save($model);
    }
}
