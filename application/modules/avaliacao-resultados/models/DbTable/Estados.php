<?php

class AvaliacaoResultados_Model_DbTable_Estados extends MinC_Db_Table_Abstract
{
    protected $_name = "Estados";
    protected $_schema = "SAC";
    protected $_primary = "id";

    public function all() {
        return $this->fetchAll();
    }
}