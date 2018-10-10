<?php

class AvaliacaoResultados_Model_DbTable_LaudoFinal extends MinC_Db_Table_Abstract
{
    protected $_name = "tbLaudoFinal";
    protected $_schema = "SAC";
    protected $_primary = "idLaudoFinal";

    public function all() {
        return $this->fetchAll();
    }

    public function findBy($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(
            array('a' => $this->_name),
            array('*'),
            $this->_schema
        )
        ->where('idPronac = ? ', $id);

        return $db->fetchRow($select);
    }
}