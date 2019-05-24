<?php

class Assinatura_IndexController extends Assinatura_GenericController
{
    private $idTipoDoAtoAdministrativo;
    private $grupoAtivo;
    private $cod_usuario;
    public $moduloDeOrigem;
    public $redirectRest;

    public function init()
    {
        parent::init();

        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
        $this->cod_usuario = $this->auth->getIdentity()->usu_codigo;

        isset($this->auth->getIdentity()->usu_codigo) ? parent::perfil() : parent::perfil(4);

        $this->definirModuloDeOrigem();
        $this->definirUrlVoltar();

    }

    private function definirModuloDeOrigem()
    {
        $get = Zend_Registry::get('get');
        $post = (object)$this->getRequest()->getPost();
        $this->view->origin = "{$this->moduleName}/index";
        if (!empty($get->origin) || !empty($post->origin)) {
            $this->view->origin = (!empty($post->origin)) ? urldecode($post->origin) : urldecode($get->origin);
        }

        $this->view->originEncoded = urlencode($this->view->origin);
        $this->moduloDeOrigem = $this->view->origin;
    }

    private function definirUrlVoltar()
    {
        $moduleAndControllerArray = explode('/', $this->view->origin);

        $this->view->urlVoltar = strpos($this->view->origin, '#') !== false
            ? "/{$this->view->origin}"
            : "/{$moduleAndControllerArray[0]}/{$moduleAndControllerArray[1]}/gerenciar-assinaturas";

    }

    public function indexAction()
    {
        $this->redirect("/{$this->moduleName}/index/gerenciar-assinaturas");
    }

    public function gerenciarAssinaturasAction()
    {
        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $this->view->dados = [];
        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }

    public function gerenciarAssinaturaAjaxAction()
    {
        $start = $this->getRequest()->getParam('start');
        $length = $this->getRequest()->getParam('length');
        $draw = (int)$this->getRequest()->getParam('draw');
        $search = $this->getRequest()->getParam('search');
        $order = $this->getRequest()->getParam('order');
        $columns = $this->getRequest()->getParam('columns');

        if ($search['value'] != '') {
            $search['value'] = urldecode($search['value']);
            $search['value'] = str_replace('\\', '', $search['value']);
        }
        $get = Zend_Registry::get('get');
        $idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;
        $idTipoDoAtoAdministrativos = [];

        $stringIdTipoDoAtoAdministrativos = $get->idTipoDoAtoAdministrativos;
        if (!is_null($stringIdTipoDoAtoAdministrativos) || !empty($stringIdTipoDoAtoAdministrativos)) {
            array_push($idTipoDoAtoAdministrativos, explode(',', $stringIdTipoDoAtoAdministrativos));
        }

        if (!is_null($idTipoDoAtoAdministrativo) || !empty($idTipoDoAtoAdministrativo)) {
            $idTipoDoAtoAdministrativos[] = $idTipoDoAtoAdministrativo;
        }

        $tbAssinaturaDbTable = new Assinatura_Model_DbTable_TbAssinatura([
            'search' => $search,
            'start' => $start,
            'length' => $length,
            'order' => $order,
            'columns' => $columns
        ]);

        $grupo = '';
        if($idTipoDoAtoAdministrativos) {
            $serviceAtoAdministrativo =  new \Application\Modules\Assinatura\Service\Assinatura\AtoAdministrativo();

            $atoAdministrativo = $serviceAtoAdministrativo->obterAtoAdministrativoAtual(
                $idTipoDoAtoAdministrativos,
                $this->grupoAtivo->codGrupo,
                $this->grupoAtivo->codOrgao,
                $this->auth->getIdentity()->usu_org_max_superior
            );
            $grupo = (count($atoAdministrativo) > 0) ? $atoAdministrativo['grupo'] : '';
        }

        $tbAssinaturaDbTable->preencherModeloAtoAdministrativo([
            'idOrgaoDoAssinante' => $this->grupoAtivo->codOrgao,
            'idPerfilDoAssinante' => $this->grupoAtivo->codGrupo,
            'idOrgaoSuperiorDoAssinante' => $this->auth->getIdentity()->usu_org_max_superior,
            'idTipoDoAto' => $idTipoDoAtoAdministrativos,
            'grupo' => $grupo
        ]);



        $projetosDisponiveis = $tbAssinaturaDbTable->obterAssinaturasDisponiveis();
        $recordsFiltered = 0;
        $recordsTotal = 0;
        $projetos = [];

        $tbAtoAdministrativo = new Assinatura_Model_TbAtoAdministrativo();

        if (count($projetosDisponiveis) > 0) {
            foreach($projetosDisponiveis as $projeto) {
                $projeto['isDisponivelParaDevolucao'] = $tbAtoAdministrativo->isAtoDisponivelParaDevolucao(
                    $projeto['idTipoDoAtoAdministrativo']
                );
                $projetos[] = array_map('utf8_encode', $projeto);
            };
            $recordsTotal = count($projetos);
        }

        $this->_helper->json([
            "data" => $projetos,
            'recordsTotal' => $recordsTotal,
            'draw' => $draw,
            'recordsFiltered' => $recordsFiltered,
        ]);
    }

