<?php

class AvaliacaoResultados_Model_LaudoFinal extends MinC_Db_Model
{
    protected $_id;
    protected $_idPronac;
    protected $_dtLaudoFinal;
    protected $_siManifestacao;
    protected $_dsLaudoFinal;
    protected $_idUsuario;

    public function getId(){
        return $this->_id;
    }

    public function getIdPronac(){
        return $this->_idPronac;
    }

    public function getDtLaudoFinal(){
        return $this->_dtLaudoFinal;
    }

    public function getSiManifestacao(){
        return $this->_siManifestacao;
    }

    public function getDsLaudoFinal(){
        return $this->_dsLaudoFinal;
    }

    public function getIdUsuario(){
        return $this->_idUsuario;
    }
    
    public function setId($value){
        $this->_id = $value;
        return $this;
    }
    
    public function setIdPronac($value){
        $this->_idPronac = $value;
        return $this;
    }

    public function setDtLaudoFinal($value){
        $this->_dtLaudoFinal = $value;
        return $this;
    }

    public function setSiManifestacao($value){
        $this->_siManifestacao = $value;
        return $this;
    }

    public function setDsLaudoFinal($value){
        $this->_dsLaudoFinal = $value;
        return $this;
    }

    public function setIdUsuario($value){
        $this->_idUsuario = $value;
        return $this;
    }
}