<?php

class Readequacao_Model_DbTable_TbProjetoRecebedorRecurso extends MinC_Db_Table_Abstract
{
    protected $_schema  = "sac";
    protected $_primary = "idProjetoRecebedorRecurso";
    protected $_name    = "tbProjetoRecebedorRecurso";


    public function obterTransferenciaRecursosEntreProjetos($where = array())
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('a' => $this->_name),
            array(
                new Zend_Db_Expr(
                    "a.idPronacTransferidor,
                    b.AnoProjeto + b.Sequencial as PronacTransferidor,
                    b.NomeProjeto as NomeProjetoTranferidor,
                    a.idPronacRecebedor,
                    c.AnoProjeto + c.Sequencial as PronacRecebedor,
                    c.NomeProjeto as NomeProjetoRecedor,
                    a.dtRecebimento,
                    a.vlRecebido"
                ),
            )
        );

        $select->joinInner(
            array('b' => 'Projetos'),
            'a.idPronacTransferidor = b.IdPRONAC',
            array(''),
            $this->_schema
        );

        $select->joinInner(
            array('c' => 'Projetos'),
            'a.idPronacRecebedor = c.IdPRONAC',
            array(''),
            $this->_schema
        );

        foreach ($where as $coluna => $valor) {
            $select->where($coluna, $valor);
        }

        xd($select->assemble(), 'separando', $this->fetchAll($select));
        return $this->fetchAll($select);
    }
}
