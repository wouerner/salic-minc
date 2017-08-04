<?php

class Parecer_AnaliseInicialController extends MinC_Controller_Action_Abstract implements MinC_Assinatura_Controller_IDocumentoAssinaturaController
{
    private $idPronac;

    private function validarPerfis() {
        $auth = Zend_Auth::getInstance();

        $PermissoesGrupo = array();
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::PARECERISTA;
        
        isset($auth->getIdentity()->usu_codigo) ? parent::perfil(1, $PermissoesGrupo) : parent::perfil(4, $PermissoesGrupo);
    }

    public function init()
    {
        parent::perfil();
        parent::init();
        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
    }

    public function gerenciarAssinaturasAction()
    {
        $this->redirect("/{$this->moduleName}/index");
    }

    public function encaminharAssinaturaAction()
    {
        try {
            $get = $this->getRequest()->getParams();
            $post = $this->getRequest()->getPost();
            $servicoDocumentoAssinatura = $this->obterServicoDocumentoAssinatura();
            
            if (isset($get['IdPRONAC']) && !empty($get['IdPRONAC']) && $get['encaminhar'] == 'true') {
                $servicoDocumentoAssinatura->idPronac = $get['IdPRONAC'];
                $servicoDocumentoAssinatura->encaminharProjetoParaAssinatura();
                
                $idTipoDoAtoAdministrativo = Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_ANALISE_INICIAL;
                $idDocumentoAssinatura = $this->getIdDocumentoAssinatura($get['IdPRONAC'], $idTipoDoAtoAdministrativo);
                
                $this->redirect("/assinatura/index/visualizar-projeto/?idDocumentoAssinatura=" . $idDocumentoAssinatura . "&origin=" . $get['origin']);
            } elseif(isset($post['IdPRONAC']) && is_array($post['IdPRONAC']) && count($post['IdPRONAC']) > 0) {
                // ainda nao implementado o encaminhamento de vários para pareceres
            }
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/{$this->moduleName}/analise-inicial/index");
        }   
        
    }

    function obterServicoDocumentoAssinatura()
    {
        if(!isset($this->servicoDocumentoAssinatura)) {
            require_once __DIR__ . DIRECTORY_SEPARATOR . "AnaliseInicialDocumentoAssinaturaController.php";
            $this->servicoDocumentoAssinatura = new Parecer_AnaliseInicialDocumentoAssinaturaController($this->getRequest()->getPost());
        }
        return $this->servicoDocumentoAssinatura;        
    }

    private function getIdDocumentoAssinatura($idPronac, $idTipoDoAtoAdministrativo)
    {
        $objDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
        
        $where = array();
        $where['IdPRONAC = ?'] = $idPronac;
        $where['idTipoDoAtoAdministrativo = ?'] = $idTipoDoAtoAdministrativo;
        $where['stEstado = ?'] = 1;
        
        $result = $objDocumentoAssinatura->buscar($where);
        
        return $result[0]['idDocumentoAssinatura'];
    }
    
    public function indexAction()
    {
        $this->validarPerfis();
        
        $auth = Zend_Auth::getInstance();
        $idusuario = $auth->getIdentity()->usu_codigo;

        $GrupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
        $idOrgao = $GrupoAtivo->codOrgao; //  ¿rg¿o ativo na sess¿o

        $UsuarioDAO = new Autenticacao_Model_Usuario();
        $agente = $UsuarioDAO->getIdUsuario($idusuario);
        $idAgenteParecerista = $agente['idagente'];

        $situacao = $this->_request->getParam('situacao');
        
        $projeto = new Projetos();
        $resp = $projeto->buscaProjetosProdutosParaAnalise(
            array(
                'distribuirParecer.idAgenteParecerista = ?' => $idAgenteParecerista,
                'distribuirParecer.idOrgao = ?' => $idOrgao,
            )
        );

        $this->idTipoDoAtoAdministrativo = Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_ANALISE_INICIAL;
        $objTbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
        $this->view->quantidadeMinimaAssinaturas = $objTbAtoAdministrativo->obterQuantidadeMinimaAssinaturas(
            $this->idTipoDoAtoAdministrativo,
            $this->auth->getIdentity()->usu_org_max_superior
        );
        $this->view->idTipoDoAtoAdministrativo = $this->idTipoDoAtoAdministrativo;
        $this->view->idPerfilDoAssinante = $GrupoAtivo->codGrupo;
        
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginacao/paginacao.phtml');
        $paginator = Zend_Paginator::factory($resp); // dados a serem paginados
        $currentPage = $this->_getParam('page', 1);
        $paginator->setCurrentPageNumber($currentPage)->setItemCountPerPage(10); // 10 por p¿gina
        
        $this->view->qtdRegistro = count($resp);
        $this->view->situacao = $situacao;
        $this->view->buscar = $paginator;
    }

}