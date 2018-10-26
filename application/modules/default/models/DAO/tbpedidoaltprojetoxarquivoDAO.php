<?php
class tbpedidoaltprojetoxarquivoDAO extends Zend_Db_Table
{
    protected $_name = "BDCORPORATIVO.scCORP.tbpedidoaltprojetoxarquivo";

    public static function buscarArquivos($idpedidoalteracao)
    {
        $sql = "
        select
        papxa.idArquivo,
        ta.nmarquivo
        from BDCORPORATIVO.scSAC.tbPedidoAltProjetoXArquivo papxa
        join BDCORPORATIVO.scCorp.tbArquivo ta on ta.idArquivo = papxa.idArquivo
        where papxa.idPedidoAlteracao =".$idpedidoalteracao;

        $db= Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);
        return $db->fetchAll($sql);
    }
}
