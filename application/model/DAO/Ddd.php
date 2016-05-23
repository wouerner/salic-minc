<?php
/**
 * Modelo Ddd
 * @author Equipe RUP - Politec
 * @since 29/03/2010
 * @version 1.0
 * @package application
 * @subpackage application.models
 * @copyright � 2010 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */

class Ddd extends Zend_Db_Table
{
	protected $_name = 'AGENTES.dbo.DDD'; // nome da tabela



	/**
	 * M�todo para buscar os ddds de um determinado estado
	 * @access public
	 * @param integer $idUF
	 * @return object $db->fetchAll($sql)
	 */
	public static function buscar($idUF)
	{
		$sql = "SELECT AGENTES.dbo.DDD.idDDD AS id, AGENTES.dbo.DDD.Codigo AS descricao ";
		$sql.= "FROM AGENTES.dbo.DDD ";
		$sql.= "WHERE AGENTES.dbo.DDD.idUF = " . $idUF . " ";
		$sql.= "ORDER BY AGENTES.dbo.DDD.Codigo;";

		try
		{
			$db  = Zend_Registry::get('db');
			$db->setFetchMode(Zend_DB::FETCH_OBJ);
		}
		catch (Zend_Exception_Db $e)
		{
			$this->view->message = "Erro ao buscar DDDs: " . $e->getMessage();
		}

        #xd( $sql );
		return $db->fetchAll($sql);
	} // fecha buscar()
} // fecha class