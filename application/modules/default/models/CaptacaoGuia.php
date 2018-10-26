<?php
class CaptacaoGuia extends MinC_Db_Table_Abstract
{
    protected $_banco   = "SAC";
    protected $_schema  = "SAC";
    protected $_name    = "Captacaoguia";

    public function buscarCaptacaoGuia()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from($this);
        return $this->fetchAll($select);
    } 

    public function BuscarTotalCaptacaoGuia($retornaSelect = false, $where = array())
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
                array($this->_name),
                array(
                'AnoProjeto',
                'Sequencial',
                'Art3'=> new Zend_Db_Expr('isnull(sum(captacaoreal),0)')
                )
        );

        $select->group('AnoProjeto');
        $select->group('Sequencial');

        foreach ($where as $coluna => $valor) {
            $select->where($coluna, $valor);
        }

        if ($retornaSelect) {
            return $select;
        } else {
            return $this->fetchAll($select);
        }
    }
}
