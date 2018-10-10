<?php
/**
 * Helper para verificar se projeto está disponível para finalização
 */

class Zend_View_Helper_DisponivelParaFinalizar
{
    /**
     * Método para verificar se o projeto está disponível para finalizar
     * @access public
     * @param integer $idTipoDoAtoAdministrativo
     * @param integer $idPronac
     * @return string
     */
    public function disponivelParaFinalizar($idTipoDoAtoAdministrativo, $idPronac)
    {
        if (!$idTipoDoAtoAdministrativo) {
            return;
        }
        if (!$idPronac) {
            return;
        }

        $objDbTableDocumentoAssinatura = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
        print $idTipoDoAtoAdministrativo . '/' . $idPronac;
        
        print $objDbTableDocumentoAssinatura->isDocumentoFinalizado($idTipoDoAtoAdministrativo, $idPronac);
        return $objDbTableDocumentoAssinatura->isDocumentoFinalizado($idTipoDoAtoAdministrativo, $idPronac);
    }
}
