<?php

class Readequacao_Model_DbTable_TbProjetoRecebedorRecurso extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC.dbo";
    protected $_name    = "tbprojetorecebedorrecurso";

    public function obterTransferenciaRecursosEntreProjetos($where = array())
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('a' => $this->_name),
            array(
                new Zend_Db_Expr(
                    'a.idPronacTransferidor,
                    b.AnoProjeto + b.Sequencial as PronacTransferidor,
                    b.NomeProjeto as NomeProjetoTranferidor,
                    a.idPronacRecebedor,
                    c.AnoProjeto + c.Sequencial as PronacRecebedor,
                    c.NomeProjeto as NomeProjetoRecedor,
                    a.dtRecebimento,
                    a.vlRecebido'
                ),
            )
        );

        $select->joinInner(
            array('b' => 'Projetos'),
            'b.IdPRONAC = a.idPronacTransferidor',
            array(''),
            'SAC.dbo'
        );

        $select->joinInner(
            array('c' => 'Projetos'),
            'c.IdPRONAC = a.idPronacRecebedor',
            array(''),
            'SAC.dbo'
        );

        foreach ($where as $coluna => $valor) {
            $select->where($coluna, $valor);
        }

        xd($select->assemble());
        return $this->$this->fetchAll($select);
    }
}
