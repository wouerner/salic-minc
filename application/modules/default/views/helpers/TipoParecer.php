<?php
/**
 * Descri��o dos tipos de parecer da an�lise do projeto
 * @author Equipe RUP - Politec
 * @since 14/06/2010
 * @version 1.0
 * @package application
 * @subpackage application.view.helpers
 * @copyright � 2010 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */

class Zend_View_Helper_TipoParecer
{
    /**
     * M�todo com a descri��o dos tipos de parecer
     * @access public
     * @param string $parecer
     * @return string $descricao
     */
    public function tipoParecer($parecer)
    {
        if ($parecer == 1) {
            $descricao = "Aprova��o Inicial";
        } elseif ($parecer == 2) {
            $descricao = "Complementa��o";
        } elseif ($parecer == 3) {
            $descricao = "Prorroga��o";
        } elseif ($parecer == 4) {
            $descricao = "Redu��o";
        } else {
            $descricao = "";
        }

        return $descricao;
    } // fecha m�todo tipoParecer()
} // fecha class
