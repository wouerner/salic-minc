<?php
class Proposta_Model_PreProjetoArquivado  extends MinC_Db_Table_Abstract
{
    protected $_schema = 'sac';
    protected $_name = 'PreProjetoArquivado';
    protected $_primary = 'idPreProjetoArquivado';

    public function recuperarQtdePropostaTecnicoOrgao($idTecnico, $idOrgao)
    {
        $sql = "
                SELECT count(*) as qtdePropostas
                FROM tbAvaliacaoProposta a
                INNER JOIN tabelas.dbo.vwUsuariosOrgaosGrupos  u ON (a.idTecnico = u.usu_Codigo)
                WHERE uog_orgao={$idOrgao} AND idTecnico={$idTecnico} and sis_codigo=21 and gru_codigo=92 and
                stEstado = 0 and year(DtAvaliacao)=year(Getdate()) and month(DtAvaliacao)=month(Getdate())";

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        return $db->fetchAll($sql);
    }
}
