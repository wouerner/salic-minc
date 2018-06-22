<?php

namespace MinC\Assinatura\Servico;

/**
 * @var \Assinatura_Model_DbTable_TbAssinatura $dbTableTbAssinatura
 * @var \MinC\Assinatura\Model\Assinatura $viewModelAssinatura
 * @var \MinC\Assinatura\Acao\IListaAcoesModulo[] $listaAcoes
 */
class Assinatura implements IServico
{
    public $isEncaminharParaProximoAssinanteAoAssinar = true;
    public $viewModelAssinatura;
    public static $listaAcoesGerais = [];
    private $listaAcoes = [];
    private $idTipoDoAtoAdministrativo;

    function __construct($idTipoDoAtoAdministrativo)
    {
        $this->idTipoDoAtoAdministrativo = $idTipoDoAtoAdministrativo;
        $this->isolarAcoesPorTipoDeAto();
        $this->viewModelAssinatura = new \MinC\Assinatura\Model\Assinatura();
    }

    public function definirModeloAssinatura(array $dados = [])
    {
        $this->viewModelAssinatura = new \MinC\Assinatura\Model\Assinatura($dados);
    }

    public static function definirAcoesGerais(\MinC\Assinatura\Acao\IListaAcoesGerais $listaAcoes)
    {
        if(!isset(self::$listaAcoesGerais)) {
            self::$listaAcoesGerais = $listaAcoes->obterLista();
        }
    }

    private function isolarAcoesPorTipoDeAto()
    {
        if(count(self::$listaAcoesGerais) > 0 && isset(self::$listaAcoesGerais[$this->idTipoDoAtoAdministrativo])) {
            $this->listaAcoes = self::$listaAcoesGerais[$this->idTipoDoAtoAdministrativo];
        }
    }

    private function executarAcoes(string $tipoAcao)
    {
        foreach($this->listaAcoes as $acao) {
            /**
             * @var \MinC\Assinatura\Acao\IAcao $acao
             */
            if($acao instanceof \MinC\Assinatura\Acao\IAcao && $acao instanceof $tipoAcao) {
                $acao->executar($this->viewModelAssinatura);
            }
        }
    }

    public function assinarProjeto($post, $identidadeUsuarioLogado)
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
            $post,
            $identidadeUsuarioLogado
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

        $dbTableTbAssinatura = $this->viewModelAssinatura->dbTableTbAssinatura;
        $dbTableTbAssinatura->preencherModeloAssinatura([
            'idAssinante' => $modeloTbAssinatura->getIdAssinante(),
            'idPronac' => $modeloTbAssinatura->getIdPronac(),
            'idAtoAdministrativo' => $dadosAtoAdministrativoAtual['idAtoAdministrativo'],
            'idDocumentoAssinatura' => $modeloTbAssinatura->getIdDocumentoAssinatura()
        ]);

        if($dbTableTbAssinatura->isProjetoAssinado()) {
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

        $dbTableTbAssinatura->inserir($dadosInclusaoAssinatura);
        $codigoOrgaoDestino = $objTbAtoAdministrativo->obterProximoOrgaoDeDestino(
            $modeloTbAtoAdministrativo->getIdTipoDoAto(),
            $modeloTbAtoAdministrativo->getIdOrdemDaAssinatura(),
            $modeloTbAtoAdministrativo->getIdOrgaoSuperiorDoAssinante()
        );

        if($this->isEncaminharParaProximoAssinanteAoAssinar && $codigoOrgaoDestino) {
            $this->encaminhar();
        }

        $this->executarAcoes('\MinC\Assinatura\Acao\IAcaoAssinar');
    }

    /**
     * @throws \Exception
     * @uses \MinC\Assinatura\Model\Assinatura
     */
    public function encaminhar()
    {
        $modeloTbAtoAdministrativo = $this->viewModelAssinatura->modeloTbAtoAdministrativo;
        if (!$modeloTbAtoAdministrativo->getIdOrdemDaAssinatura()) {
            throw new \Exception("A fase atual do projeto n&atilde;o permite movimentar o projeto.");
        }

        $modeloTbAssinatura = $this->viewModelAssinatura->modeloTbAssinatura;
        $dbTableTbAssinatura = $this->viewModelAssinatura->dbTableTbAssinatura;
        $dbTableTbAssinatura->modeloTbAssinatura = $modeloTbAssinatura;
        if(!$dbTableTbAssinatura->isProjetoAssinado()) {
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

        $this->executarAcoes('\MinC\Assinatura\Acao\IAcaoEncaminhar');
    }

    public function devolver()
    {
        $this->executarAcoes('\MinC\Assinatura\Acao\IAcaoDevolver');
    }

    public function finalizar()
    {
        $this->executarAcoes('\MinC\Assinatura\Acao\IAcaoFinalizar');
    }

}