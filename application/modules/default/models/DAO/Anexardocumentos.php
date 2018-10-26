<?php
/**
 * Modelo Execucaofisicaprojeto
 * @author Equipe RUP - Politec
 * @since 29/03/2010
 * @version 1.0
 * @package application
 * @subpackage application.models
 * @copyright � 2010 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */

class Anexardocumentos extends Zend_Db_Table
{
    /**
     * M�todo para buscar documentos de um PRONAC
     * @access public
     * @static
     * @param integer $idPronac
     * @return object
     */
    public static function buscardocumentos($pronac)
    {
        $sql = "SELECT doc.idComprovante AS id, 
				doc.idTipoDocumento, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Nome,
				doc.idArquivo, 
				arq.nmArquivo, 
				arq.dsTipo, 
				arq.nrTamanho,
				arqimg.biArquivo,
				CONVERT(CHAR(10), doc.dtEnvioComprovante,103) + ' ' + CONVERT(CHAR(8), doc.dtEnvioComprovante,108) 
					AS dtEnvioComprovante, 
				doc.stParecerComprovante, 
				doc.idComprovanteAnterior 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scCorp.tbArquivoImagem arqimg 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND arq.idArquivo = arqimg.idArquivo 
				AND doc.idPRONAC = " . $pronac . " 
			ORDER BY doc.dtEnvioComprovante DESC;";

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB :: FETCH_OBJ);
            return $db->fetchAll($sql);
        } catch (Zend_Exception_Db $e) {
            $this->view->message = "Erro ao buscar Comprovantes: " . $e->getMessage();
        }
    } // fecha m�todo buscar()



    /**
     * M�todo para cadastrar documentos do PRONAC
     * @access public
     * @param void
     * @return object
     */
    public static function cadastrar($dados)
    {
        /*$sql = "INSERT INTO BDCORPORATIVO.scSAC.tbComprovanteExecucao ";
        $sql.= "VALUES ($dados['idPRONAC'], $dados['idTipoDocumento'], $dados['nmComprovante'], $dados['dsComprovante'], $dados['idArquivo'], $dados['idSolicitante'], $dados['dtEnvioComprovante'], $dados['stComprovante'], $dados['stComprovante'], $dados['idComprovanteAnterior'])";*/
    } // fecha m�todo cadastrar()
} // fecha class
