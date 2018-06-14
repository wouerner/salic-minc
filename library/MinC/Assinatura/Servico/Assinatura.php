<?php

namespace MinC\Assinatura\Servico;

/**
 * @var \Assinatura_Model_DbTable_TbAssinatura $dbTableTbAssinatura
 * @var \MinC\Assinatura\Model\Assinatura $viewModelAssinatura
 */
class Assinatura implements IServico
{
    public $post;
    public $identidadeUsuarioLogado;
    public $isEncaminharParaProximoAssinanteAoAssinar = true;
    public $dbTableTbAssinatura;
    public $viewModelAssinatura;
    protected $idTipoDoAtoAdministrativo;

    function __construct(
        $post,
        $identidadeUsuarioLogado,
        $idTipoDoAtoAdministrativo = null
    )
    {
        $this->post = $post;
        $this->identidadeUsuarioLogado = $identidadeUsuarioLogado;
        $this->idTipoDoAtoAdministrativo = $idTipoDoAtoAdministrativo;
        $this->dbTableTbAssinatura = new \Assinatura_Model_DbTable_TbAssinatura();
        $this->viewModelAssinatura = new \MinC\Assinatura\Model\Assinatura();
    }

    public function preencherModelAssinatura(array $dados = [])
    {
        $this->viewModelAssinatura = new \MinC\Assinatura\Model\Assinatura($dados);
    }

    public function assinarProjeto()
    {
        $modeloTbAssinatura = $this->viewModelAssinatura->modeloTbAssinatura;
        $modeloTbAtoAdministrativo = $this->viewModelAssinatura->modeloTbAtoAdministrativo;
        if (empty(trim($modeloTbAssinatura->getDsManifestacao()))) {
            throw new \Exception ("Campo \"De acordo do Assinante\" &eacute; de preenchimento obrigat&oacute;rio.");
        }

        if (empty(trim($modeloTbAssinatura->getIdPronac()))) {
            throw new \Exception ("O n&uacute;mero do projeto &eacute; obrigat&oacute;rio.");
        }

        if (empty(trim($modeloTbAtoAdministrativo->getIdTipoDoAto()))) {
            throw new \Exception ("O Tipo do Ato Administrativo &eacute; obrigat&oacute;rio.");
        }

        $servicoAutenticacao = new \MinC\Assinatura\Servico\Autenticacao(
            $this->post,
            $this->identidadeUsuarioLogado
        );
        $metodoAutenticacao = $servicoAutenticacao->obterMetodoAutenticacao();

        if(!$metodoAutenticacao->autenticar()) {
            throw new \Exception ("Os dados utilizados para autentica&ccedil;&atilde;o s&atilde;o inv&aacute;lidos.");
        }

        $usuario = $metodoAutenticacao->obterInformacoesAssinante();
        $objTbAtoAdministrativo = new \Assinatura_Model_DbTable_TbAtoAdministrativo();
        $dadosAtoAdministrativoAtual = $objTbAtoAdministrativo->obterAtoAdministrativoAtual(
            $modeloTbAtoAdministrativo->getIdTipoDoAto(),
            $modeloTbAtoAdministrativo->getIdPerfilDoAssinante(),
            $modeloTbAtoAdministrativo->getIdOrgaoDoAssinante()
        );

        if (!$dadosAtoAdministrativoAtual) {
            throw new \Exception ("Usu&aacute;rio sem autoriza&ccedil;&atilde;o para assinar o documento.");
        }

        $modeloTbAssinatura->setIdAssinante($usuario['usu_codigo']);
        $modeloTbAtoAdministrativo->setIdOrdemDaAssinatura($dadosAtoAdministrativoAtual['idOrdemDaAssinatura']);
        $modeloTbAtoAdministrativo->setIdAtoAdministrativo($dadosAtoAdministrativoAtual['idAtoAdministrativo']);

        $this->dbTableTbAssinatura->preencherModeloAssinatura([
            'idAssinante' => $modeloTbAssinatura->getIdAssinante(),
            'idPronac' => $modeloTbAssinatura->getIdPronac(),
            'idAtoAdministrativo' => $dadosAtoAdministrativoAtual['idAtoAdministrativo'],
            'idDocumentoAssinatura' => $modeloTbAssinatura->getIdDocumentoAssinatura()
        ]);

        if($this->dbTableTbAssinatura->isProjetoAssinado()) {
            throw new \Exception ("O documento j&aacute; foi assinado pelo usu&aacute;rio logado nesta fase atual.");
        }

        $dadosInclusaoAssinatura = [
            'idPronac' => $modeloTbAssinatura->getIdPronac(),
            'idAtoAdministrativo' => $modeloTbAssinatura->getIdAtoAdministrativo(),
            'dtAssinatura' => $objTbAtoAdministrativo->getExpressionDate(),
            'idAssinante' => $modeloTbAssinatura->getIdAssinante(),
            'dsManifestacao' => $modeloTbAssinatura->getDsManifestacao(),
            'idDocumentoAssinatura' => $modeloTbAssinatura->getIdDocumentoAssinatura()
        ];

        $this->dbTableTbAssinatura->inserir($dadosInclusaoAssinatura);
        $codigoOrgaoDestino = $objTbAtoAdministrativo->obterProximoOrgaoDeDestino(
            $modeloTbAtoAdministrativo->getIdTipoDoAto(),
            $modeloTbAtoAdministrativo->getIdOrdemDaAssinatura(),
            $modeloTbAtoAdministrativo->getIdOrgaoSuperiorDoAssinante()
        );

        if($this->isEncaminharParaProximoAssinanteAoAssinar && $codigoOrgaoDestino) {
            $this->encaminharParaProximoAssinante();
        }
    }

    /**
     * @throws \Exception
     * @uses \MinC\Assinatura\Model\Assinatura
     */
    public function encaminharParaProximoAssinante()
    {
        $modeloTbAtoAdministrativo = $this->viewModelAssinatura->modeloTbAtoAdministrativo;
        if (!$modeloTbAtoAdministrativo->getIdOrdemDaAssinatura()) {
            throw new \Exception("A fase atual do projeto n&atilde;o permite movimentar o projeto.");
        }

        $modeloTbAssinatura = $this->viewModelAssinatura->modeloTbAssinatura;
        $this->dbTableTbAssinatura->modeloTbAssinatura = $modeloTbAssinatura;
        if(!$this->dbTableTbAssinatura->isProjetoAssinado()) {
            throw new \Exception ("O documento precisa ser assinado para que consiga ser movimentado.");
        }

        $objTbAtoAdministrativo = new \Assinatura_Model_DbTable_TbAtoAdministrativo();
        $codigoOrgaoDestino = $objTbAtoAdministrativo->obterProximoOrgaoDeDestino(
            $modeloTbAtoAdministrativo->getIdTipoDoAto(),
            $modeloTbAtoAdministrativo->getIdOrdemDaAssinatura(),
            $modeloTbAtoAdministrativo->getIdOrgaoSuperiorDoAssinante()
        );

        if (!$codigoOrgaoDestino) {
            throw new \Exception("A fase atual do projeto n&atilde;o permite movimentar o projeto.");
        }

        $objTbProjetos = new \Projeto_Model_DbTable_Projetos();
        $objTbProjetos->alterarOrgao($codigoOrgaoDestino, $modeloTbAssinatura->getIdPronac());
    }

}