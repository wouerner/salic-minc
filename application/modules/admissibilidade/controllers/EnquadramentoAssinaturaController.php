<?php

class Admissibilidade_EnquadramentoAssinaturaController extends Assinatura_GenericController
{
    private $idTipoDoAtoAdministrativo;

    private function validarPerfis()
    {
        $auth = Zend_Auth::getInstance();

        $PermissoesGrupo = array();
        $PermissoesGrupo[] = 147;
        $PermissoesGrupo[] = 148;
        $PermissoesGrupo[] = 149;
        $PermissoesGrupo[] = 150;
        $PermissoesGrupo[] = 151;
        $PermissoesGrupo[] = 152;

        isset($auth->getIdentity()->usu_codigo) ? parent::perfil(1, $PermissoesGrupo) : parent::perfil(4, $PermissoesGrupo);
    }

    public function init()
    {
        parent::init();

        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
        $this->idTipoDoAtoAdministrativo = Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_ENQUADRAMENTO;
    }

    public function indexAction()
    {
        $this->validarPerfis();
        $this->redirect("/{$this->moduleName}/enquadramento-assinatura/gerenciar-projetos");
    }

    public function gerenciarProjetosAction()
    {
        $this->validarPerfis();
        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $documentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();

        $this->view->dados = $documentoAssinatura->obterProjetosComAssinaturasAbertas(
            $this->grupoAtivo->codOrgao,
            $this->grupoAtivo->codGrupo
        );
        $this->view->codGrupo = $this->grupoAtivo->codGrupo;

        $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
        $this->view->quantidade_minima_assinaturas = $objTbAtoAdministrativo->obterQuantidadeMinimaAssinaturas($this->idTipoDoAtoAdministrativo);
        $this->view->idTipoDoAtoAdministrativo = $this->idTipoDoAtoAdministrativo;
    }

    public function devolverProjetoAction()
    {
        $this->validarPerfis();
        $get = Zend_Registry::get('get');
        try {

            if (!filter_input(INPUT_GET, 'IdPRONAC')) {
                throw new Exception ("Identificador do projeto é necessário para acessar essa funcionalidade.");
            }

            $objTbProjetos = new Projeto_Model_DbTable_Projetos();

            $this->view->projeto = $objTbProjetos->findBy(array(
                'IdPRONAC' => $get->IdPRONAC
            ));

            $post = $this->getRequest()->getPost();
            if ($post) {

                if (!$post['motivoDevolucao']) {
                    throw new Exception("Campo 'Motivação da Devolução para nova avaliação' não informado.");
                }
                $objTbDepacho = new Proposta_Model_DbTable_TbDespacho();
                $objTbDepacho->devolverProjetoEncaminhadoParaAssinatura($get->IdPRONAC, $post['motivoDevolucao']);


                $objOrgaos = new Orgaos();
                $orgaoSuperior = $objOrgaos->obterOrgaoSuperior($this->view->projeto['Orgao']);

                $orgaoDestino = 171;
                if ($orgaoSuperior['Codigo'] == Orgaos::ORGAO_SUPERIOR_SEFIC) {
                    $orgaoDestino = 262;
                }

                $objTbProjetos->alterarOrgao($orgaoDestino, $get->IdPRONAC);
                $objProjetos = new Projetos();
                $objProjetos->alterarSituacao(
                    $get->IdPRONAC,
                    null,
                    Projeto_Model_Situacao::PROJETO_DEVOLVIDO_PARA_ENQUADRAMENTO,
                    'Projeto encaminhado para nova avalia&ccedil;&atilde;o do enquadramento'
                );

                $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
                $data = array(
                    'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_FECHADO_PARA_ASSINATURA,
                    'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_INATIVO
                );
                $where = array(
                    'IdPRONAC = ?' => $get->IdPRONAC,
                    'idTipoDoAtoAdministrativo = ?' => $this->idTipoDoAtoAdministrativo,
                    'cdSituacao = ?' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                    'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
                );
                $objModelDocumentoAssinatura->update($data, $where);

                parent::message('Projeto devolvido com sucesso.', "/{$this->moduleName}/enquadramento-assinatura/gerenciar-projetos", 'CONFIRM');
            }

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $this->view->abertoParaDevolucao = $objModelDocumentoAssinatura->isProjetoDisponivelParaAssinatura(
                $get->IdPRONAC,
                $this->idTipoDoAtoAdministrativo
            );

            $this->view->IdPRONAC = $get->IdPRONAC;

            $mapperArea = new Agente_Model_AreaMapper();
            $this->view->areaCultural = $mapperArea->findBy(array(
                'Codigo' => $this->view->projeto['Area']
            ));

            $objSegmentocultural = new Segmentocultural();
            $this->view->segmentoCultural = $objSegmentocultural->findBy(array(
                'Codigo' => $this->view->projeto['Segmento']
            ));

            $objEnquadramento = new Admissibilidade_Model_Enquadramento();
            $arrayPesquisa = array(
                'AnoProjeto' => $this->view->projeto['AnoProjeto'],
                'Sequencial' => $this->view->projeto['Sequencial'],
                'IdPRONAC' => $this->view->projeto['IdPRONAC']
            );
            $this->view->dadosEnquadramento = $objEnquadramento->findBy($arrayPesquisa);

            $this->view->titulo = "Devolver";
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/enquadramento-assinatura/devolver-projeto?IdPRONAC={$get->IdPRONAC}");
        }
    }

