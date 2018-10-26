<?php

class Admissibilidade_EnquadramentoController extends MinC_Controller_Action_Abstract
{
    private $idPronac;

    public function init()
    {
        parent::perfil();
        parent::init();
        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
    }

    public function indexAction()
    {
        $this->redirect("/admissibilidade/enquadramento/gerenciar-enquadramento");
    }

    public function gerenciarEnquadramentoAction()
    {
        // LEMBRAR :
        // $this->grupoAtivo->codOrgao  => Orgão logado   ==== Projetos.Orgao

        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $enquadramento = new Admissibilidade_Model_Enquadramento();

        $this->view->dados = array();
        $ordenacao = array("projetos.DtSituacao asc");

        if ($this->grupoAtivo->codGrupo == Autenticacao_Model_Grupos::COORDENADOR_ADMISSIBILIDADE) {
            $this->view->dados = $enquadramento->obterProjetosParaEnquadramento(
                $this->grupoAtivo->codOrgao,
                $ordenacao
            );
        } elseif ($this->grupoAtivo->codGrupo == Autenticacao_Model_Grupos::TECNICO_ADMISSIBILIDADE) {
            $this->view->dados = $enquadramento->obterProjetosParaEnquadramentoVinculados(
                $this->view->idUsuarioLogado,
                $this->grupoAtivo->codOrgao,
                $ordenacao
            );
        }

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }


