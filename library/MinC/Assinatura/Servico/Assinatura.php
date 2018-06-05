<?php

use MinC\Assinatura\Servico\DocumentoAssinatura;

class MinC_Assinatura_Servico_Assinatura implements \MinC\Assinatura\Servico\IServico
{
    /**
     * @var \MinC\Assinatura\Autenticacao\IAdapter $servicoAutenticacao
     */
    private $servicoAutenticacao;

    /**
     * @var \MinC\Assinatura\Servico\DocumentoAssinatura $servicoDocumentoAssinatura
     */
    private $servicoDocumentoAssinatura;

    public $post;

    public $identidadeUsuarioLogado;

    protected $idTipoDoAtoAdministrativo;

    public $isMovimentarProjetoPorOrdemAssinatura = true;

    function __construct(
        $post,
        $identidadeUsuarioLogado,
        $idTipoDoAtoAdministrativo = null
    )
    {
        $this->post = $post;
        $this->identidadeUsuarioLogado = $identidadeUsuarioLogado;
        $this->idTipoDoAtoAdministrativo = $idTipoDoAtoAdministrativo;
    }

    /**
     * @return \MinC\Assinatura\Servico\Autenticacao
     */
    public function obterServicoAutenticacao() {
        if(!isset($this->servicoAutenticacao)) {
            $this->servicoAutenticacao = new \MinC\Assinatura\Servico\Autenticacao(
                $this->post,
                $this->identidadeUsuarioLogado
            );
        }
        return $this->servicoAutenticacao;
    }

    /**
     * @return \MinC\Assinatura\Servico\DocumentoAssinatura
     */
    public function obterServicoDocumento() {
        if(!isset($this->servicoDocumentoAssinatura)) {
            $this->servicoDocumentoAssinatura = new \MinC\Assinatura\Servico\DocumentoAssinatura(
                $this->post,
                $this->idTipoDoAtoAdministrativo
            );
        }
        return $this->servicoDocumentoAssinatura;
    }

    public function assinarProjeto(\MinC\Assinatura\Model\Assinatura $modelAssinatura)
    {

        if (empty(trim($modelAssinatura->getDsManifestacao()))) {
            throw new \Exception ("Campo \"De acordo do Assinante\" &eacute; de preenchimento obrigat&oacute;rio.");
        }

        if (empty(trim($modelAssinatura->getIdPronac()))) {
            throw new \Exception ("O n&uacute;mero do projeto &eacute; obrigat&oacute;rio.");
        }

        if (empty(trim($modelAssinatura->getIdTipoDoAtoAdministrativo()))) {
            throw new \Exception ("O Tipo do Ato Administrativo &eacute; obrigat&oacute;rio.");
        }

        $servicoAutenticacao = $this->obterServicoAutenticacao();
        $metodoAutenticacao = $servicoAutenticacao->obterMetodoAutenticacao();

        if(!$metodoAutenticacao->autenticar()) {
            throw new \Exception ("Os dados utilizados para autentica&ccedil;&atilde;o s&atilde;o inv&aacute;lidos.");
        }

        $usuario = $metodoAutenticacao->obterInformacoesAssinante();
        $modelAssinatura->setIdAssinante($usuario['usu_codigo']);

        $objTbAtoAdministrativo = new \Assinatura_Model_DbTable_TbAtoAdministrativo();
        $dadosAtoAdministrativoAtual = $objTbAtoAdministrativo->obterAtoAdministrativoAtual(
            $modelAssinatura->getIdTipoDoAtoAdministrativo(),
            $modelAssinatura->getCodGrupo(),
            $modelAssinatura->getCodOrgao()
        );
        $modelAssinatura->setIdOrdemDaAssinatura($dadosAtoAdministrativoAtual['idOrdemDaAssinatura']);
        $modelAssinatura->setIdAtoAdministrativo($dadosAtoAdministrativoAtual['idAtoAdministrativo']);

        if (!$dadosAtoAdministrativoAtual) {
            throw new \Exception ("Usu&aacute;rio sem autoriza&ccedil;&atilde;o para assinar o documento.");
        }

        if($this->isProjetoAssinado($modelAssinatura)) {
            throw new \Exception ("O documento j&aacute; foi assinado pelo usu&aacute;rio logado nesta fase atual.");
        }

        $dadosInclusaoAssinatura = array(
            'idPronac' => $modelAssinatura->getIdPronac(),
            'idAtoAdministrativo' => $modelAssinatura->getIdAtoAdministrativo(),
            'dtAssinatura' => $objTbAtoAdministrativo->getExpressionDate(),
            'idAssinante' => $modelAssinatura->getIdAssinante(),
            'dsManifestacao' => $modelAssinatura->getDsManifestacao(),
            'idDocumentoAssinatura' => $modelAssinatura->getIdDocumentoAssinatura()
        );

        $objTbAssinatura = new \Assinatura_Model_DbTable_TbAssinatura();
        $objTbAssinatura->inserir($dadosInclusaoAssinatura);
        $codigoOrgaoDestino = $objTbAtoAdministrativo->obterProximoOrgaoDeDestino(
            $modelAssinatura->getIdTipoDoAtoAdministrativo(),
            $modelAssinatura->getIdOrdemDaAssinatura(),
            $modelAssinatura->getIdOrgaoSuperiorDoAssinante()
        );

        if($this->isMovimentarProjetoPorOrdemAssinatura && $codigoOrgaoDestino) {
            $this->movimentarProjetoAssinadoPorOrdemDeAssinatura($modelAssinatura);
        }
    }

    public function movimentarProjetoAssinadoPorOrdemDeAssinatura(\MinC\Assinatura\Model\Assinatura $modelAssinatura)
    {
        if (!$modelAssinatura->getIdOrdemDaAssinatura()) {
            throw new \Exception("A fase atual do projeto n&atilde;o permite movimentar o projeto.");
        }

        if(!$this->isProjetoAssinado($modelAssinatura)) {
            throw new \Exception ("O documento precisa ser assinado para que consiga ser movimentado.");
        }

        $objTbAtoAdministrativo = new \Assinatura_Model_DbTable_TbAtoAdministrativo();
        $codigoOrgaoDestino = $objTbAtoAdministrativo->obterProximoOrgaoDeDestino(
            $modelAssinatura->getIdTipoDoAtoAdministrativo(),
            $modelAssinatura->getIdOrdemDaAssinatura(),
            $modelAssinatura->getIdOrgaoSuperiorDoAssinante()
        );
        if (!$codigoOrgaoDestino) {
            throw new \Exception("A fase atual do projeto n&atilde;o permite movimentar o projeto.");
        }

        $objTbProjetos = new \Projeto_Model_DbTable_Projetos();
        $objTbProjetos->alterarOrgao($codigoOrgaoDestino, $modelAssinatura->getIdPronac());
    }

    public function isProjetoAssinado(\MinC\Assinatura\Model\Assinatura $modelAssinatura) {

        $objTbAssinatura = new \Assinatura_Model_DbTable_TbAssinatura();
        $assinaturaExistente = $objTbAssinatura->buscar(array(
            'idPronac = ?' => $modelAssinatura->getIdPronac(),
            'idAtoAdministrativo = ?' => $modelAssinatura->getIdAtoAdministrativo(),
            'idAssinante = ?' => $modelAssinatura->getIdAssinante(),
            'idDocumentoAssinatura = ?' => $modelAssinatura->getIdDocumentoAssinatura()
        ));

        if($assinaturaExistente->current()) {
            return true;
        }
        return false;
    }

}