<?php

namespace MinC\Assinatura\Model;

/**
 * Class Assinatura
 * @package MinC\Assinatura\Model
 *
 * @var int $idPronac
 * @var string $dsManifestacao
 * @var int $idTipoDoAtoAdministrativo
 * @var int $cod_grupo
 * @var int $cod_orgao
 * @var int $idOrdemDaAssinatura
 * @var int $idDocumentoAssinatura
 * @var int $idAssinante
 * @var int $idAtoAdministrativo
 * @var array $dadosDocumentoAssinatura
 * @var int $idOrgaoSuperiorDoAssinante
 * @var \Assinatura_Model_TbAssinatura $modelTbAssinatura
 * @var \Assinatura_Model_TbAtoAdministrativo $modelTbAtoAdministrativo
 */
class Assinatura implements IModel
{
    public $modeloTbAssinatura;
    public $modeloTbAtoAdministrativo;

    public function __construct(array $dadosModelo = [])
    {
        $this->modeloTbAssinatura = new \Assinatura_Model_TbAssinatura($dadosModelo);
        $this->modeloTbAtoAdministrativo = new \Assinatura_Model_TbAtoAdministrativo($dadosModelo);
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

    private $idPronac;
    private $dsManifestacao;
    private $idTipoDoAtoAdministrativo;
    private $cod_grupo;
    private $cod_orgao;
    private $idOrdemDaAssinatura;
    private $idDocumentoAssinatura;
    private $idAssinante;
    private $idAtoAdministrativo;
    private $idOrgaoSuperiorDoAssinante;

    /**
     * @return int
     */
    public function getIdOrgaoSuperiorDoAssinante()
    {
        return $this->idOrgaoSuperiorDoAssinante;
    }

    /**
     * @param int $idOrgaoSuperiorDoAssinante
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setIdOrgaoSuperiorDoAssinante($idOrgaoSuperiorDoAssinante)
    {
        $this->idOrgaoSuperiorDoAssinante = $idOrgaoSuperiorDoAssinante;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdAtoAdministrativo()
    {
        return $this->idAtoAdministrativo;
    }

    /**
     * @param int $idAtoAdministrativo
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setIdAtoAdministrativo($idAtoAdministrativo)
    {
        $this->idAtoAdministrativo = $idAtoAdministrativo;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdDocumentoAssinatura()
    {
        return $this->idDocumentoAssinatura;
    }

    /**
     * @param int $idDocumentoAssinatura
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setIdDocumentoAssinatura($idDocumentoAssinatura)
    {
        $this->idDocumentoAssinatura = $idDocumentoAssinatura;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdAssinante()
    {
        return $this->idAssinante;
    }

    /**
     * @param int $idAssinante
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setIdAssinante($idAssinante)
    {
        $this->idAssinante = $idAssinante;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdOrdemDaAssinatura()
    {
        return $this->idOrdemDaAssinatura;
    }

    /**
     * @param int $idOrdemDaAssinatura
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setIdOrdemDaAssinatura($idOrdemDaAssinatura)
    {
        $this->idOrdemDaAssinatura = $idOrdemDaAssinatura;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodGrupo()
    {
        return $this->cod_grupo;
    }

    /**
     * @param int $cod_grupo
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setCodGrupo($cod_grupo)
    {
        $this->cod_grupo = $cod_grupo;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodOrgao()
    {
        return $this->cod_orgao;
    }

    /**
     * @param int $cod_orgao
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setCodOrgao($cod_orgao)
    {
        $this->cod_orgao = $cod_orgao;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdPronac()
    {
        return $this->idPronac;
    }

    /**
     * @param int $idPronac
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setIdPronac($idPronac)
    {
        $this->idPronac = $idPronac;
        return $this;
    }

    /**
     * @return \MinC\Assinatura\Autenticacao\IAdapter
     */
    public function getServicoAutenticacao()
    {
        return $this->servicoAutenticacao;
    }

    /**
     * @param \MinC\Assinatura\Autenticacao\IAdapter $servicoAutenticacao
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setServicoAutenticacao($servicoAutenticacao)
    {
        $this->servicoAutenticacao = $servicoAutenticacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDsManifestacao()
    {
        return $this->dsManifestacao;
    }

    /**
     * @param string $dsManifestacao
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setDsManifestacao($dsManifestacao)
    {
        $this->dsManifestacao = $dsManifestacao;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdTipoDoAtoAdministrativo()
    {
        return $this->idTipoDoAtoAdministrativo;
    }

    /**
     * @param int $idTipoDoAtoAdministrativo
     * @return \MinC\Assinatura\Model\Assinatura
     */
    public function setIdTipoDoAtoAdministrativo($idTipoDoAtoAdministrativo)
    {
        $this->idTipoDoAtoAdministrativo = $idTipoDoAtoAdministrativo;
        return $this;
    }
}