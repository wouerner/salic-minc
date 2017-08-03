<?php

class Assinatura_AtoAdministrativoController extends Assinatura_GenericController
{
    private $grupoAtivo;

    public function init()
    {
        parent::init();

        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
        parent::perfil();

        $this->cod_usuario = $this->auth->getIdentity()->usu_codigo;
    }

    public function indexAction()
    {
        $this->redirect("/{$this->moduleName}/ato-administrativo/gerir-atos-administrativos");
    }

    public function gerirAtosAdministrativosAction()
    {
        $objAtosAdministrativos = new Assinatura_Model_DbTable_TbAtoAdministrativo();
        $this->view->atosAdministrativos = $objAtosAdministrativos->obterAtoAdministrativoDetalhado();
    }

    public function alterarAction()
    {

    }

    public function removerAction()
    {
        throw new Exception("Ato administrativo já vinculado a um documento");
    }

    public function obterTiposDeAtosAdministrativosAjaxAction()
    {

        $objAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
        $arrayTiposAtosAdministrativos = $objAtoAdministrativo->obterTiposDeAtosAdministrativosAtivos();
        foreach($arrayTiposAtosAdministrativos as $indice => $tipoAtoAdministrativo) {
            $arrayTiposAtosAdministrativos[$indice]['descricao'] = utf8_encode($tipoAtoAdministrativo['descricao']);
        }

        $this->_helper->json(
            array('resultado' => $arrayTiposAtosAdministrativos)
        );
    }

    public function obterCargosDoAssinanteAjaxAction()
    {
        $objAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
        $arrayTiposAtosAdministrativos = $objAtoAdministrativo->obterCargosDoAssinante();
        foreach($arrayTiposAtosAdministrativos as $indice => $tipoAtoAdministrativo) {
            $arrayTiposAtosAdministrativos[$indice]['descricao'] = utf8_encode($tipoAtoAdministrativo['descricao']);
        }

        $this->_helper->json(
            array('resultado' => $arrayTiposAtosAdministrativos)
        );
    }

    public function obterOrgaosSuperioresAjaxAction()
    {
        $objAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
        $arrayTiposAtosAdministrativos = $objAtoAdministrativo->obterOrgaosSuperiores();
        foreach($arrayTiposAtosAdministrativos as $indice => $tipoAtoAdministrativo) {
            $arrayTiposAtosAdministrativos[$indice]['descricao'] = utf8_encode($tipoAtoAdministrativo['descricao']);
        }

        $this->_helper->json(
            array('resultado' => $arrayTiposAtosAdministrativos)
        );
    }

    public function obterOrgaosDoAssinanteAjaxAction()
    {
        $arrayTiposAtosAdministrativos = [];
        $get = $this->getRequest()->getParams();
        if($get['idOrgaoSuperiorDoAssinante']) {
xd($get);
            $objAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
            $arrayTiposAtosAdministrativos = $objAtoAdministrativo->obterOrgaos();
            foreach($arrayTiposAtosAdministrativos as $indice => $tipoAtoAdministrativo) {
                $arrayTiposAtosAdministrativos[$indice]['descricao'] = utf8_encode($tipoAtoAdministrativo['descricao']);
            }

        }
        $this->_helper->json(
            array('resultado' => $arrayTiposAtosAdministrativos)
        );
    }

    public function obterPerfisDoAssinanteAjaxAction()
    {
//        $objAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
//        $arrayTiposAtosAdministrativos = $objAtoAdministrativo->obterCargosDoAssinante();
//        foreach($arrayTiposAtosAdministrativos as $indice => $tipoAtoAdministrativo) {
//            $arrayTiposAtosAdministrativos[$indice]['descricao'] = utf8_encode($tipoAtoAdministrativo['descricao']);
//        }
//
//        $this->_helper->json(
//            array('resultado' => $arrayTiposAtosAdministrativos)
//        );
    }

    public function obterOrdemAssinaturaAjaxAction()
    {
//        $objAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
//        $arrayTiposAtosAdministrativos = $objAtoAdministrativo->obterCargosDoAssinante();
//        foreach($arrayTiposAtosAdministrativos as $indice => $tipoAtoAdministrativo) {
//            $arrayTiposAtosAdministrativos[$indice]['descricao'] = utf8_encode($tipoAtoAdministrativo['descricao']);
//        }
//
//        $this->_helper->json(
//            array('resultado' => $arrayTiposAtosAdministrativos)
//        );
    }

}