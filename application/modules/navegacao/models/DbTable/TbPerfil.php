<?php

class Navegacao_Model_DbTable_TbPerfil extends MinC_Db_Table_Abstract
{
    protected $_banco = "tabelas";
    protected $_name = 'usuarios';
    protected $_schema = 'tabelas';
    protected $_primary = 'usu_codigo';
    protected $_sequence = false;

    public function buscarPerfisDisponiveis($usu_codigo, $sis_codigo)
    {
        $sql = $this->select();
        $sql->setIntegrityCheck(false);
        $sql->from('vwusuariosorgaosgrupos', array('gru_nome'), $this->_schema);
        $sql->where('usu_codigo = ?', $usu_codigo);
        $sql->where('uog_status = ?', 1);

        if (!empty($sis_codigo)) {
            $sql->where('sis_codigo = ?', $sis_codigo);
        }

        $sql->where('gru_codigo <> ?', 129);
        $sql->order('org_siglaautorizado ASC');
        $sql->order('gru_nome ASC');

        return $this->fetchAll($sql);
    }
}
