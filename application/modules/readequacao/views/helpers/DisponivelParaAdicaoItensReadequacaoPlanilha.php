<?php
/**
 * Helper para verificar se projeto está disponível para adição de itens da readequação da planilha
 */

class Zend_View_Helper_DisponivelParaAdicaoItensReadequacaoPlanilha
{
    /**
     * Método para verificar se o projeto está disponível para adição de itens da readequação da planilha
     * @access public
     * @param integer $idPronac
     * @param integer $idAgente
     * @return string
     */
    public function disponivelParaAdicaoItensReadequacaoPlanilha($idPronac, $idAgente = null)
    {
        $Readequacao_Model_DbTable_TbReadequacao = new Readequacao_Model_DbTable_TbReadequacao();
        
        return $Readequacao_Model_DbTable_TbReadequacao->disponivelParaAdicaoItensReadequacaoPlanilha($idPronac, $idAgente);
    }
}
