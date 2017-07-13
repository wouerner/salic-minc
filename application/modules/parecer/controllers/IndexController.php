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

    public function assinarParecerAction() {
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

    public function visualizarParecerAction() {
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