    public function enquadrarprojetoAction()
    {
        try {
            $get = $this->getRequest()->getParams();
            if (!isset($get['IdPRONAC']) || empty($get['IdPRONAC'])) {
                throw new Exception("N&uacute;mero de PRONAC n&atilde;o informado.");
            }
            $this->view->IdPRONAC = $get['IdPRONAC'];


//            $arraySituacoesValidas = array("B01", "B03");
//            if (!in_array($projeto['Situacao'], $arraySituacoesValidas)) {
//                throw new Exception("Situa&ccedil;&atilde;o do projeto n&atilde;o &eacute; v&aacute;lida.");
//            }

            $objProjeto = new Projetos();
            $projeto = $objProjeto->findBy(array('IdPRONAC' => $get['IdPRONAC']));

            if (!$projeto) {
                throw new Exception("PRONAC n&atilde;ao encontrado.");
            }

            $post = $this->getRequest()->getPost();

            if (!$post['areaCultural'] || !$post['segmentoCultural'] || !$post['enquadramento_projeto'] || !$post['observacao']) {
                $this->carregardadosEnquadramentoProjeto($projeto);
            } else {
                $this->salvarEnquadramentoProjeto($projeto);
            }
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), '/admissibilidade/enquadramento/gerenciar-enquadramento');
        }
    }

    private function salvarEnquadramentoProjeto($projeto)
    {
        try {

            $auth = Zend_Auth::getInstance();
            $post = $this->getRequest()->getPost();
            $observacao = trim($post['observacao']);
            if (empty($observacao)) {
                throw new Exception("O campo 'Justificativa' é de preenchimento obrigatório.");
            }

            $get = $this->getRequest()->getParams();
            $authIdentity = array_change_key_case((array)$auth->getIdentity());
            $objEnquadramento = new Admissibilidade_Model_Enquadramento();

            $arrayArmazenamentoEnquadramento = [
                'AnoProjeto' => $projeto['AnoProjeto'],
                'Sequencial' => $projeto['Sequencial'],
                'Enquadramento' => $post['enquadramento_projeto'],
                'DtEnquadramento' => $objEnquadramento->getExpressionDate(),
                'Observacao' => $observacao,
                'Logon' => $authIdentity['usu_codigo'],
                'IdPRONAC' => $projeto['IdPRONAC']
            ];

            $objEnquadramento = new Admissibilidade_Model_Enquadramento();
            $objEnquadramento->salvar($arrayArmazenamentoEnquadramento);

            $projetos = new Projeto_Model_DbTable_Projetos();
            $projetos->atualizarProjetoEnquadrado(
                $projeto,
                $authIdentity['usu_codigo']
            );

            parent::message(
                'Enquadramento cadastrado com sucesso.',
                '/admissibilidade/enquadramento/gerenciar-enquadramento',
                'CONFIRM'
            );
        } catch (Exception $objException) {
            parent::message(
                $objException->getMessage(),
                "/admissibilidade/enquadramento/enquadrarprojeto?IdPRONAC={$projeto['IdPRONAC']}"
            );
        }
    }

    private function carregardadosEnquadramentoProjeto($projeto)
    {


        $mapperArea = new Agente_Model_AreaMapper();
        $this->view->comboareasculturais = $mapperArea->fetchPairs('Codigo', 'Descricao');
        $this->view->projeto = $projeto;

        if (count($this->view->comboareasculturais) < 1) {
            throw new Exception("N&atilde;o foram encontradas &Aacute;reas Culturais para o PRONAC informado.");
        }
        $objSegmentocultural = new Segmentocultural();
        $this->view->combosegmentosculturais = $objSegmentocultural->buscarSegmento($projeto['Area']);

        if (count($this->view->combosegmentosculturais) < 1) {
            throw new Exception("N&atilde;o foram encontradas Segmentos Culturais para o PRONAC informado.");
        }

        $objEnquadramento = new Admissibilidade_Model_Enquadramento();
        $arrayPesquisa = array(
            'AnoProjeto' => $projeto['AnoProjeto'],
            'Sequencial' => $projeto['Sequencial'],
            'IdPRONAC' => $projeto['IdPRONAC']
        );
        $arrayEnquadramento = $objEnquadramento->findBy($arrayPesquisa);

        $this->view->observacao = $arrayEnquadramento['Observacao'];
        if ($projeto['Situacao'] == 'B03') {
            $objRecurso = new tbRecurso();
            $this->view->avaliacaoRecurso = trim($objRecurso->buscarAvaliacaoRecurso($projeto['IdPRONAC']));
        }
        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }

    public function encaminharAssinaturaAction()
    {
        try {
            $this->encaminharProjetosParaAssinatura();
            $this->carregarListaEncaminhamentoAssinatura();
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), '/admissibilidade/enquadramento/encaminhar-assinatura');
        }
    }

    private function encaminharProjetosParaAssinatura()
    {
        $get = $this->getRequest()->getParams();
        $post = $this->getRequest()->getPost();



        if (isset($get['IdPRONAC']) && !empty($get['IdPRONAC']) && $get['encaminhar'] == 'true') {
            $servicoDocumentoAssinatura = new \Application\Modules\Admissibilidade\Service\Assinatura\DocumentoAssinatura(
                $get['IdPRONAC'],
                Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_ENQUADRAMENTO
            );
            $servicoDocumentoAssinatura->iniciarFluxo();
            parent::message(
                'Projeto encaminhado com sucesso.',
                '/admissibilidade/enquadramento/encaminhar-assinatura',
                'CONFIRM'
            );
        } elseif (isset($post['IdPRONAC']) && is_array($post['IdPRONAC']) && count($post['IdPRONAC']) > 0) {
            foreach ($post['IdPRONAC'] as $idPronac) {
                $servicoDocumentoAssinatura = new \Application\Modules\Admissibilidade\Service\Assinatura\DocumentoAssinatura(
                    $idPronac,
                    Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_ENQUADRAMENTO
                );
                $servicoDocumentoAssinatura->iniciarFluxo();
            }
            parent::message(
                'Projetos encaminhados com sucesso.',
                '/admissibilidade/enquadramento/encaminhar-assinatura',
                'CONFIRM'
            );
        }
    }

    private function carregarListaEncaminhamentoAssinatura()
    {
        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $enquadramento = new Admissibilidade_Model_Enquadramento();

        $this->view->dados = array();
        $ordenacao = array("dias desc");
        $situacoes = ['B02', 'B03'];
        $dados = $enquadramento->obterProjetosEnquadradosParaAssinatura($this->grupoAtivo->codOrgao, $situacoes, $ordenacao);

        foreach ($dados as $dado) {
            $dado->desistenciaRecursal = $enquadramento->verificarDesistenciaRecursal($dado->IdPRONAC);
            $this->view->dados[] = $dado;
        }

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
        $this->view->codOrgao = $this->grupoAtivo->codOrgao;
    }

    public function visualizarDevolucaoAssinaturaAction()
    {
        try {
            $get = $this->getRequest()->getParams();

            if (!$get['IdPRONAC']) {
                throw new Exception("Identificador do projeto n&atilde;o informado.");
            }

            $objDespacho = new Proposta_Model_DbTable_TbDespacho();
            $despacho = $objDespacho->consultarDespachoAtivo($get['IdPRONAC']);

            $this->_helper->json(
                array(
                    'status' => 1,
                    'despacho' => utf8_encode($despacho['Despacho']),
                    'data' => Data::tratarDataZend($despacho['Data'], 'brasileiro', true)
                )
            );
        } catch (Exception $objException) {
            $this->_helper->json(array('status' => 0, 'msg' => $objException->getMessage()));
        }
    }
}
