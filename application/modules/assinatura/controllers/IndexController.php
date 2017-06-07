<?php

class Assinatura_IndexController extends Assinatura_GenericController
{
    private $idTipoDoAtoAdministrativo;

    private $grupoAtivo;

    public function init()
    {
        parent::init();

        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
        parent::perfil();
    }

    public function indexAction()
    {
        $this->redirect("/{$this->moduleName}/index/gerenciar-assinaturas");
    }

    public function gerenciarAssinaturasAction()
    {
        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $documentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $this->view->dados = $documentoAssinatura->obterProjetosComAssinaturasAbertas(
            $this->grupoAtivo->codOrgao,
            $this->grupoAtivo->codGrupo
        );

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }

    public function visualizarProjetoAction()
    {
        $get = Zend_Registry::get('get');
        $idPronac = $get->IdPRONAC;
        $idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;
        try {
            try {
                if (!filter_input(INPUT_GET, 'IdPRONAC')) {
                    throw new Exception("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
                }

                if (!filter_input(INPUT_GET, 'idTipoDoAtoAdministrativo')) {
                    throw new Exception("Identificador do tipo do ato administrativo &eacute; necess&aacute;rio para acessar essa funcionalidade.");
                }
            } catch (Exception $objException) {
                parent::message($objException->getMessage(), "/{$this->moduleName}/index/gerenciar-assinaturas");
            }

            $this->view->IdPRONAC = $idPronac;
            $this->view->idTipoDoAtoAdministrativo = $idTipoDoAtoAdministrativo;

            $objTbProjetos = new Projeto_Model_DbTable_Projetos();
            $this->view->projeto = $objTbProjetos->findBy(array(
                'IdPRONAC' => $idPronac
            ));

            $this->view->valoresProjeto = $objTbProjetos->obterValoresProjeto($idPronac);
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
                'IdPronac = ?' => $idPronac
            ));

            $objAssinatura = new Assinatura_Model_DbTable_TbAssinatura();
            $this->view->assinaturas = $objAssinatura->obterAssinaturas($idPronac, $idTipoDoAtoAdministrativo);

            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
            $this->view->quantidade_minima_assinaturas = $objTbAtoAdministrativo->obterQuantidadeMinimaAssinaturas($idTipoDoAtoAdministrativo);

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $this->view->documentoAssinatura = $objModelDocumentoAssinatura->findBy(
                array(
                    'IdPRONAC' => $idPronac,
                    'idTipoDoAtoAdministrativo' => $idTipoDoAtoAdministrativo
                )
            );

        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/index/visualizar-projeto?IdPRONAC={$idPronac}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}");
        }
    }

    public function assinarProjetoAction()
    {
        $get = Zend_Registry::get('get');
        $idPronac = $get->IdPRONAC;
        $idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;

        try {
            if (!filter_input(INPUT_GET, 'IdPRONAC')) {
                throw new Exception("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            if (!filter_input(INPUT_GET, 'idTipoDoAtoAdministrativo')) {
                throw new Exception("Identificador do tipo do ato administrativo &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/index/gerenciar-assinaturas");
        }

        try {
            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();

            $this->view->perfilAssinante = $objTbAtoAdministrativo->obterPerfilAssinante(
                $this->grupoAtivo->codOrgao,
                $this->grupoAtivo->codGrupo,
                $idTipoDoAtoAdministrativo
            );

            if (!$this->view->perfilAssinante) {
                throw new Exception ("A fase atual de assinaturas do projeto atual n&atilde;o permite realizar essa opera&ccedil;&atilde;o.");
            }

            if (is_array($get->IdPRONAC)) {
                $idPronacUnidos = implode(',', $get->IdPRONAC);
                $this->redirect("/{$this->moduleName}/index/assinar-projeto?IdPRONAC={$idPronacUnidos}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}");
            }

            $this->view->IdPRONAC = $get->IdPRONAC;
            $arrayIdPronacs = explode(',', $get->IdPRONAC);
            if (count($arrayIdPronacs) < 1) {
                throw new Exception ("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            $post = $this->getRequest()->getPost();
            $objAssinatura = new MinC_Assinatura_Servico_Assinatura($post, $this->auth->getIdentity());
            $objAssinatura->isMovimentarProjetoPorOrdemAssinatura = false;

            if ($post) {

                if($get->isMovimentarAssinatura == 'true') {
                    $objAssinatura->isMovimentarProjetoPorOrdemAssinatura = true;
                }

                try {
                    $this->view->dsManifestacao = $post['dsManifestacao'];
                    foreach ($arrayIdPronacs as $idPronac) {

                        $modelAssinatura = new MinC_Assinatura_Model_Assinatura();
                        $modelAssinatura->setCodGrupo($this->grupoAtivo->codGrupo)
                            ->setCodOrgao($this->grupoAtivo->codOrgao)
                            ->setIdPronac($idPronac)
                            ->setIdTipoDoAtoAdministrativo($idTipoDoAtoAdministrativo)
                            ->setDsManifestacao($post['dsManifestacao']);
                        $objAssinatura->assinarProjeto($modelAssinatura);
                    }

                    if (count($arrayIdPronacs) > 1) {
                        parent::message(
                            "Projetos assinados com sucesso!",
                            "/{$this->moduleName}/index/gerenciar-assinaturas",
                            'CONFIRM'
                        );
                    } else {
                        parent::message(
                            "Projeto assinado com sucesso!",
                            "/{$this->moduleName}/index/visualizar-projeto?IdPRONAC={$idPronac}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}",
                            'CONFIRM'
                        );
                        die;
                    }
                } catch (Exception $objException) {
                    parent::message(
                        $objException->getMessage(),
                        "/{$this->moduleName}/index/assinar-projeto?IdPRONAC={$idPronac}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}",
                        'ERROR'
                    );
                }
            }

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $this->view->documentoAssinatura = $objModelDocumentoAssinatura->findBy(
                array(
                    'IdPRONAC' => $idPronac,
                    'idTipoDoAtoAdministrativo' => $idTipoDoAtoAdministrativo
                )
            );
            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $documentoAssinatura = $objModelDocumentoAssinatura->findBy(
                array(
                    'IdPRONAC' => $idPronac,
                    'idTipoDoAtoAdministrativo' => $idTipoDoAtoAdministrativo,
                    'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA
                )
            );

            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
            $dadosAtoAdministrativoAtual = $objTbAtoAdministrativo->obterAtoAdministrativoAtual(
                $idTipoDoAtoAdministrativo,
                $this->grupoAtivo->codGrupo,
                $this->grupoAtivo->codOrgao
            );

            $objTbAssinatura = new Assinatura_Model_DbTable_TbAssinatura();
            $assinaturaExistente = $objTbAssinatura->buscar(array(
                'idPronac = ?' => $idPronac,
                'idAtoAdministrativo = ?' => $dadosAtoAdministrativoAtual['idAtoAdministrativo'],
                'idAssinante = ?' => $this->auth->getIdentity()->usu_codigo,
                'idDocumentoAssinatura = ?' => $documentoAssinatura['idDocumentoAssinatura']
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

            $this->view->templateAutenticacao = $objAssinatura->obterServicoAutenticacao()->obterMetodoAutenticacao()->obterTemplateAutenticacao();
            $this->view->idTipoDoAtoAdministrativo = $get->idTipoDoAtoAdministrativo;
            $this->view->isMovimentarAssinatura = false;

            if($get->isMovimentarAssinatura == 'true') {
                $this->view->isMovimentarAssinatura = 'true';
            }

        } catch (Exception $objException) {

            parent::message(
                $objException->getMessage(),
                "/{$this->moduleName}/index/gerenciar-assinaturas"
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
            $modelAssinatura = new MinC_Assinatura_Model_Assinatura();
            $modelAssinatura->setIdPronac($get->IdPRONAC);
            $modelAssinatura->setIdTipoDoAtoAdministrativo($get->idTipoDoAtoAdministrativo);

            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
            $dadosAtoAdministrativoAtual = $objTbAtoAdministrativo->obterAtoAdministrativoAtual(
                $modelAssinatura->getIdTipoDoAtoAdministrativo(),
                $this->grupoAtivo->codGrupo,
                $this->grupoAtivo->codOrgao
            );

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $dadosDocumentoAssinatura = $objModelDocumentoAssinatura->findBy(
                array(
                    'IdPRONAC' => $modelAssinatura->getIdPronac(),
                    'idTipoDoAtoAdministrativo' => $modelAssinatura->getIdTipoDoAtoAdministrativo(),
                    'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA
                )
            );

            $servicoAssinatura = new MinC_Assinatura_Servico_Assinatura();

            $modelAssinatura->setIdOrdemDaAssinatura($dadosAtoAdministrativoAtual['idOrdemDaAssinatura']);
            $modelAssinatura->setIdAtoAdministrativo($dadosAtoAdministrativoAtual['idAtoAdministrativo']);
            $modelAssinatura->setIdAssinante($this->auth->getIdentity()->usu_codigo);
            $modelAssinatura->setIdDocumentoAssinatura($dadosDocumentoAssinatura['idDocumentoAssinatura']);
            $servicoAssinatura->movimentarProjetoAssinadoPorOrdemDeAssinatura($modelAssinatura);

            parent::message(
                'Projeto Movimentado com sucesso!'
                ,"/{$this->moduleName}/index/gerenciar-assinaturas"
                ,'CONFIRM'
            );
        } catch (Exception $objException) {
            parent::message(
                $objException->getMessage()
                ,"/{$this->moduleName}/index/gerenciar-assinaturas"
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