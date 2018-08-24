<?php

/**
 * Class Projeto_Model_Situacao
 *
 *
 *
select * from sac.dbo.tbRecurso;
-- tpRecurso 1 - quando é pedido de reconsideração 2 - quando é recurso
-- tpSolicitacao - PI - Projeto Indeferido; DR - Desitência do prazo recursal; OR - Orcamento; - EN - Enquadramento;
-- siFaseProjeto = 2 homologação
-- siRecurso - 1 - quando envia; 12 - quando cadastra; 9 - foi finalizado 15 - finaliza
-- stEstado - 1 inativo e 0 é ativo

--finalizado -- stEstado = 1 e siRecurso = 9
--arquivado -- stEstado = 1 e siRecurso = 15
-- desistencia -- stEstado = 1 e tpSolicitacao = DR e siRecurso = 0;

select * from sac.dbo.tbRecurso where IdPRONAC = 209751 and stEstado = 1 and siFaseProjeto = 2 and tpSolicitacao = 'DR' and siRecurso = 0; -- desistiu do prazo recursal
select * from sac.dbo.tbRecurso where IdPRONAC = 167719 and stEstado = 1 and siFaseProjeto = 2 and tpSolicitacao = 'DR' and siRecurso = 0; -- desistiu do prazo recursal
select * from sac.dbo.tbRecurso; --where IdPRONAC = 209751 and stEstado = 1 and siFaseProjeto = 2 and tpSolicitacao = 'DR' and siRecurso = 0;

select * from sac.dbo.tbRecurso where IdPRONAC = 167719 and stEstado = 1 and siFaseProjeto = 2 and tpSolicitacao = 'DR' and siRecurso = 0;

select * from sac.dbo.tbRecurso where tpSolicitacao = 'or';


--se desistiu não pode mais entrar com recurso --  IdPRONAC = 167719
select * from sac.dbo.tbRecurso where stEstado = 1 and siFaseProjeto = 2 and tpSolicitacao = 'DR' AND siRecurso = 0 AND tpRecurso = 1;

-- verificar se tem direito a segundo recurso --  IdPRONAC = 167719
select * from sac.dbo.tbRecurso where stEstado = 1 and siFaseProjeto = 2 and tpSolicitacao in ('PI', 'OR', 'EN') and siRecurso in (9, 15) AND tpRecurso = 1;

-- ja teve os dois recursos
select * from sac.dbo.tbRecurso where stEstado = 1 and siFaseProjeto = 2 and tpSolicitacao in ('PI', 'OR', 'EN') and siRecurso in (9, 15) AND tpRecurso = 2;

 */

class Recurso_Model_TbRecurso extends MinC_Db_Model
{
    protected $_idRecurso;
    protected $_IdPRONAC;
    protected $_dtSolicitacaoRecurso;
    protected $_dsSolicitacaoRecurso;
    protected $_idAgenteSolicitante;
    protected $_dtAvaliacao;
    protected $_dsAvaliacao;
    protected $_tpRecurso;
    /**
     * @var $_tpSolicitacao
    DR => Desistência do Prazo Recursal
    EN => Enquadramento
    PI => Projet Indeferido
    OR => @todo ?
     */
    protected $_tpSolicitacao;
    protected $_idAgenteAvaliador;
    protected $_stAtendimento;
    protected $_siFaseProjeto;
    protected $_siRecurso;
    protected $_stAnalise;
    protected $_idNrReuniao;
    protected $_stEstado;

    const PRAZO_RECURSAL = 10;
    const TIPO_SOLICITACAO_DESISTENCIA_DO_PRAZO_RECURSAL = 'DR';
    const TIPO_SOLICITACAO_ENQUADRAMENTO = 'EN';
    const SITUACAO_TIPO_RECURSO_ATIVO = 0;
    const SITUACAO_TIPO_RECURSO_INATIVO = 1;
    const SI_RECURSO_FINALIZADO = 15;

