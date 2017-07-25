<?php

class jSolicitacao_IndexController extends jSolicitacao_GenericController
{
    private $idTipoDoAtoAdministrativo;

    private $grupoAtivo;

    private $cod_usuario;

    public function init()
    {
        parent::init();

        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
        parent::perfil();

        $this->cod_usuario = $this->auth->getIdentity()->usu_codigo;

        $this->definirModuloDeOrigem();
    }

    private function definirModuloDeOrigem() {
//        $this->view->module = $this->moduleName;
        $get = Zend_Registry::get('get');
        $post = (object)$this->getRequest()->getPost();
        $this->view->origin = "{$this->moduleName}/index";
        if(!empty($get->origin) || !empty($post->origin)) {
            $this->view->origin = (!empty($post->origin)) ? $post->origin : $get->origin;
        }
    }

    public function indexAction()
    {
        $this->redirect("/{$this->moduleName}/index/gerenciar-assinaturas");
    }

    public function gerenciarjSolicitacaosAction()
    {
        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $documentojSolicitacao = new jSolicitacao_Model_DbTable_TbDocumentojSolicitacao();
        $this->view->dados = $documentojSolicitacao->obterProjetosComjSolicitacaosAbertas(
            $this->grupoAtivo->codOrgao,
            $this->grupoAtivo->codGrupo
        );

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }

    public function visualizarjSolicitacaosAction()
    {
        $this->view->idUsuarioLogado = $this->cod_usuario;
        $documentojSolicitacao = new jSolicitacao_Model_DbTable_TbjSolicitacao();
        $this->view->dados = $documentojSolicitacao->obterProjetosAssinados(
            $this->grupoAtivo->codOrgao,
            $this->cod_usuario
        );

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }

    public function visualizarProjetoAction()
    {
        $get = Zend_Registry::get('get');
        $idDocumentojSolicitacao = $get->idDocumentojSolicitacao;

        try {
            try {
                if (!filter_input(INPUT_GET, 'idDocumentojSolicitacao')) {
                    throw new Exception("Identificador do Documento &eacute; necess&aacute;rio para acessar essa funcionalidade.");
                }
            } catch (Exception $objException) {
                parent::message($objException->getMessage(), "/{$this->view->origin}/gerenciar-assinaturas");
            }

            $objModelDocumentojSolicitacao = new jSolicitacao_Model_DbTable_TbDocumentojSolicitacao();
            $this->view->documentojSolicitacao = $objModelDocumentojSolicitacao->findBy(
                array('idDocumentojSolicitacao' => $idDocumentojSolicitacao)
            );


            $this->view->idDocumentojSolicitacao = $idDocumentojSolicitacao;
            $this->view->IdPRONAC = $this->view->documentojSolicitacao['IdPRONAC'];
            $this->view->idTipoDoAtoAdministrativo = $this->view->documentojSolicitacao['idTipoDoAtoAdministrativo'];

            $objTbProjetos = new Projeto_Model_DbTable_Projetos();
            $this->view->projeto = $objTbProjetos->findBy(array(
                'IdPRONAC' => $this->view->IdPRONAC
            ));

            $this->view->valoresProjeto = $objTbProjetos->obterValoresProjeto($this->view->IdPRONAC);
            $objAgentes = new Agente_Model_DbTable_Agentes();
            $dadosAgente = $objAgentes->buscarFornecedor(array(
                'a.CNPJCPF = ?' => $this->view->projeto['CgcCpf']
            ));

            $arrayDadosAgente = $dadosAgente->current();
            $this->view->nomeAgente = $arrayDadosAgente['nome'];

            $mapperArea = new Agente_Model_AreaMapper();
            $this->view->areaCultural = $mapperArea->findBy(array(
                'Codigo' => $this->view->projeto['Area']
            ));

            $objSegmentocultural = new Segmentocultural();
            $this->view->segmentoCultural = $objSegmentocultural->findBy(array(
                'Codigo' => $this->view->projeto['Segmento']
            ));

            $objPlanoDistribuicaoProduto = new Projeto_Model_vwPlanoDeDistribuicaoProduto();
            $this->view->dadosProducaoProjeto = $objPlanoDistribuicaoProduto->obterProducaoProjeto(array(
                'IdPronac = ?' => $this->view->IdPRONAC
            ));

            $objjSolicitacao = new jSolicitacao_Model_DbTable_TbjSolicitacao();
            $this->view->assinaturas = $objjSolicitacao->obterjSolicitacaos(
                $this->view->IdPRONAC,
                $this->view->idTipoDoAtoAdministrativo,
                $idDocumentojSolicitacao
            );

            $objTbAtoAdministrativo = new jSolicitacao_Model_DbTable_TbAtoAdministrativo();
            $this->view->quantidade_minima_assinaturas = $objTbAtoAdministrativo->obterQuantidadeMinimajSolicitacaos(
                $this->view->idTipoDoAtoAdministrativo
            );

            $moduleAndControllerArray = explode('/', $this->view->origin);
            $this->view->moduleOrigin = $moduleAndControllerArray[0];
            $this->view->controllerOrigin = $moduleAndControllerArray[1];

        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/index/visualizar-projeto?idDocumentojSolicitacao={$idDocumentojSolicitacao}&origin={$this->view->origin}");
        }
    }

