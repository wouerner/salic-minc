<?php
/**
 * Helper para verificar se há produtos pendentes de parecer
 */

class Zend_View_Helper_IsProdutosPendentesParecer
{
    /**
     * Método para verificar se há produtos pendentes de parecer
     * @access public
     * @param integer $idPronac
     * @param integer $idProduto
     * @return string
     */
    public function IsProdutosPendentesParecer($idPronac, $idProduto)
    {
        $tbAnaliseDeConteudoDAO = new Analisedeconteudo();
        $where['IdPRONAC = ?'] = $idPronac;
        $where['idProduto = ?'] = $idProduto;
        $where['ParecerDeConteudo = ?'] = '';
        $naoAnalisados = $tbAnaliseDeConteudoDAO->dadosAnaliseconteudo(null, $where);
        
        if (count($naoAnalisados) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
