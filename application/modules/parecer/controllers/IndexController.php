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
                
                $idTipoDoAtoAdministrativo = Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_ANALISE_INICIAL;
                $this->redirect("/assinatura/index/visualizar-projeto/?IdPRONAC=" . $get['IdPRONAC'] . "&idTipoDoAtoAdministrativo=" . $idTipoDoAtoAdministrativo);
            } elseif(isset($post['IdPRONAC']) && is_array($post['IdPRONAC']) && count($post['IdPRONAC']) > 0) {
                // ainda nao implementado o encaminhamento de vários para pareceres
                /*
                foreach($post['IdPRONAC'] as $idPronac) {
                    $servicoDocumentoAssinatura->idPronac = $idPronac;
                    $servicoDocumentoAssinatura->encaminharProjetoParaAssinatura();
                }
                
                parent::message('Projetos encaminhados com sucesso.', '/default/analisarprojetoparecer/index', 'CONFIRM');
                */
            }
            $this->carregarListaEncaminhamentoAssinatura();
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), '/{$this->moduleName}/index/encaminhar-assinatura');
        }
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
