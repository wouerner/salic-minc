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
    }

    function obterServicoDocumentoAssinatura()
    {
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