    const FASE_ADMISSIBILIDADE = 1;
    const FASE_HOMOLOGACAO = 2;

    public function getIdRecurso()
    {
        return $this->_idRecurso;
    }

    public function setIdRecurso($idRecurso): void
    {
        $this->_idRecurso = $idRecurso;
    }

    public function getIdPRONAC()
    {
        return $this->_IdPRONAC;
    }

    public function setIdPRONAC($IdPRONAC): void
    {
        $this->_IdPRONAC = $IdPRONAC;
    }

    public function getDtSolicitacaoRecurso()
    {
        return $this->_dtSolicitacaoRecurso;
    }

    public function setDtSolicitacaoRecurso($dtSolicitacaoRecurso): void
    {
        $this->_dtSolicitacaoRecurso = $dtSolicitacaoRecurso;
    }

    public function getDsSolicitacaoRecurso()
    {
        return $this->_dsSolicitacaoRecurso;
    }

    public function setDsSolicitacaoRecurso($dsSolicitacaoRecurso): void
    {
        $this->_dsSolicitacaoRecurso = $dsSolicitacaoRecurso;
    }

    public function getIdAgenteSolicitante()
    {
        return $this->_idAgenteSolicitante;
    }

    public function setIdAgenteSolicitante($idAgenteSolicitante): void
    {
        $this->_idAgenteSolicitante = $idAgenteSolicitante;
    }

    public function getDtAvaliacao()
    {
        return $this->_dtAvaliacao;
    }

    public function setDtAvaliacao($dtAvaliacao): void
    {
        $this->_dtAvaliacao = $dtAvaliacao;
    }

    public function getDsAvaliacao()
    {
        return $this->_dsAvaliacao;
    }

    public function setDsAvaliacao($dsAvaliacao): void
    {
        $this->_dsAvaliacao = $dsAvaliacao;
    }

    public function getTpRecurso()
    {
        return $this->_tpRecurso;
    }

    public function setTpRecurso($tpRecurso): void
    {
        $this->_tpRecurso = $tpRecurso;
    }

    public function getTpSolicitacao()
    {
        return $this->_tpSolicitacao;
    }

    public function setTpSolicitacao($tpSolicitacao): void
    {
        $this->_tpSolicitacao = $tpSolicitacao;
    }

    public function getIdAgenteAvaliador()
    {
        return $this->_idAgenteAvaliador;
    }

    public function setIdAgenteAvaliador($idAgenteAvaliador): void
    {
        $this->_idAgenteAvaliador = $idAgenteAvaliador;
    }

    public function getStAtendimento()
    {
        return $this->_stAtendimento;
    }

    public function setStAtendimento($stAtendimento): void
    {
        $this->_stAtendimento = $stAtendimento;
    }

    public function getSiFaseProjeto()
    {
        return $this->_siFaseProjeto;
    }

    public function setSiFaseProjeto($siFaseProjeto): void
    {
        $this->_siFaseProjeto = $siFaseProjeto;
    }

    public function getSiRecurso()
    {
        return $this->_siRecurso;
    }

    public function setSiRecurso($siRecurso): void
    {
        $this->_siRecurso = $siRecurso;
    }

    public function getStAnalise()
    {
        return $this->_stAnalise;
    }

    public function setStAnalise($stAnalise): void
    {
        $this->_stAnalise = $stAnalise;
    }

    public function getIdNrReuniao()
    {
        return $this->_idNrReuniao;
    }

    public function setIdNrReuniao($idNrReuniao): void
    {
        $this->_idNrReuniao = $idNrReuniao;
    }

    public function getStEstado()
    {
        return $this->_stEstado;
    }

    public function setStEstado($stEstado): void
    {
        $this->_stEstado = $stEstado;
    }

