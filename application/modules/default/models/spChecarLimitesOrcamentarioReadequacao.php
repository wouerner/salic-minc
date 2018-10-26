<?php
class spChecarLimitesOrcamentarioReadequacao extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name  = 'spChecarLimitesOrcamentarioReadequacao';

    public function exec($idPronac, $fase)
    {
        $sql = new Zend_Db_Expr("exec {$this->_schema}.{$this->_name} {$idPronac}");
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->fetchAll($sql);
    }
}
