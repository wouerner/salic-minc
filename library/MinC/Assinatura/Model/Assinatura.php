<?php

namespace MinC\Assinatura\Model;

/**
 * Class Assinatura
 * @package MinC\Assinatura\Model
 *
 * @var \Assinatura_Model_TbAssinatura $modelTbAssinatura
 * @var \Assinatura_Model_TbAtoAdministrativo $modelTbAtoAdministrativo
 * @var \Assinatura_Model_DbTable_TbAssinatura $dbTableTbAssinatura
 */
class Assinatura implements IModel
{
    public $modeloTbAssinatura;
    public $modeloTbAtoAdministrativo;
    public $dbTableTbAssinatura;

    public function __construct(array $dadosModelo = [])
    {
        $this->modeloTbAssinatura = new \Assinatura_Model_TbAssinatura($dadosModelo);
        $this->modeloTbAtoAdministrativo = new \Assinatura_Model_TbAtoAdministrativo($dadosModelo);
        $this->dbTableTbAssinatura = new \Assinatura_Model_DbTable_TbAssinatura();
    }

    public function definirModeloTbAssinatura(array $dados)
    {
        $this->modeloTbAssinatura = new \Assinatura_Model_TbAssinatura($dados);
        return $this;
    }

    public function definirModeloTbAtoAdministrativo(array $dados)
    {
        $this->modeloTbAtoAdministrativo = new \Assinatura_Model_TbAtoAdministrativo($dados);
        return $this;
    }
}