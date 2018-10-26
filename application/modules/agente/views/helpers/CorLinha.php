<?php
/**
 * Cores alternativas dos registros de uma tabela (cor sim, cor n�o)
 * @author Equipe RUP - Politec
 * @since 29/03/2010
 * @version 1.0
 * @package application
 * @subpackage application.view.helpers
 * @link http://www.cultura.gov.br
 */

class Zend_View_Helper_CorLinha
{
    /**
     * M�todo com as cores alternativas das linhas da tabela
     * @access public
     * @param integer $i
     * @return string
     */
    public function corLinha($i)
    {
        die(1);
        if ($i % 2 == 0) {
            $bg = "fundo_linha1";
        } else {
            $bg = "fundo_linha2";
        }

        return $bg;
    } // fecha m�todo corLinha()
} // fecha class
