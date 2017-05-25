<?php

class Proposta_Model_TbCustosVinculados extends MinC_Db_Model
{
    protected $_idCustosVinculados;
    protected $_idProjeto;
    protected $_idPlanilhaItem;
    protected $_dtCadastro;
    protected $_dsObservacao;
    protected $_idUsuario;

    public $percentualCustoAdministrativo;
    public $percentualDireitosAutorais;
    public $percentualControleAuditoria;
    public $limiteControleAuditoria;
    public $percentualDivulgacao;
    public $percentualCaptacaoRecursos;
    public $limiteCaptacaoRecursos;

    const ID_ETAPA_CUSTOS_VINCULADOS = '8';           # Custos Vinculados
    const ID_FONTE_RECURSO_CUSTOS_VINCULADOS = '109'; #Incentivo fiscal

    const ID_CUSTO_ADMINISTRATIVO = 8197;
    const ID_DIREITOS_AUTORAIS = 40;
    const ID_CONTROLE_E_AUDITORIA = 8199;
    const ID_DIVULGACAO = 8198;
    const ID_REMUNERACAO_CAPTACAO = 5249;

    const PERCENTUAL_CUSTO_ADMINISTRATIVO = 0.15;
    const PERCENTUAL_DIREITOS_AUTORAIS = 0.1;
    const PERCENTUAL_CONTROLE_E_AUDITORIA = 0.1;
    const LIMITE_CONTROLE_E_AUDITORIA = 100000;

    # SUL E SUDESTE
    const PERCENTUAL_DIVULGACAO_SUL_SUDESTE = 0.2;                       # custo de divulgacao 20%
    const PERCENTUAL_REMUNERACAO_CAPTACAO_DE_RECURSOS_SUL_SUDESTE = 0.1; # custo para captação 10%
    const LIMITE_CAPTACAO_DE_RECURSOS_SUL_SUDESTE = 100000;              # valor máximo para captação 100.000,00

    # OUTRAS REGIOES
    const PERCENTUAL_DIVULGACAO_OUTRAS_REGIOES = 0.3;                        # custo de divulgação 30%
    const PERCENTUAL_REMUNERACAO_CAPTACAO_DE_RECURSOS_OUTRAS_REGIOES = 0.15; # custo para captação 15%
    const LIMITE_CAPTACAO_DE_RECURSOS_OUTRAS_REGIOES = 150000;               # valor máximo para captação 150.000,00


    /**
     * @return mixed
     */
    public function getPercentualCustoAdministrativo()
    {
        return $this->percentualCustoAdministrativo;
    }

    /**
     * @param mixed $percentualCustoAdministrativo
     */
    public function setPercentualCustoAdministrativo($percentualCustoAdministrativo)
    {
        $this->percentualCustoAdministrativo = $percentualCustoAdministrativo;
    }

    /**
     * @return mixed
     */
    public function getPercentualDireitosAutorais()
    {
        return $this->percentualDireitosAutorais;
    }

    /**
     * @param mixed $percentualDireitosAutorais
     */
    public function setPercentualDireitosAutorais($percentualDireitosAutorais)
    {
        $this->percentualDireitosAutorais = $percentualDireitosAutorais;
    }

    /**
     * @return mixed
     */
    public function getPercentualControleAuditoria()
    {
        return $this->percentualControleAuditoria;
    }

    /**
     * @param mixed $percentualControleAuditoria
     */
    public function setPercentualControleAuditoria($percentualControleAuditoria)
    {
        $this->percentualControleAuditoria = $percentualControleAuditoria;
    }

    /**
     * @return mixed
     */
    public function getLimiteControleAuditoria()
    {
        return $this->limiteControleAuditoria;
    }

    /**
     * @param mixed $limiteControleAuditoria
     */
    public function setLimiteControleAuditoria($limiteControleAuditoria)
    {
        $this->limiteControleAuditoria = $limiteControleAuditoria;
    }

    /**
     * @return mixed
     */
    public function getPercentualDivulgacao()
    {
        return $this->percentualDivulgacao;
    }

    /**
     * @param mixed $percentualDivulgacao
     */
    public function setPercentualDivulgacao($percentualDivulgacao)
    {
        $this->percentualDivulgacao = $percentualDivulgacao;
    }

    /**
     * @return mixed
     */
    public function getPercentualCaptacaoRecursos()
    {
        return $this->percentualCaptacaoRecursos;
    }

    /**
     * @param mixed $percentualCaptacaoRecursos
     */
    public function setPercentualCaptacaoRecursos($percentualCaptacaoRecursos)
    {
        $this->percentualCaptacaoRecursos = $percentualCaptacaoRecursos;
    }

    /**
     * @return mixed
     */
    public function getLimiteCaptacaoRecursos()
    {
        return $this->limiteCaptacaoRecursos;
    }

    /**
     * @param mixed $limiteCaptacaoRecursos
     */
    public function setLimiteCaptacaoRecursos($limiteCaptacaoRecursos)
    {
        $this->limiteCaptacaoRecursos = $limiteCaptacaoRecursos;
    }

    /**
     * @return mixed
     */
    public function getIdCustosVinculados()
    {
        return $this->_idCustosVinculados;
    }

    /**
     * @param mixed $idCustosVinculados
     */
    public function setIdCustosVinculados($idCustosVinculados)
    {
        $this->_idCustosVinculados = $idCustosVinculados;
    }

    /**
     * @return mixed
     */
    public function getIdProjeto()
    {
        return $this->_idProjeto;
    }

    /**
     * @param mixed $idProjeto
     */
    public function setIdProjeto($idProjeto)
    {
        $this->_idProjeto = $idProjeto;
    }

    /**
     * @return mixed
     */
    public function getIdPlanilhaItem()
    {
        return $this->_idPlanilhaItem;
    }

    /**
     * @param mixed $idPlanilhaItem
     */
    public function setIdPlanilhaItem($idPlanilhaItem)
    {
        $this->_idPlanilhaItem = $idPlanilhaItem;
    }

    /**
     * @return mixed
     */
    public function getDtCadastro()
    {
        return $this->_dtCadastro;
    }

    /**
     * @param mixed $dtCadastro
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->_dtCadastro = $dtCadastro;
    }

    /**
     * @return mixed
     */
    public function getDsObservacao()
    {
        return $this->_dsObservacao;
    }

    /**
     * @param mixed $dsObservacao
     */
    public function setDsObservacao($dsObservacao)
    {
        $this->_dsObservacao = $dsObservacao;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->_idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->_idUsuario = $idUsuario;
    }

}
