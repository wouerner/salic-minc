<?php

/**
 * Modelo que representa a tabela SAC.dbo.tbPlanilhaItens
 */
class Proposta_Model_DbTable_TbPlanilhaItens extends MinC_Db_Table_Abstract
{

    protected $_schema = 'sac';
    protected $_name = 'tbPlanilhaItens';
    protected $_primary = 'idPlanilhaItens';


    public function buscarDescricao($descricao = null, $where = [])
    {

        $select = $this->select();
        $select->from(
            ["i" => $this->_name],
            ["i.Descricao as descricao"],
            $this->_schema
        );

        if(!empty($descricao)) {
            $select->where('i.Descricao = ?', $descricao);
        }

        if(!empty($where)){
            foreach ($where as $coluna => $valor) {
                $select->where($coluna, $valor);
            }
        }

        $select->order("i.Descricao");
        $select->limit(1);

        $db = Zend_Db_Table::getDefaultAdapter();
        return $db->fetchOne($select);
    }
}