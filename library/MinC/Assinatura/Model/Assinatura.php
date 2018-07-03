<?php

namespace MinC\Assinatura\Model;

/**
 * Class Assinatura
 * @package MinC\Assinatura\Model
 *
 * @var \Assinatura_Model_TbAssinatura $modeloTbAssinatura
 * @var \Assinatura_Model_TbAtoAdministrativo $modeloTbAtoAdministrativo
 * @var \Proposta_Model_TbDespacho $modeloTbDespacho
 * @var \Assinatura_Model_DbTable_TbAssinatura $dbTableTbAssinatura
 */
class Assinatura implements IModel
{
    public $modeloTbAssinatura;
    public $modeloTbAtoAdministrativo;
    public $modeloTbDespacho;
    public $modeloTbDocumentoAssinatura;
    public $dbTableTbAssinatura;

    public function __construct(array $dadosModelo = [])
    {
        $this->modeloTbAssinatura = new \Assinatura_Model_TbAssinatura($dadosModelo);
        $this->modeloTbAtoAdministrativo = new \Assinatura_Model_TbAtoAdministrativo($dadosModelo);
        $this->modeloTbDespacho = new \Proposta_Model_TbDespacho($dadosModelo);
        $this->modeloTbDocumentoAssinatura = new \Assinatura_Model_TbDocumentoAssinatura($dadosModelo);
        $this->dbTableTbAssinatura = new \Assinatura_Model_DbTable_TbAssinatura();
    }
}