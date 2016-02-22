<?php

/**
 * Description of spTipoDeReadequacaoOrcamentaria
 * Criado em 22/02/2016 - Fernão Lara
 */
class spTipoDeReadequacaoOrcamentaria extends GenericModel {
        
    protected $_banco = 'SAC';
    protected $_name  = 'spTipoDeReadequacaoOrcamentaria';

    public function exec($idPronac){
      $sql = "exec ".$this->_banco.".dbo.".$this->_name." $idPronac";
      return $this->getAdapter()->fetchOne($sql);
    }
}
?>
