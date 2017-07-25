<?php

class Solicitacao_Model_TbSolicitacao extends MinC_Db_Model
{
    protected $_idSolicitacao;
    protected $_idProposta;
    protected $_idOrgao;
    protected $_idSolicitante;
    protected $_dtSolicitacao;
    protected $_dsSolicitacao;
    protected $_idTecnico;
    protected $_dtResposta;
    protected $_dsResposta;
    protected $_idDocumento;
    protected $_siEncaminhamento;
    protected $_stEstado;

    /**
     * @return mixed
     */
    public function getIdSolicitacao()
    {
        return $this->_idSolicitacao;
    }

    /**
     * @param mixed $idSolicitacao
     */
    public function setIdSolicitacao($idSolicitacao)
    {
        $this->_idSolicitacao = $idSolicitacao;
    }

    /**
     * @return mixed
     */
    public function getIdProposta()
    {
        return $this->_idProposta;
    }

    /**
     * @param mixed $idProposta
     */
    public function setIdProposta($idProposta)
    {
        $this->_idProposta = $idProposta;
    }

    /**
     * @return mixed
     */
    public function getIdOrgao()
    {
        return $this->_idOrgao;
    }

    /**
     * @param mixed $idOrgao
     */
    public function setIdOrgao($idOrgao)
    {
        $this->_idOrgao = $idOrgao;
    }

    /**
     * @return mixed
     */
    public function getIdSolicitante()
    {
        return $this->_idSolicitante;
    }

    /**
     * @param mixed $idSolicitante
     */
    public function setIdSolicitante($idSolicitante)
    {
        $this->_idSolicitante = $idSolicitante;
    }

    /**
     * @return mixed
     */
    public function getDtSolicitacao()
    {
        return $this->_dtSolicitacao;
    }

    /**
     * @param mixed $dtSolicitacao
     */
    public function setDtSolicitacao($dtSolicitacao)
    {
        $this->_dtSolicitacao = $dtSolicitacao;
    }

    /**
     * @return mixed
     */
    public function getDsSolicitacao()
    {
        return $this->_dsSolicitacao;
    }

    /**
     * @param mixed $dsSolicitacao
     */
    public function setDsSolicitacao($dsSolicitacao)
    {
        $this->_dsSolicitacao = $dsSolicitacao;
    }

    /**
     * @return mixed
     */
    public function getIdTecnico()
    {
        return $this->_idTecnico;
    }

    /**
     * @param mixed $idTecnico
     */
    public function setIdTecnico($idTecnico)
    {
        $this->_idTecnico = $idTecnico;
    }

    /**
     * @return mixed
     */
    public function getDtResposta()
    {
        return $this->_dtResposta;
    }

    /**
     * @param mixed $dtResposta
     */
    public function setDtResposta($dtResposta)
    {
        $this->_dtResposta = $dtResposta;
    }

    /**
     * @return mixed
     */
    public function getDsResposta()
    {
        return $this->_dsResposta;
    }

    /**
     * @param mixed $dsResposta
     */
    public function setDsResposta($dsResposta)
    {
        $this->_dsResposta = $dsResposta;
    }

    /**
     * @return mixed
     */
    public function getIdDocumento()
    {
        return $this->_idDocumento;
    }

    /**
     * @param mixed $idDocumento
     */
    public function setIdDocumento($idDocumento)
    {
        $this->_idDocumento = $idDocumento;
    }

    /**
     * @return mixed
     */
    public function getSiEncaminhamento()
    {
        return $this->_siEncaminhamento;
    }

    /**
     * @param mixed $siEncaminhamento
     */
    public function setSiEncaminhamento($siEncaminhamento)
    {
        $this->_siEncaminhamento = $siEncaminhamento;
    }

    /**
     * @return mixed
     */
    public function getStEstado()
    {
        return $this->_stEstado;
    }

    /**
     * @param mixed $stEstado
     */
    public function setStEstado($stEstado)
    {
        $this->_stEstado = $stEstado;
    }


}
