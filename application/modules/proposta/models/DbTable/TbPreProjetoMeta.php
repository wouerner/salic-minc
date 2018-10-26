<?php

/**
 * Class Proposta_Model_DbTable_PreProjeto
 */
class Proposta_Model_DbTable_TbPreProjetoMeta extends MinC_Db_Table_Abstract
{
    protected $_schema = "sac";
    protected $_name = "tbPreProjetoMeta";
    protected $_primary = "idPreProjetoMeta";

    /**
     * Proposta_Model_DbTable_PreProjeto constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function buscarMeta($idPreProjeto, $metaKey)
    {
        if (empty($idPreProjeto)) {
            return false;
        }

        $db = Zend_Db_Table::getDefaultAdapter();

        $db->query('SET TEXTSIZE 2147483647 ');

        $sql = $db->select()
            ->from($this->_name, 'metaValue', $this->_schema)
            ->where('idPreProjeto = ?', $idPreProjeto);

        if (!empty($metaKey)) {
            $sql->where('metaKey = ?', $metaKey);
        }

        $sql->order('idPreProjetoMeta DESC');
        $sql->limit(1);

        return $db->fetchOne($sql);
    }

    public function buscarMetas($idPreProjeto, $metaKey = null, $prefix = null) {

        if (empty($idPreProjeto)) {
            return false;
        }

        $db = Zend_Db_Table::getDefaultAdapter();

        $db->query('SET TEXTSIZE 2147483647');

        $sql = $db->select()
            ->from($this->_name, ['metaKey', 'metaValue'], $this->_schema)
            ->where('idPreProjeto = ?', $idPreProjeto);

        if (!empty($metaKey)) {
            $sql->where('metaKey = ?', $metaKey);
        }

        if (!empty($prefix)) {
            $sql->where('metaKey like ?',  "$prefix%");
        }

        $sql->order('idPreProjetoMeta DESC');

        return $db->fetchAll($sql);
    }

    public function salvarMeta($idPreProjeto, $metaKey, $valor)
    {
        if (empty($idPreProjeto) || empty($metaKey)) {
            return false;
        }

        $dados = array(
            'idPreProjeto' => $idPreProjeto,
            'metaKey' => $metaKey,
            'metaValue' => $valor
        );

        if ($this->buscarMeta($idPreProjeto, $metaKey)) {
            $where = array(
                'idPreProjeto = ?' => $idPreProjeto,
                'metaKey = ?' => $metaKey
            );

            return $this->update($dados, $where);
        } else {
            return $this->insert($dados);
        }
    }

    public function deletarMeta($idPreProjeto, $metaKey)
    {
        if (empty($idPreProjeto) || empty($metaKey)) {
            return false;
        }

        $where = array(
            'idPreProjeto = ?' => $idPreProjeto,
            'metaKey = ?' => $metaKey
        );

        return $this->delete($where);
    }
}
