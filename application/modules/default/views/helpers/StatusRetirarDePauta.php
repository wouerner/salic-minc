<?php
/**
 * Classe para verificar o status da retirada de pauta
 * @author emanuel.sampaio - XTI
 * @since 17/01/2012
 * @version 1.0
 * @package application
 * @subpackage application.views.helpers
 * @copyright � 2012 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */

class Zend_View_Helper_StatusRetirarDePauta
{
    /**
     * metodo que verifica o status da retirada de pauta
     * @access public
     * @param integer $idPronac
     * @return void
     */
    public function statusRetirarDePauta($idPronac, $idAgenteEnvio = null)
    {
        // busca as solicita��es ativas
        $tbRetirarDePauta = new tbRetirarDePauta();
        if (empty($idAgenteEnvio)) {
            $where = array('idPronac = ?' => $idPronac);
        } else {
            $where = array('idPronac = ?' => $idPronac, 'idAgenteEnvio = ?' => $idAgenteEnvio);
        }
        $order = array('idRetirarDePauta DESC');

        return $tbRetirarDePauta->buscarDados($where, $order)->current();
    } // fecha m�todo statusRetirarDePauta()
} // fecha class