    /**
     * @deprecated migrado para nova estrutura de Rest e Service > application/modules/projeto/service/documentos-assinados/DocumentosAssinados.php
     *
     */
    public function visualizarAssinaturasAction()
    {
        $this->view->idUsuarioLogado = $this->cod_usuario;
        $documentoAssinatura = new Assinatura_Model_DbTable_TbAssinatura();
        $this->view->dados = $documentoAssinatura->obterProjetosAssinados(
            $this->auth->getIdentity()->usu_org_max_superior,
            $this->cod_usuario
        );

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }

    public function visualizarDocumentosAssinaturaAjaxAction()
    {
        $this->_helper->layout->disableLayout();
        $idPronac = $this->_request->getParam("idPronac");

        $idPronac = isset($idPronac) ? $idPronac : null;

        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        $this->view->idUsuarioLogado = $this->cod_usuario;

        $documentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $this->view->dados = $documentoAssinatura->obterDocumentosAssinadosPorProjeto(
            $idPronac
        );

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }

    protected function obterDocumentoAssinado($idDocumentoAssinatura)
    {
        try {
            try {
                if (!filter_input(INPUT_GET, 'idDocumentoAssinatura')) {
                    throw new Exception("Identificador do Documento &eacute; necess&aacute;rio para acessar essa funcionalidade.");
                }
            } catch (Exception $objException) {
                parent::message($objException->getMessage(), "/{$this->view->origin}/gerenciar-assinaturas");
            }

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $this->view->documentoAssinatura = $objModelDocumentoAssinatura->findBy(
                array('idDocumentoAssinatura' => $idDocumentoAssinatura)
            );

            $this->view->idDocumentoAssinatura = $idDocumentoAssinatura;
            $this->view->IdPRONAC = $this->view->documentoAssinatura['IdPRONAC'];
            $this->view->idTipoDoAtoAdministrativo = $this->view->documentoAssinatura['idTipoDoAtoAdministrativo'];


            $this->view->isProponente = (bool) !$this->cod_usuario ?: false;

            $objAssinatura = new Assinatura_Model_DbTable_TbAssinatura();
            $this->view->assinaturas = $objAssinatura->obterAssinaturas(
                $this->view->IdPRONAC,
                $this->view->idTipoDoAtoAdministrativo,
                $idDocumentoAssinatura
            );

            $moduleAndControllerArray = explode('/', $this->view->origin);
            $this->view->moduleOrigin = $moduleAndControllerArray[0];
            $this->view->controllerOrigin = $moduleAndControllerArray[1];

            $this->view->isPermitidoAssinar = false;
            if ($this->cod_usuario) {
                $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
                $perfilAssinanteAtoAdministrativo = $objTbAtoAdministrativo->obterPerfilAssinante(
                    $this->grupoAtivo->codOrgao,
                    $this->grupoAtivo->codGrupo,
                    $this->view->documentoAssinatura['idTipoDoAtoAdministrativo']
                );

                $tbAtoAdministrativo = new Assinatura_Model_TbAtoAdministrativo();
                $this->view->isDisponivelParaDevolucao = $tbAtoAdministrativo->isAtoDisponivelParaDevolucao(
                    $this->view->documentoAssinatura['idTipoDoAtoAdministrativo']
                );

                if (count($perfilAssinanteAtoAdministrativo) > 0) {
                    $objAssinatura->preencherModeloAssinatura([
                        'idPronac' => $this->view->IdPRONAC,
                        'idAtoAdministrativo' => $perfilAssinanteAtoAdministrativo['idAtoAdministrativo'],
                        'idDocumentoAssinatura' => $idDocumentoAssinatura,
                    ]);

                    if (!$objAssinatura->isProjetoAssinado()
                        && (int)$this->view->documentoAssinatura['cdSituacao'] == (int)Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA) {
                        $this->view->isPermitidoAssinar = true;
                    }
                }
            }

        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/index/visualizar-documento-assinado?idDocumentoAssinatura={$idDocumentoAssinatura}&origin={$this->view->originEncoded }");
        }
    }