    public function assinarProjetoAction()
    {
        $this->validarPerfis();
        $get = Zend_Registry::get('get');

        try {

            $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
            $this->view->perfilAssinante = $objTbAtoAdministrativo->obterPerfilAssinante(
                $this->grupoAtivo->codOrgao,
                $this->grupoAtivo->codGrupo,
                $this->idTipoDoAtoAdministrativo
            );

            if (!$this->view->perfilAssinante) {
                throw new Exception ("Usu&aacute;rio sem autoriza&ccedil;&atilde;o para assinar o documento.");
            }

            if (is_array($get->IdPRONAC)) {
                $idPronacUnidos = implode(',', $get->IdPRONAC);
                $this->redirect("/{$this->moduleName}/enquadramento-assinatura/assinar-projeto?IdPRONAC={$idPronacUnidos}");
            }

            $this->view->IdPRONAC = $get->IdPRONAC;
            $arrayIdPronacs = explode(',', $get->IdPRONAC);
            if (count($arrayIdPronacs) < 1) {
                throw new Exception ("Identificador do projeto &eacute; necess&aacute;rio para acessar essa funcionalidade.");
            }

            $post = $this->getRequest()->getPost();

            if ($post) {

                foreach ($arrayIdPronacs as $idPronac) {
                    $this->assinarProjeto(
                        $idPronac,
                        $post['password'],
                        $post['dsManifestacao']
                    );
                }

                if (count($arrayIdPronacs) > 1) {
                    parent::message(
                        "Projetos assinados com sucesso!",
                        "/{$this->moduleName}/enquadramento-assinatura/gerenciar-projetos",
                        'CONFIRM'
                    );
                }
                parent::message(
                    "Projeto assinado com sucesso!",
                    "/{$this->moduleName}/enquadramento-assinatura/visualizar-projeto?IdPRONAC={$idPronac}",
                    'CONFIRM'
                );
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
                'idVerificacao = ?' => $this->idTipoDoAtoAdministrativo
            ));

        } catch (Exception $objException) {
            if (is_array($get->IdPRONAC)) {
                parent::message(
                    $objException->getMessage(),
                    "/{$this->moduleName}/enquadramento-assinatura/gerenciar-projetos"
                );
            }
            parent::message(
                $objException->getMessage(),
                "/{$this->moduleName}/enquadramento-assinatura/assinar-projeto?IdPRONAC={$get->IdPRONAC}"
            );
        }
    }

    public function finalizarAssinaturaAction()
    {
        $this->validarPerfis();
        $get = Zend_Registry::get('get');
        try {
            if (!filter_input(INPUT_GET, 'IdPRONAC')) {
                throw new Exception ("Identificador do projeto é necessário para acessar essa funcionalidade.");
            }

            $objProjetos = new Projetos();
            $objProjetos->alterarSituacao(
                $get->IdPRONAC,
                null,
                Projeto_Model_Situacao::PROJETO_APROVADO_AGUARDANDO_ANALISE_DOCUMENTAL,
                'Projeto aprovado - aguardando an&aacute;lise documental'
            );

            $objTbProjetos = new Projeto_Model_DbTable_Projetos();
            $dadosProjeto = $objTbProjetos->findBy(array(
                'IdPRONAC' => $get->IdPRONAC
            ));

            $orgaoDestino = Orgaos::ORGAO_SAV_DAP;
            $objOrgaos = new Orgaos();
            $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($dadosProjeto['Orgao']);

            if ($dadosOrgaoSuperior['Codigo'] == Orgaos::ORGAO_SUPERIOR_SEFIC) {
                $orgaoDestino = Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
            }
            $objTbProjetos->alterarOrgao($orgaoDestino, $get->IdPRONAC);

            $enquadramento = new Admissibilidade_Model_Enquadramento();
            $dadosEnquadramento = $enquadramento->obterEnquadramentoPorProjeto($get->IdPRONAC, $dadosProjeto['AnoProjeto'], $dadosProjeto['Sequencial']);

            $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
            $data = array(
                'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_FECHADO_PARA_ASSINATURA
            );
            $where = array(
                'IdPRONAC = ?' => $get->IdPRONAC,
                'idTipoDoAtoAdministrativo = ?' => $this->idTipoDoAtoAdministrativo,
                'idAtoDeGestao = ?' => $dadosEnquadramento['IdEnquadramento'],
                'cdSituacao = ?' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                'stEstado = ?' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
            );
            $objModelDocumentoAssinatura->update($data, $where);

            $auth = Zend_Auth::getInstance();

            $valoresProjeto = $objTbProjetos->obterValoresProjeto($get->IdPRONAC);

            $dadosInclusaoAprovacao = array(
                'IdPRONAC' => $get->IdPRONAC,
                'AnoProjeto' => $dadosProjeto['AnoProjeto'],
                'Sequencial' => $dadosProjeto['Sequencial'],
                'TipoAprovacao' => 1,
                'dtAprovacao' => $objTbProjetos->getExpressionDate(),
                'ResumoAprovacao' => $dadosEnquadramento['Observacao'],
                'AprovadoReal' => $valoresProjeto['ValorProposta'],
                'Logon' => $auth->getIdentity()->usu_codigo,
            );
            $objAprovacao = new Aprovacao();
            $idAprovacao = $objAprovacao->inserir($dadosInclusaoAprovacao);

            $idTecnico = new Zend_Db_Expr("sac.dbo.fnPegarTecnico(110, {$orgaoDestino}, 3)");

            $tblVerificaProjeto = new tbVerificaProjeto();
            $dadosVP['idPronac'] = $get->IdPRONAC;
            $dadosVP['idOrgao'] = $orgaoDestino;
            $dadosVP['idAprovacao'] = $idAprovacao;
            $dadosVP['idUsuario'] = $idTecnico;
            $dadosVP['stAnaliseProjeto'] = 1;
            $dadosVP['dtRecebido'] = $tblVerificaProjeto->getExpressionDate();
            $dadosVP['stAtivo'] = 1;
            $tblVerificaProjeto->inserir($dadosVP);

            parent::message('Projeto finalizado com sucesso!', "/{$this->moduleName}/enquadramento-assinatura/gerenciar-projetos", 'CONFIRM');
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/enquadramento-assinatura/assinar-projeto?IdPRONAC={$get->IdPRONAC}");
        }
    }

}