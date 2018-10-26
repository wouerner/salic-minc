<?php
/**
 * Contador de caracteres para campos de textos
 * @author Equipe RUP - Politec
 * @since 28/04/2010
 * @version 1.0
 * @package application
 * @subpackage application.view.helpers
 * @copyright � 2010 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */

class Zend_View_Helper_ContadorTextarea
{
    /**
     * M�todo com os parametros com contador
     * @access public
     * @param string $campo (campo textarea)
     * @param string $contador (campo que exibe a quantidade de caracteres restantes)
     * @param integer $limite (quantidade m�xima de caracteres)
     * @return string $eventos
     */
    public function contadorTextarea($campo, $contador, $limite)
    {
        $eventos = "onkeydown=\"caracteresTextarea(this." . $campo . ", this." . $contador . ", " . $limite . ");\" 
					onkeyup=\"caracteresTextarea(this." . $campo . ", this." . $contador . ", " . $limite . ");\"";
        return $eventos;
    } // fecha m�todo contadorTextarea()
} // fecha class