    public function assinarProjetoAction()
    {
        $get = Zend_Registry::get('get');
        $idPronac = $get->IdPRONAC;
        $idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;

        try {
            if (!filter_input(INPUT_GET, 'IdPRONAC') && (is_array($get->IdPRONAC) && count($get->IdPRONAC) < 1) ) {
                throw new Exception("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            if (!filter_input(INPUT_GET, 'idTipoDoAtoAdministrativo')) {
                throw new Exception("Identificador do tipo do ato administrativo &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->view->origin}/gerenciar-assinaturas");
        }


        try {
            $objTbAtoAdministrativo = new jSolicitacao_Model_DbTable_TbAtoAdministrativo();

            $this->view->perfilAssinante = $objTbAtoAdministrativo->obterPerfilAssinante(
                $this->grupoAtivo->codOrgao,
                $this->grupoAtivo->codGrupo,
                $idTipoDoAtoAdministrativo
            );

            if (!$this->view->perfilAssinante) {
                throw new Exception ("Usu&aacute;rio sem autoriza&ccedil;&atilde;o para assinar o documento.");
            }

            if (is_array($get->IdPRONAC)) {
                $idPronacUnidos = implode(',', $get->IdPRONAC);
                $this->redirect("/{$this->moduleName}/index/assinar-projeto?IdPRONAC={$idPronacUnidos}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}&isMovimentarjSolicitacao={$get->isMovimentarjSolicitacao}&origin={$this->view->origin}");
            }

            $this->view->IdPRONAC = $get->IdPRONAC;
            $arrayIdPronacs = explode(',', $get->IdPRONAC);
            if (count($arrayIdPronacs) < 1) {
                throw new Exception ("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            $post = $this->getRequest()->getPost();
            $objjSolicitacao = new MinC_jSolicitacao_Servico_jSolicitacao($post, $this->auth->getIdentity());
            $objjSolicitacao->isMovimentarProjetoPorOrdemjSolicitacao = false;

            $objModelDocumentojSolicitacao = new jSolicitacao_Model_DbTable_TbDocumentojSolicitacao();
            $this->view->documentojSolicitacao = $objModelDocumentojSolicitacao->findBy(
                array(
                    'IdPRONAC' => $idPronac,
                    'idTipoDoAtoAdministrativo' => $idTipoDoAtoAdministrativo,
                    'cdSituacao' => jSolicitacao_Model_TbDocumentojSolicitacao::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                    'stEstado' => jSolicitacao_Model_TbDocumentojSolicitacao::ST_ESTADO_DOCUMENTO_ATIVO
                )
            );

            $idDocumentojSolicitacao = $this->view->documentojSolicitacao['idDocumentojSolicitacao'];

            if ($post) {

                if($get->isMovimentarjSolicitacao == 'true') {
                    $objjSolicitacao->isMovimentarProjetoPorOrdemjSolicitacao = true;
                }

                try {
                    $this->view->dsManifestacao = $post['dsManifestacao'];
                    foreach ($arrayIdPronacs as $idPronac) {

                        $modeljSolicitacao = new MinC_jSolicitacao_Model_jSolicitacao();
                        $modeljSolicitacao->setCodGrupo($this->grupoAtivo->codGrupo)
                            ->setCodOrgao($this->grupoAtivo->codOrgao)
                            ->setIdPronac($idPronac)
                            ->setIdTipoDoAtoAdministrativo($idTipoDoAtoAdministrativo)
                            ->setIdDocumentojSolicitacao($idDocumentojSolicitacao)
                            ->setDsManifestacao($post['dsManifestacao']);
                        $objjSolicitacao->assinarProjeto($modeljSolicitacao);
                    }

                    if (count($arrayIdPronacs) > 1) {
                        parent::message(
                            "Projetos assinados com sucesso!",
                            "/{$this->view->origin}/gerenciar-assinaturas",
                            'CONFIRM'
                        );
                    } else {
                        parent::message(
                            "Projeto assinado com sucesso!",
                            "/{$this->moduleName}/index/visualizar-projeto?idDocumentojSolicitacao={$idDocumentojSolicitacao}&isMovimentarjSolicitacao={$get->isMovimentarjSolicitacao}&origin={$this->view->origin}",
                            'CONFIRM'
                        );
                        die;
                    }
                } catch (Exception $objException) {
                    parent::message(
                        $objException->getMessage(),
                        "/{$this->moduleName}/index/assinar-projeto?IdPRONAC={$idPronac}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}&isMovimentarjSolicitacao={$get->isMovimentarjSolicitacao}&origin={$this->view->origin}",
                        'ERROR'
                    );
                }
            }



            $objTbAtoAdministrativo = new jSolicitacao_Model_DbTable_TbAtoAdministrativo();
            $dadosAtoAdministrativoAtual = $objTbAtoAdministrativo->obterAtoAdministrativoAtual(
                $idTipoDoAtoAdministrativo,
                $this->grupoAtivo->codGrupo,
                $this->grupoAtivo->codOrgao
            );

            $objTbjSolicitacao = new jSolicitacao_Model_DbTable_TbjSolicitacao();
            $assinaturaExistente = $objTbjSolicitacao->buscar(array(
                'idPronac = ?' => $idPronac,
                'idAtoAdministrativo = ?' => $dadosAtoAdministrativoAtual['idAtoAdministrativo'],
                'idAssinante = ?' => $this->auth->getIdentity()->usu_codigo,
                'idDocumentojSolicitacao = ?' => $idDocumentojSolicitacao
            ));

            if($assinaturaExistente->current()) {
                throw new Exception ("O documento j&aacute; foi assinado pelo usu&aacute;rio logado nesta fase atual.");
            }

            $objProjeto = new Projeto_Model_DbTable_Projetos();
            $this->view->projeto = array();
            foreach ($arrayIdPronacs as $idPronac) {
                $this->view->projeto[] = $objProjeto->findBy(array(
                    'IdPRONAC' => $idPronac
                ));
            }

            $objVerificacao = new Verificacao();
            $this->view->tipoDocumento = $objVerificacao->findBy(array(
                'idVerificacao = ?' => $idTipoDoAtoAdministrativo
            ));

            $this->view->templateAutenticacao = $objjSolicitacao->obterServicoAutenticacao()->obterMetodoAutenticacao()->obterTemplateAutenticacao();
            $this->view->idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;
            $this->view->isMovimentarjSolicitacao = false;

            if($get->isMovimentarjSolicitacao == 'true') {
                $this->view->isMovimentarjSolicitacao = 'true';
            }

            $moduleAndControllerArray = explode('/', $this->view->origin);
            $this->view->moduleOrigin = $moduleAndControllerArray[0];
            $this->view->controllerOrigin = $moduleAndControllerArray[1];

        } catch (Exception $objException) {

            parent::message(
                $objException->getMessage(),
                "/{$this->view->origin}/gerenciar-assinaturas"
            );
        }
    }

    public function movimentarProjetoAction()
    {
        try {
            $get = Zend_Registry::get('get');

            if (!filter_input(INPUT_GET, 'IdPRONAC')) {
                throw new Exception("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            if (!filter_input(INPUT_GET, 'idTipoDoAtoAdministrativo')) {
                throw new Exception("Identificador do tipo do ato administrativo &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }
            $modeljSolicitacao = new MinC_jSolicitacao_Model_jSolicitacao();
            $modeljSolicitacao->setIdPronac($get->IdPRONAC);
            $modeljSolicitacao->setIdTipoDoAtoAdministrativo($get->idTipoDoAtoAdministrativo);

            $objTbAtoAdministrativo = new jSolicitacao_Model_DbTable_TbAtoAdministrativo();
            $dadosAtoAdministrativoAtual = $objTbAtoAdministrativo->obterAtoAdministrativoAtual(
                $modeljSolicitacao->getIdTipoDoAtoAdministrativo(),
                $this->grupoAtivo->codGrupo,
                $this->grupoAtivo->codOrgao
            );

            $objModelDocumentojSolicitacao = new jSolicitacao_Model_DbTable_TbDocumentojSolicitacao();
            $dadosDocumentojSolicitacao = $objModelDocumentojSolicitacao->findBy(
                array(
                    'IdPRONAC' => $modeljSolicitacao->getIdPronac(),
                    'idTipoDoAtoAdministrativo' => $modeljSolicitacao->getIdTipoDoAtoAdministrativo(),
                    'cdSituacao' => jSolicitacao_Model_TbDocumentojSolicitacao::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                    'stEstado' => jSolicitacao_Model_TbDocumentojSolicitacao::ST_ESTADO_DOCUMENTO_ATIVO
                )
            );

            $servicojSolicitacao = new MinC_jSolicitacao_Servico_jSolicitacao();

            $modeljSolicitacao->setIdOrdemDajSolicitacao($dadosAtoAdministrativoAtual['idOrdemDajSolicitacao']);
            $modeljSolicitacao->setIdAtoAdministrativo($dadosAtoAdministrativoAtual['idAtoAdministrativo']);
            $modeljSolicitacao->setIdAssinante($this->auth->getIdentity()->usu_codigo);
            $modeljSolicitacao->setIdDocumentojSolicitacao($dadosDocumentojSolicitacao['idDocumentojSolicitacao']);
            $servicojSolicitacao->movimentarProjetoAssinadoPorOrdemDejSolicitacao($modeljSolicitacao);

            parent::message(
                'Projeto Movimentado com sucesso!'
                ,"/{$this->view->origin}/gerenciar-assinaturas"
                ,'CONFIRM'
            );
        } catch (Exception $objException) {
            parent::message(
                $objException->getMessage()
                ,"/{$this->view->origin}/gerenciar-assinaturas"
            );
        }
    }

    public function gerarPdfAction()
    {
        ini_set("memory_limit", "5000M");
        set_time_limit(30);

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $cssContents = file_get_contents(APPLICATION_PATH . '/../public/library/materialize/css/materialize.css');
        $cssContents .= file_get_contents(APPLICATION_PATH . '/../public/library/materialize/css/materialize-custom.css');
        $html = $_POST['html'];

        $pdf = new mPDF('pt', 'A4', 12, '', 8, 8, 5, 14, 9, 9, 'P');
        $pdf->allow_charset_conversion = true;
        $pdf->WriteHTML($cssContents, 1);
        $pdf->charset_in = 'ISO-8859-1';

        if(!mb_check_encoding($html, 'ISO-8859-1')) {
            $pdf->charset_in = 'UTF-8';
        }

        $pdf->WriteHTML($html, 2);
        $pdf->Output();
        die;
    }
}