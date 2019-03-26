<?php
/**
 * DAO tbTipoReadequacao
 * @since 28/02/2014
 */

class Readequacao_Model_DbTable_TbTipoReadequacao extends MinC_Db_Table_Abstract
{
    protected $_banco  = "SAC";
    protected $_schema = "SAC";
    protected $_name   = "tbTipoReadequacao";

    public function buscarTiposReadequacoesPermitidos($idPronac, $order = 2)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('a' => $this->_name),
            array(
                new Zend_Db_Expr("idTipoReadequacao, dsReadequacao"),
            )
        );

        $select->where('siReadequacao = ?', 0);
        $select->where('stEstado = ?', Readequacao_Model_DbTable_TbReadequacao::ST_ESTADO_EM_ANDAMENTO);

        $select->where(new Zend_Db_Expr("idTipoReadequacao NOT IN (
            SELECT idTipoReadequacao FROM SAC.dbo.tbReadequacao WHERE idPronac = $idPronac 
            AND siEncaminhamento IN (" . implode(',', [
                Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_NAO_ENVIA_MINC,
                Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_CADASTRADA_PROPONENTE,
                Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_FINALIZADA_SEM_PORTARIA
            ]) . "))"));

        $select->order($order);
        
        return $this->fetchAll($select);
    }
}
