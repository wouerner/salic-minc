<?php

class Readequacao_ReadequacaoAssinaturaController extends Readequacao_GenericController
{

    private $idTiposAtoAdministrativos = [
        Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_READEQUACAO_DE_PROJETO,
        Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_AJUSTE_DE_PROJETO,
        655
    ];

    private function validarPerfis()
    {
        $auth = Zend_Auth::getInstance();

        $PermissoesGrupo = array();
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::PARECERISTA;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::COORDENADOR_DE_PARECERISTA;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::DIRETOR_DEPARTAMENTO;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::COORDENADOR_GERAL_ACOMPANHAMENTO;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::TECNICO_ACOMPANHAMENTO;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::COORDENADOR_ACOMPANHAMENTO;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::SECRETARIO;

        isset($auth->getIdentity()->usu_codigo) ? parent::perfil(1, $PermissoesGrupo) : parent::perfil(4, $PermissoesGrupo);
    }

    public function init()
    {
        parent::init();

        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
    }

    public function indexAction()
    {
        $this->validarPerfis();
        $this->redirect("/{$this->moduleName}/readequacao-assinatura/gerenciar-assinaturas");
    }

    public function gerenciarAssinaturasAction()
    {
        $this->validarPerfis();
        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $documentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();

        $this->view->dados = $documentoAssinatura->obterProjetosComAssinaturasAbertas(
            $this->grupoAtivo->codOrgao,
            $this->grupoAtivo->codGrupo,
            $this->auth->getIdentity()->usu_org_max_superior,
            $this->idTiposAtoAdministrativos
        );

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;

        $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
        $this->view->quantidade_minima_assinaturas = $objTbAtoAdministrativo->obterQuantidadeMinimaAssinaturas(
            $this->idTiposAtoAdministrativos,
            $this->auth->getIdentity()->usu_org_max_superior
        );
        $this->view->idTipoDoAtoAdministrativo = $this->idTipoDoAtoAdministrativo;
    }

    public function devolverProjetoAction()
    {
        $this->validarPerfis();
        $get = Zend_Registry::get('get');
        try {
            if (!filter_input(INPUT_GET, 'IdPRONAC')) {
                throw new Exception("Identificador do projeto é necessário para acessar essa funcionalidade.");
            }

            $objTbProjetos = new Projeto_Model_DbTable_Projetos();

            $projeto = $objTbProjetos->findBy(array(
                'IdPRONAC' => $get->IdPRONAC
            ));

            $post = $this->getRequest()->getPost();
            if ($post) {

                if (!filter_input(INPUT_POST, 'idTipoDoAtoAdministrativo')) {
                    throw new Exception("Identificador do Tipo do Ato Administrativo n&atilde;o informado");
                }
                $idTipoDoAtoAdministrativo = $post['idTipoDoAtoAdministrativo'];

                if (!filter_input(INPUT_POST, 'motivoDevolucao')) {
                    throw new Exception("Campo 'Motivação da Devolução para nova avaliação' n&atilde;o informado.");
                }

                $servicoDocumentoAssinatura = new \MinC\Assinatura\Servico\Assinatura(
                    $idTipoDoAtoAdministrativo
                );
                $servicoDocumentoAssinatura->devolver();

                parent::message('Projeto devolvido com sucesso.', "/{$this->moduleName}/readequacao-assinatura/gerenciar-assinaturas", 'CONFIRM');
            }

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $this->view->abertoParaDevolucao = $objModelDocumentoAssinatura->isProjetoDisponivelParaAssinatura(
                $get->IdPRONAC,
                $this->idTiposAtoAdministrativos
            );

            $this->view->IdPRONAC = $get->IdPRONAC;

            $mapperArea = new Agente_Model_AreaMapper();
            $this->view->areaCultural = $mapperArea->findBy(array(
                'Codigo' => $projeto['Area']
            ));

            $objSegmentocultural = new Segmentocultural();
            $this->view->segmentoCultural = $objSegmentocultural->findBy(array(
                'Codigo' => $projeto['Segmento']
            ));

            $objEnquadramento = new Admissibilidade_Model_Enquadramento();
            $arrayPesquisa = array(
                'AnoProjeto' => $projeto['AnoProjeto'],
                'Sequencial' => $projeto['Sequencial'],
                'IdPRONAC' => $projeto['IdPRONAC']
            );
            $this->view->dadosEnquadramento = $objEnquadramento->findBy($arrayPesquisa);

            $this->view->titulo = "Devolver";
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/readequacao-assinatura/devolver-projeto?IdPRONAC={$get->IdPRONAC}");
        }
    }

    public function finalizarAssinaturaAction()
    {
        try {
            $this->validarPerfis();
            $get = Zend_Registry::get('get');
            if (!filter_input(INPUT_GET, 'IdPRONAC')) {
                throw new Exception("Identificador do projeto é necessário para acessar essa funcionalidade.");
            }
            $idPronac = $get->IdPRONAC;

            if (!filter_input(INPUT_POST, 'idTipoDoAtoAdministrativo')) {
                throw new Exception("Identificador do Tipo do Ato Administrativo n&atilde;o informado");
            }
            $post = $this->getRequest()->getPost();
            $idTipoDoAtoAdministrativo = $post['idTipoDoAtoAdministrativo'];

            $servicoDocumentoAssinatura = new \MinC\Assinatura\Servico\Assinatura(
                $idTipoDoAtoAdministrativo
            );
            $servicoDocumentoAssinatura->finalizarFluxo();

            parent::message('Projeto finalizado com sucesso!', "/{$this->moduleName}/readequacao-assinatura/gerenciar-assinaturas", 'CONFIRM');
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/readequacao-assinatura/finalizar-assinatura?IdPRONAC={$idPronac}");
        }
    }
}
