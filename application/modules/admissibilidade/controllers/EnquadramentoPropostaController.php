<?php

class Admissibilidade_EnquadramentoPropostaController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        parent::perfil();
        parent::init();
        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
    }

    public function indexAction()
    {
        $this->redirect("/admissibilidade/enquadramento-proposta/gerenciar-enquadramento");
    }

    public function sugerirEnquadramentoAction()
    {
        try {
            $get = $this->getRequest()->getParams();
            if (!isset($get['id_preprojeto']) || empty($get['id_preprojeto'])) {
                throw new Exception("Identificador da proposta não informado.");
            }
            $this->view->id_preprojeto = $get['id_preprojeto'];

            $preProjetoDbTable = new Proposta_Model_DbTable_PreProjeto();
            $preprojeto = $preProjetoDbTable->findBy(array('idPreProjeto' => $this->view->id_preprojeto));

            if (!$preprojeto) {
                throw new Exception("Proposta não encontrada.");
            }

            $post = $this->getRequest()->getPost();
            if (!$post) {
                $this->carregardadosEnquadramentoProposta($preprojeto);
            } else {
                $this->salvarSugestaoEnquadramento($preprojeto);
            }
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), '/admissibilidade/enquadramento/gerenciar-enquadramento');
        }
    }

    private function salvarSugestaoEnquadramento($projeto)
    {
        try {
xd(123);
            $auth = Zend_Auth::getInstance();
            $post = $this->getRequest()->getPost();
            $observacao = trim($post['observacao']);
            if (empty($observacao)) {
                throw new Exception("O campo 'Justificativa' é de preenchimento obrigatório.");
            }

            $get = $this->getRequest()->getParams();
            $authIdentity = array_change_key_case((array)$auth->getIdentity());
            $objEnquadramento = new Admissibilidade_Model_Enquadramento();
            $arrayDadosEnquadramento = $objEnquadramento->findBy(array('IdPRONAC = ?'=>$projeto['IdPRONAC']));
            $arrayArmazenamentoEnquadramento = array(
                'AnoProjeto' => $projeto['AnoProjeto'],
                'Sequencial' => $projeto['Sequencial'],
                'Enquadramento' => $post['enquadramento_projeto'],
                'DtEnquadramento' => $objEnquadramento->getExpressionDate(),
                'Observacao' => $post['observacao'],
                'Logon' => $authIdentity['usu_codigo'],
                'IdPRONAC' => $get['IdPRONAC']
            );

            $objEnquadramento = new Admissibilidade_Model_Enquadramento();
            if (!$arrayDadosEnquadramento) {
                $objEnquadramento->inserir($arrayArmazenamentoEnquadramento);
            } else {
                $objEnquadramento->update($arrayArmazenamentoEnquadramento, array(
                    'IdEnquadramento = ?' => $arrayDadosEnquadramento['IdEnquadramento']
                ));
            }

            $situacaoFinalProjeto = 'B02';
            $orgaoDestino = null;
            $providenciaTomada = 'Projeto enquadrado ap&oacute;s avalia&ccedil;&atilde;o t&eacute;cnica.';
            if ($projeto['Situacao'] == 'B03') {
                $situacaoFinalProjeto = Projeto_Model_Situacao::PROJETO_ENQUADRADO_COM_RECURSO;
                $objOrgaos = new Orgaos();
                $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($projeto['Orgao']);
                $orgaoDestino = Orgaos::ORGAO_SAV_DAP;
                if ($dadosOrgaoSuperior['Codigo'] == Orgaos::ORGAO_SUPERIOR_SEFIC) {
                    $orgaoDestino = Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
                }
                $providenciaTomada = 'Projeto enquadrado ap&oacute;s avalia&ccedil;&atilde;o t&eacute;cnica do recurso.';
            }

            $objPlanoDistribuicaoProduto = new PlanoDistribuicao();
            $objPlanoDistribuicaoProduto->atualizarAreaESegmento($post['areaCultural'], $post['segmentoCultural'], $projeto['idProjeto']);

            $objProjeto = new Projetos();
            $arrayDadosProjeto = array(
                'Situacao' => $situacaoFinalProjeto,
                'DtSituacao' => $objProjeto->getExpressionDate(),
                'ProvidenciaTomada' => $providenciaTomada,
                'Area' => $post['areaCultural'],
                'Segmento' => $post['segmentoCultural'],
                'logon' => $authIdentity['usu_codigo']
            );

            if ($orgaoDestino) {
                $arrayDadosProjeto['Orgao'] = $orgaoDestino;
            }

            $arrayWhere = array('IdPRONAC  = ?' => $projeto['IdPRONAC']);
            $objProjeto->update($arrayDadosProjeto, $arrayWhere);

            if ($projeto['Situacao'] == 'B03') {
                $tbRecurso = new tbRecurso();
                $tbRecurso->finalizarRecurso($projeto['IdPRONAC']);
            }

            $objVerificacao = new Verificacao();
            $verificacao = $objVerificacao->findBy(array(
                'idVerificacao = ?' => 620
            ));

            $tbTextoEmailDAO = new tbTextoEmail();
            $textoEmail = $tbTextoEmailDAO->findBy(array(
                'idTextoEmail = ?' => 23
            ));

            $objInternet = new Agente_Model_DbTable_Internet();
            $arrayEmails = $objInternet->obterEmailProponentesPorPreProjeto($projeto['idProjeto']);
            foreach ($arrayEmails as $email) {
                EmailDAO::enviarEmail($email->Descricao, $verificacao['Descricao'], $textoEmail['dsTexto']);
            }

            parent::message('Enquadramento cadastrado com sucesso.', '/admissibilidade/enquadramento/gerenciar-enquadramento', 'CONFIRM');
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/admissibilidade/enquadramento/enquadrarprojeto?IdPRONAC={$projeto['IdPRONAC']}");
        }
    }

    private function carregardadosEnquadramentoProposta(array $preprojeto)
    {
        $mapperArea = new Agente_Model_AreaMapper();
        $this->view->comboareasculturais = $mapperArea->fetchPairs('Codigo', 'Descricao');
        $this->view->preprojeto = $preprojeto;

        if (count($this->view->comboareasculturais) < 1) {
            throw new Exception("N&atilde;o foram encontradas &Aacute;reas Culturais para o PRONAC informado.");
        }
//        $objSegmentocultural = new Segmentocultural();
//        $this->view->combosegmentosculturais = $objSegmentocultural->buscarSegmento($preprojeto['Area']);

//        if (count($this->view->combosegmentosculturais) < 1) {
//            throw new Exception("N&atilde;o foram encontradas Segmentos Culturais para o PRONAC informado.");
//        }
        $sugestaoEnquadramentoModel = new Admissibilidade_Model_DbTable_SugestaoEnquadramento();
        $this->view->historicoEnquadramento = $sugestaoEnquadramentoModel->obterHistoricoEnquadramento($preprojeto['idPreProjeto']);
        $this->view->id_perfil_usuario = $this->grupoAtivo->codGrupo;
        $this->view->id_orgao = $this->grupoAtivo->codOrgao;
        $this->view->id_usuario_avaliador = $this->auth->getIdentity()->usu_codigo;
    }


}
