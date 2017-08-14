<?php
/**
 * Helper para verificar se o projeto tem parecer
 */

class Zend_View_Helper_IsProjetoComParecer
{
	/**
	 * Método para verificar se o projeto tem parecer
	 * @access public
	 * @param integer $idPronac
	 * @return string
	 */
	public function IsProjetoComParecer($idPronac)
    {
        $parecerDAO	= new Parecer();
        $buscaParecer = $parecerDAO->buscarParecer(null, $idPronac);

        if (count($buscaParecer) > 0) {
            return true;
        } else {
            return false;
        }
    }
}