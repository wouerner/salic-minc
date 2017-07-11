<?php

class Parecer_IndexController extends MinC_Controller_Action_Abstract implements MinC_Assinatura_Controller_IDocumentoAssinaturaController
{
    private $idPronac;
    /**
     * @var MinC_Assinatura_Documento_IDocumentoAssinatura $servicoDocumentoAssinatura
     */
    private $servicoDocumentoAssinatura;

    public function init()
    {
        parent::perfil();
        parent::init();
        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
    }

    /**
     * @return Parecer_DocumentoAssinaturaController
     */
    function obterServicoDocumentoAssinatura()
    {
        if(!isset($this->servicoDocumentoAssinatura)) {
            require_once __DIR__ . DIRECTORY_SEPARATOR . "DocumentoAssinatura.php";
            $this->servicoDocumentoAssinatura = new Parecer_DocumentoAssinaturaController($this->getRequest()->getPost());
        }
        return $this->servicoDocumentoAssinatura;
    }

    public function indexAction()
    {
        $this->redirect("/{$this->moduleName}/index/encaminhar-assinatura");
    }

    public function encaminharAssinaturaAction() {
        $auth = Zend_Auth::getInstance();
        $idusuario = $auth->getIdentity()->usu_codigo;
        $idOrgao = $this->grupoAtivo->codOrgao; //  ¿rg¿o ativo na sess¿o
        $UsuarioDAO = new Autenticacao_Model_Usuario();
        $agente = $UsuarioDAO->getIdUsuario($idusuario);
        $idAgenteParecerista = $agente['idagente'];

        $dados = array();
        $projeto = new Projetos();
        $projetosProdutos = $projeto->buscaProjetosProdutos(
            array(
                'distribuirParecer.idAgenteParecerista = ?' => $idAgenteParecerista,
                'distribuirParecer.idOrgao = ?' => $idOrgao,
            )
        );

        $AnaliseDeConteudo = new Analisedeconteudo();
        foreach ($projetosProdutos as $projetoProduto) {
            $secundariosAnalisados = $this->verificaSecundariosAnalisados($projetoProduto->IdPRONAC);
            $principalConsolidacao = $this->verificaPrimarioConsolidacao($projetoProduto->IdPRONAC);
            $diligenciasProjeto = $this->verificaDiligenciasProjeto($projetoProduto->IdPRONAC);
            $pareceresProjeto = $this->verificaParecer($projetoProduto->IdPRONAC);
            $produtoParecer = $this->verificaProdutoParecer($projetoProduto->IdPRONAC, $projetoProduto->idProduto);
            
            if( ($secundariosAnalisados == 0) &&
                ($projetoProduto->stPrincipal == 1) &&
                ($principalConsolidacao != 0) &&
                ($pareceresProjeto != 0) &&
                ($countAnalizado == 0) &&
                ($diligenciasProjeto == 0)) {                
                $dados[] = $projetoProduto;
            }
        }
        
        $this->view->dados = $dados;
        
        try {
            $get = $this->getRequest()->getParams();
            $post = $this->getRequest()->getPost();
            $servicoDocumentoAssinatura = $this->obterServicoDocumentoAssinatura();
            
            if (isset($get['IdPRONAC']) && !empty($get['IdPRONAC']) && $get['encaminhar'] == 'true') {
                $servicoDocumentoAssinatura->idPronac = $get['IdPRONAC'];
                $servicoDocumentoAssinatura->encaminharProjetoParaAssinatura();
                parent::message('Projeto encaminhado com sucesso.', '/default/analisarprojetoparecer/index', 'CONFIRM');
            } elseif(isset($post['IdPRONAC']) && is_array($post['IdPRONAC']) && count($post['IdPRONAC']) > 0) {
                foreach($post['IdPRONAC'] as $idPronac) {
                    $servicoDocumentoAssinatura->idPronac = $idPronac;
                    $servicoDocumentoAssinatura->encaminharProjetoParaAssinatura();
                }
                parent::message('Projetos encaminhados com sucesso.', '/default/analisarprojetoparecer/index', 'CONFIRM');
            }
            $this->carregarListaEncaminhamentoAssinatura();
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), '/{$this->moduleName}/index/encaminhar-assinatura');
        }
    }

    private function visualizarParecer() {
        $auth = Zend_Auth::getInstance();
        $idUsuario = $auth->getIdentity()->usu_codigo;
        $dtAtual = Date("Y/m/d h:i:s");
        $codOrgao = $this->grupoAtivo->codOrgao;
        
        $idPronac = $this->_request->getParam("idPronac");
        $idProduto = $this->_request->getParam("idProduto");
        $idDistribuirParecer = $this->_request->getParam("idD");
        $stPrincipal = $this->_request->getParam("stPrincipal");
        $this->view->totaldivulgacao = "true";
        
        $projetos = new Projetos();
        $this->view->IN2017 = $projetos->verificarIN2017($idPronac);
        
        if (!$this->view->IN2017) {
            $planilhaProjeto = new PlanilhaProjeto();
            $valorProjeto = $planilhaProjeto->somarPlanilhaProjeto($idPronac, 109);

            $totalDivulgacao = 0;
            
            if ($somaValorProjeto > 0 && $stPrincipal == "1") {
                $analisarprojetoparecerController = new AnalisarprojetoparecerController();
                $this->view->verifica15porcento = $this->validaRegra20Porcento($idPronac);
            }
            $this->view->verifica15porcento = $this->validacao15($idPronac, $stPrincipal, $valorProjeto['soma']);
        }
        
        $projetos = new Projetos();
        $dadosProjetoProduto = $projetos->dadosFechar($idUsuario, $idPronac, $idDistribuirParecer);
        $this->view->dados = $dadosProjetoProduto;
        $this->view->idpronac = $idPronac;
        $dadosProjeto = $projetos->assinarParecer($idPronac);

        $this->view->dadosEnquadramento = $dadosProjeto['enquadramento'];
        $this->view->dadosProdutos = $dadosProjeto['produtos'];
        $this->view->dadosDiligencias = $dadosProjeto['diligencias'];
        if ($this->view->IN2017) {
            $this->view->dadosAlcance = $dadosProjeto['alcance'][0];
        }
        $this->view->dadosParecer = $dadosProjeto['parecer'];        
    }
    
    private function validacao20($idPronac, $stPrincipal, $somaValorProjeto) {
        $totalDivulgacao = 0;
        
        if ($somaValorProjeto > 0 && $stPrincipal == "1") {
            $analisarprojetoparecerController = new AnalisarprojetoparecerController();
            $totalDivulgacao = $analisarprojetoparecerController->validaRegra20Porcento($idPronac);
        }
        
        return $totalDivulgacao;
    }

    public function validaRegra20Porcento($idPronac)
    {
        $planilhaProjeto = new PlanilhaProjeto();
        $valorProjeto = $planilhaProjeto->somarPlanilhaProjeto($idPronac, 109);

        $valorProjetoDivulgacao = $planilhaProjeto->somarPlanilhaProjetoDivulgacao($idPronac, 109, null, null);

        $somaProjetoDivulgacao = $valorProjetoDivulgacao->soma ? $valorProjetoDivulgacao->soma : 0;

        $totalDivulgacao = false;

        if ($somaProjetoDivulgacao != 0) {
            $this->view->totalsugerido = $valorProjeto['soma'] ? $valorProjeto['soma'] : 0;
            $porcentValorProjeto = ($valorProjeto['soma'] * 0.20);
            $totalValorProjetoDivulgacao = $valorProjetoDivulgacao->soma;

            $valorRetirar = $totalValorProjetoDivulgacao - $porcentValorProjeto;
            $this->view->valorRetirar = $valorRetirar;

            if ($totalValorProjetoDivulgacao > $porcentValorProjeto) {
                return false;
            } else {
                return true;
            }

        } else {
            return true;
        }
    }
    

    private function validacao15($stPrincipal, $idPronac, $somaValorProjeto) {
        $verifica15porcento = 0;
        
        if ($stPrincipal == "1") {
            
            $V1 = '';
            $V2 = '';
            $V3 = '';
            $V4 = '';
            $V5 = '';
            $V6 = '';

            $tpPlanilha = 'CO';
            $planilhaProjeto = new PlanilhaProjeto();

            $whereTotalV1['PAP.IdPRONAC = ?'] = $idPronac;
            $whereTotalV1['PAP.FonteRecurso = ?'] = 109;
            $whereTotalV1['PAP.idPlanilhaItem <> ? '] = 206;

            $valorProjeto15 = $planilhaProjeto->somaDadosPlanilha($whereTotalV1);
            $V1 = $valorProjeto15['soma'];

            $whereTotalV2['PAP.IdPRONAC = ?'] = $idPronac;
            $whereTotalV2['PAP.FonteRecurso = ?'] = 109;
            $whereTotalV2['PAP.idEtapa = ? '] = 4;
            $whereTotalV2['PAP.idProduto = ?'] = 0;
            $whereTotalV2['PAP.idPlanilhaItem not in (?)'] = array(5249, 206, 1238);

            $valoracustosadministrativos = $planilhaProjeto->somaDadosPlanilha($whereTotalV2);
            $V2 = $valoracustosadministrativos['soma'];

            if ($V1 > 0 and $valoracustosadministrativos['soma'] < $somaValorProjeto) {
                $quinzecentoprojetoV3 = $V1 * 0.15;
                
                $verificacaonegativo = $valoracustosadministrativos['soma'] - $quinzecentoprojetoV3;
                
                if ($verificacaonegativo < 0) {
                    $verifica15porcento = 0;
                } else {
                    $valorretirar = $V1 - $verificacaonegativo;
                    $quinzecentovalorretirar = $valorretirar * 0.15;
                    $valorretirarplanilha = $valoracustosadministrativos['soma'] - $quinzecentovalorretirar;
                    $verifica15porcento = $valorretirarplanilha;
                }

            } else {
                $verifica15porcento = $valoracustosadministrativos['soma'];
            }
        }
        return $verifica15porcento;
    }

    
    private function verificaSecundariosAnalisados($idPronac)
    {
        $tbDistribuirParecerDAO = new tbDistribuirParecer();
        $dadosWhere["t.stEstado = ?"] = 0;
        $dadosWhere["t.FecharAnalise = ?"] = 0;
        $dadosWhere["t.TipoAnalise = ?"] = 3;
        $dadosWhere["p.Situacao IN ('B11', 'B14')"] = '';
        $dadosWhere["p.IdPRONAC = ?"] = $idPronac;
        $dadosWhere["t.stPrincipal = ?"] = 0;
        $dadosWhere["t.DtDevolucao is null"] = '';
        
        $SecundariosAtivos = $tbDistribuirParecerDAO->dadosParaDistribuir($dadosWhere);
        return count($SecundariosAtivos);
    }

    private function verificaPrimarioConsolidacao($idPronac)
    {
        $enquadramentoDAO = new Admissibilidade_Model_Enquadramento();
        $buscaEnquadramento = $enquadramentoDAO->buscarDados($idPronac, null, false);
        
        return count($buscaEnquadramento);
    }

    private function verificaParecer($idPronac)
    {
        $parecerDAO	= new Parecer();
        $buscaParecer = $parecerDAO->buscarParecer(null, $idPronac);
        
        return count($buscaParecer);
    }

    private function verificaDiligenciasProjeto($idPronac)
    {
        $tbDiligencia = new tbDiligencia();
        $rsDilig = $tbDiligencia->buscarDados($idPronac);
        
        return count($rsDilig);
    }

    private function verificaProdutoParecer($idPronac, $idProduto)
    {
        $tbAnaliseDeConteudoDAO = new Analisedeconteudo();
        $where['IdPRONAC = ?'] = $idPronac;
        $where['idProduto = ?'] = $idProduto;
        $where['ParecerDeConteudo = ?'] = '';
        $naoAnalisados = $tbAnaliseDeConteudoDAO->dadosAnaliseconteudo(null,$where);
        
        return count($naoAnalisados);
    }
    
    private function carregarListaEncaminhamentoAssinatura() {
        /**
        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $enquadramento = new Admissibilidade_Model_Enquadramento();

        $this->view->dados = array();
        $ordenacao = array("dias desc");
        $dados = $enquadramento->obterProjetosEnquadradosParaAssinatura($this->grupoAtivo->codOrgao, $ordenacao);

        foreach ($dados as $dado) {
            $dado->desistenciaRecursal = $enquadramento->verificarDesistenciaRecursal($dado->IdPRONAC);
            $this->view->dados[] = $dado;
        }

        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
        $this->view->codOrgao = $this->grupoAtivo->codOrgao;
        */
    }
}
