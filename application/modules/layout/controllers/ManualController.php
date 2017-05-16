<?php

class Layout_ManualController extends MinC_Controller_Action_Abstract
{
	public function init()
	{
		// configurações do layout padrão
//		Zend_Layout::startMvc(array('layout' => 'layout_login'));

		parent::init(); // chama o init() do pai GenericControllerNew
        $this->view->bodyClass = 'large-menu';
	}

	/**
	 * Página inicial
	 * @access public
	 * @param void
	 * @return void
	 */
	public function indexAction()
	{
	} // fecha método indexAction()



	/**
	 * Página Simples
	 * @access public
	 * @param void
	 * @return void
	 */
	public function paginaSimplesAction()
	{
        $this->view->bodyClass = '';
	} // fecha método paginaSimplesAction()



	/**
	 * Página com Menu Lateral
	 * @access public
	 * @param void
	 * @return void
	 */
	public function paginaMenuLateralAction()
	{
	} // fecha método paginaMenuLateralAction()



	/**
	 * Menu Lateral
	 * @access public
	 * @param void
	 * @return void
	 */
	public function menuLateralAction()
	{
	} // fecha método menuLateralAction()


    /**
     * Menu Lateral Reduzido
     * @access public
     * @param void
     * @return void
     */
    public function menuLateralReduzidoAction()
    {
        $this->view->bodyClass = 'small-menu';
    } // fecha método menuLateralReduzidoAction()

	/**
	 * Mensagens
	 * @access public
	 * @param void
	 * @return void
	 */
	public function mensagensAction()
	{
	} // fecha método mensagensAction()



	/**
	 * Menu de Abas
	 * @access public
	 * @param void
	 * @return void
	 */
	public function menuAbas1Action()
	{
	} // fecha método menuAbas1Action()

	public function menuAbas2Action()
	{
	} // fecha método menuAbas2Action()

	public function menuAbas3Action()
	{
	} // fecha método menuAbas3Action()

	public function menuAbas4Action()
	{
	} // fecha método menuAbas4Action()



	/**
	 * Formulários
	 * @access public
	 * @param void
	 * @return void
	 */
	public function formulariosAction()
	{
	} // fecha método formulariosAction()



	/**
	 * Máscaras em JavaScript
	 * @access public
	 * @param void
	 * @return void
	 */
	public function mascarasJsAction()
	{
	} // fecha método mascarasJsAction()



	/**
	 * Máscaras em PHP
	 * @access public
	 * @param void
	 * @return void
	 */
	public function mascarasPhpAction()
	{
	} // fecha método mascarasPhpAction()



	/**
	 * Tabelas
	 * @access public
	 * @param void
	 * @return void
	 */
	public function tabelasAction()
	{
	} // fecha método tabelasAction()

    /**
     * Datatables
     * @access public
     * @param void
     * @return void
     */
    public function dataTablesAction()
    {
        $this->view->bodyClass = 'nano-menu';

    } // fecha método tabelasAction()


	/**
	 * Grids
	 * @access public
	 * @param void
	 * @return void
	 */
	public function gridsAction()
	{
	} // fecha método gridsAction()



	/**
	 * Planilha
	 * @access public
	 * @param void
	 * @return void
	 */
	public function planilhaAction()
	{
	} // fecha método planilhaAction()



	/**
	 * Modal
	 * @access public
	 * @param void
	 * @return void
	 */
	public function modalAction()
	{
	}

	/**
	 * Modal
	 * @access public
	 * @param void
	 * @return void
	 */
	public function buttonsAction()
	{
	}
}
