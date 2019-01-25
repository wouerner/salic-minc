<?php
class Fiscalizacao_Model_DbTable_TbRelatorioFiscalizacao extends MinC_Db_Table_Abstract
{
    protected $_name = 'tbRelatorioFiscalizacao';
    protected $_schema = 'SAC';
    protected $_banco = 'SAC';

    public function buscaRelatorioFiscalizacao($idFiscalizacao)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('rf' => $this->_name),
            array( 
                'rf.idRelatorioFiscalizacao'
                ,new Zend_Db_Expr('CAST(rf.dsAcoesProgramadas AS TEXT) as dsAcoesProgramadas')
                ,new Zend_Db_Expr('CAST(rf.dsAcoesExecutadas AS TEXT) as dsAcoesExecutadas')
                ,new Zend_Db_Expr('CAST(rf.dsBeneficioAlcancado AS TEXT) as dsBeneficioAlcancado')
                ,new Zend_Db_Expr('CAST(rf.dsDificuldadeEncontrada AS TEXT) as dsDificuldadeEncontrada')
                ,'rf.stSiafi'
                ,'rf.stPrestacaoContas'
                ,'rf.stCumpridasNormas'
                ,'rf.stCumpridoPrazo'
                ,'rf.stApuracaoUFiscalizacao'
                ,'rf.stComprovacaoUtilizacaoRecursos'
                ,'rf.stCompatibilidadeDesembolsoEvolucao'
                ,'rf.stOcorreuDespesas'
                ,'rf.stPagamentoServidorPublico'
                ,'rf.stDespesaAdministracao'
                ,'rf.stTransferenciaRecurso'
                ,'rf.stDespesasPublicidade'
                ,'rf.stOcorreuAditamento'
                ,'rf.stAplicadosRecursos'
                ,'rf.stAplicacaoRecursosFinalidade'
                ,'rf.stSaldoAposEncerramento'
                ,'rf.stSaldoVerificacaoFNC'
                ,'rf.stProcessoDocumentado'
                ,'rf.stDocumentacaoCompleta'
                ,'rf.stConformidadeExecucao'
                ,'rf.stIdentificaProjeto'
                ,'rf.stDespesaAnterior'
                ,'rf.stDespesaPosterior'
                ,'rf.stDespesaCoincidem'
                ,'rf.stDespesaRelacionada'
                ,'rf.stComprovanteFiscal'
                ,'rf.stCienciaLegislativo'
                ,'rf.stExigenciaLegal'
                ,'rf.stMaterialInformativo'
                ,'rf.stFinalidadeEsperada'
                ,'rf.stPlanoTrabalho'
                ,'rf.stExecucaoAprovado'
                ,'rf.qtEmpregoDireto'
                ,'rf.qtEmpregoIndireto'
                ,new Zend_Db_Expr('CAST(rf.dsEvidencia AS TEXT) as dsEvidencia')
                ,new Zend_Db_Expr('CAST(rf.dsRecomendacaoEquipe AS TEXT) as dsRecomendacaoEquipe')
                ,new Zend_Db_Expr('CAST(rf.dsConclusaoEquipe AS TEXT) as dsConclusaoEquipe')
                ,new Zend_Db_Expr('CAST(rf.dsParecerTecnico AS TEXT) as dsParecerTecnico')
                ,'rf.stAvaliacao'
                ,'rf.idFiscalizacao'
                ,'rf.stRecursosCaptados'
                ,new Zend_Db_Expr('CAST(rf.dsObservacao AS TEXT) as dsObservacao')
                ,new Zend_Db_Expr('CAST(rf.dsJustificativaDevolucao AS TEXT) as dsJustificativaDevolucao')
        ));

        $select->joinLeft(
            array('af' => 'tbAvaliacaoFiscalizacao'),
                'af.idRelatorioFiscalizacao = rf.idRelatorioFiscalizacao',
                array('af.idAvaliacaoFiscalizacao','af.idAvaliador','af.dtAvaliacaoFiscalizacao',
                new Zend_Db_Expr('CAST(af.dsParecer AS TEXT) as dsParecer'))
        );

        $select->joinLeft(
            array('f' => 'tbFiscalizacao'),
                'f.idFiscalizacao = rf.idFiscalizacao',
                array('f.dtInicioFiscalizacaoProjeto', 'f.IdPRONAC')
        );

        $select->where('rf.idFiscalizacao = ?', $idFiscalizacao);
        
        return $this->fetchRow($select);
    }

    public function insereRelatorio($dados)
    {
        return $this->insert($dados);
    }

    public function alteraRelatorio($dados, $where)
    {
        try {
            return $this->update($dados, $where);
        } catch (Zend_Db_Table_Exception $e) {
            return 'RelatorioFiscalizacao -> alteraRelatorio. Erro:' . $e->getMessage();
        }
    }
}
