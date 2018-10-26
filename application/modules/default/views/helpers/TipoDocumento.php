<?php
/**
 * Nomes dos status da comprova��o f�sica do projeto
 * @author Equipe RUP - Politec
 * @since 14/05/2010
 * @version 1.0
 * @package application
 * @subpackage application.views.helpers
 * @copyright � 2010 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */

class Zend_View_Helper_TipoDocumento
{
    /**
     * M�todo com os status dos comprovantes de status do projeto
     * @access public
     * @param string $status
     * @return string $nomeStatus
     */
    public function tipoDocumento($status)
    {
        switch ($status) {
                    case 1:
                        $status = 'Boleto Banc�rio';
                        break;
                    case 2:
                        $status = 'Cupom Fiscal';
                        break;
                    case 3:
                        $status = 'Nota fiscal/Fatura';
                        break;
                    case 4:
                        $status = 'Recibo de Pagamento Aut�nomo';
                        break;
                    default:
                        $status = '-';
                        break;
                }

        return $status;
    } // fecha m�todo statusComprovacaoFisicaDoProjeto()
} // fecha class