    public function isRecursoExpirouPrazoRecursal(array $recursoEnquadramento)
    {
        return (
            (is_null($recursoEnquadramento['stRascunho'])
                || empty($recursoEnquadramento['stRascunho'])
                || $recursoEnquadramento['stRascunho'] == Recurso_Model_TbRecursoProposta::SITUACAO_RASCUNHO_SALVO
            )
            && is_null($recursoEnquadramento['dsRecursoProponente'])
            && empty(trim($recursoEnquadramento['dsRecursoProponente']))
            && is_null($recursoEnquadramento['dsAvaliacaoTecnica'])
            && empty(trim($recursoEnquadramento['dsAvaliacaoTecnica']))
            && $recursoEnquadramento['diasDesdeAberturaRecurso'] > self::PRAZO_RECURSAL
            && $recursoEnquadramento['tpSolicitacao'] == Recurso_Model_TbRecursoProposta::TIPO_SOLICITACAO_DESISTENCIA_DO_PRAZO_RECURSAL);
    }


    /**
     * @param array $recurso
     * @param int $fase
     * @return bool
     */
    public function isRecursoDesistidoDePrazoRecursal(array $recurso, $fase = 1)
    {
        return ((int) $recurso['stEstado'] == 1
            &&  $recurso['tpSolicitacao'] == 'DR'
            &&  (int) $recurso['siRecurso'] == 0
            && $recurso['siFaseProjeto'] == $fase);
    }

    public function isRecursoDuplamenteIndeferido(array $recursoEnquadramento)
    {
        return ((int) $recursoEnquadramento['stRascunho'] == (int) Recurso_Model_TbRecursoProposta::SITUACAO_RASCUNHO_ENVIADO
            && (int) $recursoEnquadramento['tpRecurso'] == (int) Recurso_Model_TbRecursoProposta::TIPO_RECURSO_RECURSO
            && $recursoEnquadramento['stAtendimento'] == Recurso_Model_TbRecursoProposta::SITUACAO_ATENDIMENTO_INDEFERIDO);
    }

    public function isRecursoDeferidoAvaliado(array $recursoEnquadramento)
    {
        return ((int) $recursoEnquadramento['stRascunho'] == (int) Recurso_Model_TbRecursoProposta::SITUACAO_RASCUNHO_ENVIADO
            && $recursoEnquadramento['stAtendimento'] == Recurso_Model_TbRecursoProposta::SITUACAO_ATENDIMENTO_DEFERIDO);
    }

    private function isRecursoEnviadoPorProponente(array $recursoEnquadramento)
    {
        return ($recursoEnquadramento['dsRecursoProponente']
            && !is_null($recursoEnquadramento['stRascunho'])
            && (int) $recursoEnquadramento['stRascunho'] == (int) Recurso_Model_TbRecursoProposta::SITUACAO_RASCUNHO_ENVIADO);
    }

    private function isRecursoPossuiAvaliacaoAvaliador(array $recursoEnquadramento)
    {
        return (!is_null($recursoEnquadramento['dtAvaliacaoTecnica']) && !empty($recursoEnquadramento['dtAvaliacaoTecnica']));
    }

    public function temDireitoARecurso()
    {
        $this->view->isRecursoAvaliado = false;

        $this->view->isRecursoDesistidoDePrazoRecursal = false;
        if ($recursoEnquadramento) {
            $this->view->isRecursoDesistidoDePrazoRecursal = $this->isRecursoDesistidoDePrazoRecursal($recursoEnquadramento);
            if ($this->isRecursoEnviadoPorProponente($recursoEnquadramento) ||
                $this->isRecursoPossuiAvaliacaoAvaliador($recursoEnquadramento)) {
                $this->view->recursoEnquadramento = $recursoEnquadramento;
            }

            if ($this->isRecursoDeferidoAvaliado($recursoEnquadramento)
                || $this->isRecursoDuplamenteIndeferido($recursoEnquadramento)
                || $this->isRecursoDesistidoDePrazoRecursal($recursoEnquadramento)
                || $this->isRecursoExpirouPrazoRecursal($recursoEnquadramento)) {
                $this->view->isRecursoAvaliado = true;
            }
        }
    }

}
