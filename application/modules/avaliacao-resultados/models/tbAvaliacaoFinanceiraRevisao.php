<?php

class AvaliacaoResultados_Model_tbAvaliacaoFinanceiraRevisao extends MinC_Db_Model
{

    protected $_idAvaliacaoFinanceiraRevisao;
    protected $_idAvaliacaoFinanceira;
    protected $_idUsuario;
    protected $_idGrupoAtivo;
    protected $_dtRevisao;
    protected $_siStattus;
    protected $_dsRevisao;

    /**
     * @return mixed
     */
    public function getIdRevisaoParecer()
    {
        return $this->_idRevisaoParecer;
    }

    /**
     * @param mixed $idRevisaoParecer
     */
    public function setIdRevisaoParecer($idRevisaoParecer)
    {
        $this->_idRevisaoParecer = $idRevisaoParecer;
    }

    /**
     * @return mixed
     */
    public function getIdParecerAvaliacaoFinanceira()
    {
        return $this->_idParecerAvaliacaoFinanceira;
    }

    /**
     * @param mixed $idParecerAvaliacaoFinanceira
     */
    public function setIdParecerAvaliacaoFinanceira($idParecerAvaliacaoFinanceira)
    {
        $this->_idParecerAvaliacaoFinanceira = $idParecerAvaliacaoFinanceira;
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

    /**
     * @return mixed
     */
    public function getIdGrupoAtivo()
    {
        return $this->_idGrupoAtivo;
    }

    /**
     * @param mixed $idGrupoAtivo
     */
    public function setIdGrupoAtivo($idGrupoAtivo)
    {
        $this->_idGrupoAtivo = $idGrupoAtivo;
    }

    /**
     * @return mixed
     */
    public function getDtRevisao()
    {
        return $this->_dtRevisao;
    }

    /**
     * @param mixed $dtRevisao
     */
    public function setDtRevisao($dtRevisao)
    {
        $this->_dtRevisao = $dtRevisao;
    }

    /**
     * @return mixed
     */
    public function getSiStattus()
    {
        return $this->_siStattus;
    }

    /**
     * @param mixed $siStattus
     */
    public function setSiStattus($siStattus)
    {
        $this->_siStattus = $siStattus;
    }

    /**
     * @return mixed
     */
    public function getDsRevisao()
    {
        return $this->_dsRevisao;
    }

    /**
     * @param mixed $dsRevisao
     */
    public function setDsRevisao($dsRevisao)
    {
        $this->_dsRevisao = $dsRevisao;
    }

}