    public function visualizarProjetoAction()
    {
        $get = Zend_Registry::get('get');
        if (filter_input(INPUT_GET, 'modal')) {
            $this->_helper->layout->disableLayout();
        }
        $idDocumentoAssinatura = $get->idDocumentoAssinatura;

        $this->obterDocumentoAssinado($idDocumentoAssinatura);
    }

    public function visualizarDocumentoAssinadoAction()
    {
        Zend_Layout::startMvc(array('layout' => 'layout_visualizar'));

        $get = Zend_Registry::get('get');
        $idDocumentoAssinatura = $get->idDocumentoAssinatura;

        $this->obterDocumentoAssinado($idDocumentoAssinatura);
    }

    public function assinarProjetoAction()
    {

        $get = Zend_Registry::get('get');
        $idPronac = $get->IdPRONAC;
        $idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;

        try {
            if (!filter_input(INPUT_GET, 'IdPRONAC') && (is_array($get->IdPRONAC) && count($get->IdPRONAC) < 1)) {
                throw new Exception("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            if (!filter_input(INPUT_GET, 'idTipoDoAtoAdministrativo')) {
                throw new Exception("Identificador do tipo do ato administrativo &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/gerenciar-assinaturas");
        }

        try {
            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();

            $this->view->perfilAssinante = $objTbAtoAdministrativo->obterPerfilAssinante(
                $this->grupoAtivo->codOrgao,
                $this->grupoAtivo->codGrupo,
                $idTipoDoAtoAdministrativo
            );

            if (!$this->view->perfilAssinante) {
                throw new Exception("Usu&aacute;rio sem autoriza&ccedil;&atilde;o para assinar o documento.");
            }

            if (is_array($get->IdPRONAC)) {
                $idPronacUnidos = implode(',', $get->IdPRONAC);
                $this->redirect("/{$this->moduleName}/index/assinar-projeto?IdPRONAC={$idPronacUnidos}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}&origin={$this->view->originEncoded}");
            }

            $this->view->IdPRONAC = $get->IdPRONAC;
            $arrayIdPronacs = explode(',', $get->IdPRONAC);
            if (count($arrayIdPronacs) < 1) {
                throw new Exception("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }
            if ($arrayIdPronacs > 1) {
                $idPronac = current($arrayIdPronacs);
            }

            $post = $this->getRequest()->getPost();


            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $this->view->documentoAssinatura = $objModelDocumentoAssinatura->findBy(
                array(
                    'IdPRONAC' => $idPronac,
                    'idTipoDoAtoAdministrativo' => $idTipoDoAtoAdministrativo,
                    'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                    'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
                )
            );

            $idDocumentoAssinatura = $this->view->documentoAssinatura['idDocumentoAssinatura'];

            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
            $grupoAtoAdministrativo = null;
            if ($idDocumentoAssinatura != '') {
                $grupoAtoAdministrativo = $objTbAtoAdministrativo->obterGrupoPorIdDocumentoAssinatura($idDocumentoAssinatura);
            }
            $dadosAtoAdministrativoAtual = $objTbAtoAdministrativo->obterAtoAdministrativoAtual(
                $idTipoDoAtoAdministrativo,
                $this->grupoAtivo->codGrupo,
                $this->grupoAtivo->codOrgao,
                $grupoAtoAdministrativo
            );

            if ($post) {

                try {
                    $this->view->dsManifestacao = $post['dsManifestacao'];
                    foreach ($arrayIdPronacs as $idPronac) {
                        $documentoAssinatura = $objModelDocumentoAssinatura->findBy(
                            array(
                                'IdPRONAC' => $idPronac,
                                'idTipoDoAtoAdministrativo' => $idTipoDoAtoAdministrativo,
                                'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                                'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
                            )
                        );
                        $tblUsuario = new Autenticacao_Model_DbTable_Usuario();
                        $codOrgaoMaxSuperior = $tblUsuario->recuperarOrgaoMaxSuperior($this->grupoAtivo->codOrgao);

                        $servicoAssinatura = new \MinC\Assinatura\Servico\Assinatura(
                            [
                                'idPronac' => $idPronac,
                                'idAtoAdministrativo' => $dadosAtoAdministrativoAtual['idAtoAdministrativo'],
                                'idAssinante' => $this->auth->getIdentity()->usu_codigo,
                                'dsManifestacao' => $post['dsManifestacao'],
                                'idDocumentoAssinatura' => $documentoAssinatura['idDocumentoAssinatura'],
                                'idTipoDoAto' => $idTipoDoAtoAdministrativo,
                                'idOrgaoDoAssinante' => $this->grupoAtivo->codOrgao,
                                'idPerfilDoAssinante' => $this->grupoAtivo->codGrupo,
                                'idOrgaoSuperiorDoAssinante' => $codOrgaoMaxSuperior
                            ]
                        );

                        $servicoAssinatura->viewModelAssinatura->request = $this->getRequest();
                        $servicoAssinatura->viewModelAssinatura->response = $this->getResponse();
                        $servicoAssinatura->assinarProjeto(
                            $post,
                            $this->auth->getIdentity()
                        );
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
                            "/{$this->moduleName}/index/visualizar-projeto?idDocumentoAssinatura={$idDocumentoAssinatura}&origin={$this->view->originEncoded}",
                            'CONFIRM'
                        );
                    }
                    die;
                } catch (Exception $objException) {
                    parent::message(
                        $objException->getMessage(),
                        "/{$this->moduleName}/index/assinar-projeto?IdPRONAC={$idPronac}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}&origin={$this->view->originEncoded}",
                        'ERROR'
                    );
                }
            }


            $objTbAssinatura = new Assinatura_Model_DbTable_TbAssinatura();
            $assinaturaExistente = $objTbAssinatura->buscar(array(
                'idPronac = ?' => $idPronac,
                'idAtoAdministrativo = ?' => $dadosAtoAdministrativoAtual['idAtoAdministrativo'],
                'idAssinante = ?' => $this->auth->getIdentity()->usu_codigo,
                'idDocumentoAssinatura = ?' => $idDocumentoAssinatura
            ));

            if (count($assinaturaExistente) > 0) {
                throw new Exception("O documento j&aacute; foi assinado pelo usu&aacute;rio logado nesta fase atual.");
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

            $servicoAutenticacao = new \MinC\Assinatura\Servico\Autenticacao(
                $post,
                $this->auth->getIdentity()
            );

            $this->view->templateAutenticacao = $servicoAutenticacao->obterMetodoAutenticacao()->obterTemplateAutenticacao();
            $this->view->idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;

            $this->view->redirectRest = $this->view->origin;

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

            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
            $dadosAtoAdministrativoAtual = $objTbAtoAdministrativo->obterAtoAdministrativoAtual(
                $get->idTipoDoAtoAdministrativo,
                $this->grupoAtivo->codGrupo,
                $this->grupoAtivo->codOrgao
            );

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $dadosDocumentoAssinatura = $objModelDocumentoAssinatura->findBy(
                array(
                    'IdPRONAC' => $get->IdPRONAC,
                    'idTipoDoAtoAdministrativo' => $get->idTipoDoAtoAdministrativo,
                    'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                    'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
                )
            );

            $servicoAssinatura = new \MinC\Assinatura\Servico\Assinatura(
                [
                    'idAtoAdministrativo' => $dadosAtoAdministrativoAtual['idAtoAdministrativo'],
                    'idTipoDoAtoAdministrativo' => $get->idTipoDoAtoAdministrativo,
                    'idTipoDoAto' => $get->idTipoDoAtoAdministrativo,
                    'idOrdemDaAssinatura' => $dadosAtoAdministrativoAtual['idOrdemDaAssinatura'],
                    'idOrgaoSuperiorDoAssinante' => $this->auth->getIdentity()->usu_org_max_superior,
                    'idPronac' => $get->IdPRONAC,
                    'idAssinante' => $this->auth->getIdentity()->usu_codigo,
                    'idDocumentoAssinatura' => $dadosDocumentoAssinatura['idDocumentoAssinatura'],
                    'idPerfilDoAssinante' => $this->grupoAtivo->codGrupo
                ]
            );

            $servicoAssinatura->encaminhar();

            parent::message(
                'Projeto Movimentado com sucesso!',
                "/{$this->view->origin}/gerenciar-assinaturas",
                'CONFIRM'
            );
        } catch (Exception $objException) {
            parent::message(
                $objException->getMessage(),
                "/{$this->view->origin}/gerenciar-assinaturas"
            );
        }
    }

    public function devolverProjetoAction()
    {
        $get = Zend_Registry::get('get');
        $idPronac = $get->IdPRONAC;
        $this->view->IdPRONAC = $get->IdPRONAC;
        $idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;

        try {
            if (!filter_input(INPUT_GET, 'IdPRONAC')) {
                throw new Exception("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            if (!filter_input(INPUT_GET, 'idTipoDoAtoAdministrativo')) {
                throw new Exception("Identificador do tipo do ato administrativo &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            $tbAtoAdministrativo = new Assinatura_Model_TbAtoAdministrativo();
            $isDisponivelParaDevolucao = $tbAtoAdministrativo->isAtoDisponivelParaDevolucao(
                $idTipoDoAtoAdministrativo
            );

            if (!$isDisponivelParaDevolucao) {
                throw new Exception("Este tipo de ato administrativo n&atilde;o est&aacute; dispon&iacute;vel para este tipo de devolu&ccedil;&atilde;o.");
            }

        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->view->origin}/gerenciar-assinaturas");
        }

        try {
            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();

            $this->view->perfilAssinante = $objTbAtoAdministrativo->obterPerfilAssinante(
                $this->grupoAtivo->codOrgao,
                $this->grupoAtivo->codGrupo,
                $idTipoDoAtoAdministrativo
            );

            if (!$this->view->perfilAssinante) {
                throw new Exception("Usu&aacute;rio sem autoriza&ccedil;&atilde;o para devolver o documento.");
            }

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $this->view->documentoAssinatura = $objModelDocumentoAssinatura->findBy(
                array(
                    'IdPRONAC' => $idPronac,
                    'idTipoDoAtoAdministrativo' => $idTipoDoAtoAdministrativo,
                    'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                    'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
                )
            );

            $idDocumentoAssinatura = $this->view->documentoAssinatura['idDocumentoAssinatura'];

            $post = $this->getRequest()->getPost();
            if ($post) {
                try {
                    $documentoAssinatura = $objModelDocumentoAssinatura->findBy(
                        array(
                            'IdPRONAC' => $idPronac,
                            'idTipoDoAtoAdministrativo' => $idTipoDoAtoAdministrativo,
                            'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                            'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
                        )
                    );

                    $servicoAssinatura = new \MinC\Assinatura\Servico\Assinatura(
                        [
                            'idPronac' => $idPronac,
                            'dsMotivoDevolucao' => $post['dsMotivoDevolucao'],
                            'idAssinante' => $this->auth->getIdentity()->usu_codigo,
                            'idDocumentoAssinatura' => $documentoAssinatura['idDocumentoAssinatura'],
                            'idTipoDoAto' => $idTipoDoAtoAdministrativo,
                            'idPerfilDoAssinante' => $this->grupoAtivo->codGrupo
                        ]
                    );

                    $servicoAssinatura->viewModelAssinatura->request = $this->getRequest();
                    $servicoAssinatura->viewModelAssinatura->response = $this->getResponse();

                    $servicoAssinatura->devolver();

                    parent::message(
                        "Projeto devolvido com sucesso!",
                        "/{$this->view->origin}/gerenciar-assinaturas",
                        'CONFIRM'
                    );
                    die;
                } catch (Exception $objException) {
                    parent::message(
                        $objException->getMessage(),
                        "/{$this->moduleName}/index/devolver-projeto?IdPRONAC={$idPronac}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}&origin={$this->view->originEncoded}",
                        'ERROR'
                    );
                }
            }

            $objTbAssinatura = new Assinatura_Model_DbTable_TbMotivoDevolucao();
            $documentoDevolvido = $objTbAssinatura->buscar(array(
                'idDocumentoAssinatura = ?' => $idDocumentoAssinatura
            ));

            if (count($documentoDevolvido) > 0) {
                throw new Exception("O documento j&aacute; foi devolvido!");
            }

            $objProjeto = new Projeto_Model_DbTable_Projetos();
            $this->view->projeto = $objProjeto->findBy(array(
                'IdPRONAC' => $idPronac
            ));

            $objVerificacao = new Verificacao();
            $this->view->tipoDocumento = $objVerificacao->findBy(array(
                'idVerificacao = ?' => $idTipoDoAtoAdministrativo
            ));

            $servicoAutenticacao = new \MinC\Assinatura\Servico\Autenticacao(
                $post,
                $this->auth->getIdentity()
            );

            $this->view->templateAutenticacao = $servicoAutenticacao->obterMetodoAutenticacao()->obterTemplateAutenticacao();
            $this->view->idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;

            $this->view->redirectRest = $this->view->origin;

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
}
