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

    public function gerenciarAssinaturasAction()
    {
        $this->redirect("/{$this->moduleName}/index/encaminhar-assinatura");
    }


    public function encaminharAssinaturaAction() {
    }

}
