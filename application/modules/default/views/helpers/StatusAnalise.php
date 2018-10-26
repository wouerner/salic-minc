<?php
/**
 * Tipos de status da an�lise para Verificar a Readequa��o
 * @author emanuel.sampaio - Politec
 * @since 30/08/2011
 * @version 1.0
 * @package application
 * @subpackage application.view.helpers
 * @copyright � 2011 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */

class Zend_View_Helper_StatusAnalise
{
    /**
     * M�todo com os status da an�lise
     * @access public
     * @param string $cor
     * @return string
     */
    public function statusAnalise($cor)
    {
        $cor = trim($cor);

        if ($cor == 'vermelho') {
            $ds = '20 dias de atraso no recebimento da solicita��o (data inicial)';
        } elseif ($cor == 'amarelo') {
            $ds = '>= 10 e < 20 dias de atraso no recebimento da solicita��o (data inicial)';
        } elseif ($cor == 'verde') {
            $ds = '< 10 dias de atraso no recebimento da solicita��o (data inicial)';
        } else {
            $ds = ' ';
        }

        return $ds;
    } // fecha m�todo statusAnalise()
} // fecha class
