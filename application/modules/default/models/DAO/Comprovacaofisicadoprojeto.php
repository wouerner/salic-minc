<?php

class Comprovacaofisicadoprojeto extends Zend_Db_Table
{
    protected $_name = 'scSAC.dbo.tbComprovanteExecucao'; // nome da tabela

    /**
     * M�todo aguardandoavaliacao()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function aguardandoavaliacao($pronac = null, $status = null, $dt_inicio = null, $dt_fim = null)
    {
        // busca dados do arquivo
        $sql = "SELECT 
			      pro.IdPRONAC,
			      pro.NomeProjeto,
			      doc.stParecerComprovante AS StatusComprovante,
			      CONVERT(CHAR(10), tmp.dtEnvioComprovante,103) + ' ' + CONVERT(CHAR(8), tmp.dtEnvioComprovante,108) AS DataRecebimento
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc,
			     BDCORPORATIVO.scSAC.Projetos pro,
			     (SELECT idPronac, MAX(dtEnvioComprovante) dtEnvioComprovante
			      FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao
			      WHERE stComprovante = 'A'
			      GROUP BY idPronac) AS tmp
			WHERE doc.idPRONAC = pro.IdPRONAC 
				AND doc.dtEnvioComprovante = tmp.dtEnvioComprovante 
				AND stComprovante = 'A' ";

        // consulta inicial (mostra todos os projetos com comprovantes em avalia��o)
        if (empty($pronac) && empty($status) && empty($dt_inicio) && empty($dt_fim)) {
            $sql.= "AND doc.stParecerComprovante = 'AG' ";
        }
        // consulta pelo id do pronac
        if (!empty($pronac)) {
            $sql.= "AND doc.idPRONAC = '$pronac' ";
        }
        // consulta pelo status do pronac
        if (!empty($status)) {
            // se o projeto tiver pelo menos um comprovante
            // com o status 'Aguardando Avalia��o'
            if ($status == "AG") {
                $sql.= "AND doc.stParecerComprovante = 'AG' ";
            }

            // se o projeto tiver pelo menos um comprovante
            // com o status 'Em Avalia��o'
            if ($status == "AV") {
                $sql.= "AND doc.stParecerComprovante = 'AV' ";
            }

            // se o projeto n�o tiver comprovantes
            // com os status 'Aguardando Avalia��o' em 'Em Avalia��o'
            if ($status == "AA") {
                $sql.= "AND doc.stParecerComprovante <> 'AG' ";
                $sql.= "AND doc.stParecerComprovante <> 'AV' ";
            }
        } // fecha if

        // busca pela data
        if (!empty($dt_inicio) && !empty($dt_fim)) {
            $sql.= "AND doc.dtEnvioComprovante BETWEEN '$dt_inicio' AND '$dt_fim' ";
        } else {
            if (!empty($dt_inicio)) {
                $sql.= "AND doc.dtEnvioComprovante > '$dt_inicio' ";
            }
            if (!empty($dt_fim)) {
                $sql.= "AND doc.dtEnvioComprovante < '$dt_fim' ";
            }
        }

        $sql.= "ORDER BY doc.dtEnvioComprovante DESC;";
                    
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha aguardandoavaliacao()
    

    
    /**
     * M�todo comprovantesemavaliacao()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function comprovantesemavaliacao($pronac)
    {
        // busca dados do arquivo
        $sql = "SELECT 
				pro.IdPRONAC,
				pro.NomeProjeto,
				doc.idComprovante AS id,
				tipodoc.dsTipoDocumento,
				doc.nmComprovante AS Nome,
				arq.idArquivo,
				arq.nmArquivo,
				arq.nrTamanho,
				CONVERT(CHAR(10), doc.dtEnvioComprovante,103) + ' ' + CONVERT(CHAR(8), doc.dtEnvioComprovante,108) AS DataRecebimento,
				CONVERT(CHAR(10), doc.dtParecer,103) + ' ' + CONVERT(CHAR(8), doc.dtParecer,108) AS DataResposta,
			    doc.stParecerComprovante AS StatusComprovante
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc,
			     BDCORPORATIVO.scSAC.Projetos pro, 
			     BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc,
			     BDCORPORATIVO.scCorp.tbArquivo arq 
			WHERE doc.idPRONAC = pro.IdPRONAC 
				AND doc.idTipoDocumento = tipodoc.idTipoDocumento
				AND doc.idArquivo = arq.idArquivo
				AND doc.stComprovante = 'A' 
				AND doc.idComprovanteAnterior IS NULL
				AND doc.idPRONAC = '$pronac' 
			ORDER BY doc.dtEnvioComprovante DESC";

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha comprovantesemavaliacao()



    /**
     * M�todo subcomprovantesemavaliacao()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function subcomprovantesemavaliacao($idPronac, $idComprovante)
    {
        // busca dados do arquivo
        $sql = "SELECT 
				doc.idComprovante AS id,
				tipodoc.dsTipoDocumento,
				doc.nmComprovante AS Nome,
				arq.nmArquivo,
				CONVERT(CHAR(10), doc.dtEnvioComprovante,103) + ' ' + CONVERT(CHAR(8), doc.dtEnvioComprovante,108) AS DataRecebimento,
				CONVERT(CHAR(10), doc.dtParecer,103) + ' ' + CONVERT(CHAR(8), doc.dtParecer,108) AS DataResposta,
			    doc.stParecerComprovante AS StatusComprovante
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc,
			     BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc,
			     BDCORPORATIVO.scCorp.tbArquivo arq 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento
				AND doc.idArquivo = arq.idArquivo
				AND doc.stComprovante = 'A' 
				AND doc.idPRONAC = $idPronac 
				AND idComprovante <> $idComprovante 
				AND idComprovanteAnterior = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC";

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha subcomprovantesemavaliacao()



    /**
     * M�todo avaliarcomprovante()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function avaliarcomprovante($idPronac, $idComprovante)
    {
        // busca os dados do comprovante
        $sql = "SELECT 
				doc.idComprovante,
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa, 
				doc.dsParecerComprovante AS Parecer 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovante = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha avaliarcomprovante()



    public static function cadastraravaliarcomprovante($dados)
    {
        // busca os dados do comprovante
        $sql = "SELECT 
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa, 
				doc.dsParecerComprovante AS Parecer 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovante = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha avaliarcomprovante()

    
    
    
    /**
     * M�todo aprovarcomprovante()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function aprovarcomprovante($idPronac, $idComprovante)
    {
        // busca os dados do comprovante
        $sql = "SELECT 
				doc.idComprovante,
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa, 
				doc.dsParecerComprovante AS Parecer 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovante = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha aprovarcomprovante()
    
    
    /**
     * M�todo avaliarcomprovantealterado()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function avaliarcomprovantealterado($idPronac, $idComprovante)
    {
        $sql = "SELECT 
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa, 
				doc.dsParecerComprovante AS Parecer 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovante = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha avaliarcomprovantealterado()
    
    
    
    /**
     * M�todo aprovarcomprovantealterado()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function aprovarcomprovantealterado($idPronac, $idComprovante, $alterado = null)
    {
        if (empty($alterado)) {
            $sql = "SELECT 
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa, 
				doc.dsParecerComprovante AS Parecer 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovante = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        } else {
            $sql = "SELECT 
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa, 
				doc.dsParecerComprovante AS Parecer 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovanteAnterior = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        }

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha aprovarcomprovantealterado()
    
    
    
    /**
     * M�todo aguardandoaprovacao()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function aguardandoaprovacao($pronac = null, $status = null, $dt_inicio = null, $dt_fim = null)
    {
        // busca dados do arquivo
        $sql = "SELECT 
			      pro.IdPRONAC,
			      pro.NomeProjeto,
			      doc.stParecerComprovante AS StatusComprovante,
			      CONVERT(CHAR(10), tmp.dtEnvioComprovante,103) + ' ' + CONVERT(CHAR(8), tmp.dtEnvioComprovante,108) AS DataRecebimento, 
			      CONVERT(CHAR(10), doc.dtParecer,103) + ' ' + CONVERT(CHAR(8), doc.dtParecer,108) AS DataResposta 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc,
			     BDCORPORATIVO.scSAC.Projetos pro,
			     (SELECT idPronac, MAX(dtEnvioComprovante) dtEnvioComprovante
			      FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao
			      WHERE stComprovante = 'A'
			      GROUP BY idPronac) AS tmp
			WHERE doc.idPRONAC = pro.IdPRONAC 
				AND doc.dtEnvioComprovante = tmp.dtEnvioComprovante 
				AND stComprovante = 'A' ";

        // consulta pelo id do pronac
        if (!empty($pronac)) {
            $sql.= "AND doc.idPRONAC = '$pronac' ";
        }
        // consulta pelo status do pronac
        if (!empty($status)) {
            // se o projeto tiver pelo menos um comprovante
            // com o status 'Aguardando Avalia��o'
            if ($status == "AG") {
                $sql.= "AND doc.stParecerComprovante = 'AG' ";
            }

            // se o projeto tiver pelo menos um comprovante
            // com o status 'Em Avalia��o'
            if ($status == "AV") {
                $sql.= "AND doc.stParecerComprovante = 'AV' ";
            }

            // se o projeto n�o tiver comprovantes
            // com os status 'Aguardando Avalia��o' em 'Em Avalia��o'
            if ($status == "AA") {
                $sql.= "AND doc.stParecerComprovante <> 'AG' ";
                $sql.= "AND doc.stParecerComprovante <> 'AV' ";
            }
        } // fecha if

        // busca pela data
        if (!empty($dt_inicio) && !empty($dt_fim)) {
            $sql.= "AND doc.dtEnvioComprovante BETWEEN '$dt_inicio' AND '$dt_fim' ";
        } else {
            if (!empty($dt_inicio)) {
                $sql.= "AND doc.dtEnvioComprovante > '$dt_inicio' ";
            }
            if (!empty($dt_fim)) {
                $sql.= "AND doc.dtEnvioComprovante < '$dt_fim' ";
            }
        }

        $sql.= "ORDER BY doc.dtEnvioComprovante DESC;";
                    
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha aguardandoaprovacao()



    /**
     * M�todo comprovantesemaprovacao()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function comprovantesemaprovacao($pronac)
    {
        // busca dados do arquivo
        $sql = "SELECT 
				pro.IdPRONAC,
				pro.NomeProjeto,
				doc.idComprovante AS id,
				tipodoc.dsTipoDocumento,
				doc.nmComprovante AS Nome,
				arq.idArquivo,
				arq.nmArquivo,
				arq.nrTamanho,
				CONVERT(CHAR(10), doc.dtEnvioComprovante,103) + ' ' + CONVERT(CHAR(8), doc.dtEnvioComprovante,108) AS DataRecebimento,
				CONVERT(CHAR(10), doc.dtParecer,103) + ' ' + CONVERT(CHAR(8), doc.dtParecer,108) AS DataResposta,
			    doc.stParecerComprovante AS StatusComprovante
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc,
			     BDCORPORATIVO.scSAC.Projetos pro, 
			     BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc,
			     BDCORPORATIVO.scCorp.tbArquivo arq 
			WHERE doc.idPRONAC = pro.idPRONAC 
				AND doc.idTipoDocumento = tipodoc.idTipoDocumento
				AND doc.idArquivo = arq.idArquivo
				AND doc.stComprovante = 'A' 
				AND doc.idComprovanteAnterior IS NULL
				AND doc.idPRONAC = '$pronac' 
			ORDER BY doc.dtEnvioComprovante DESC";

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha comprovantesemavaliacao()



    /**
     * M�todo subcomprovantesemaprovacao()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function subcomprovantesemaprovacao($idPronac, $idComprovante)
    {
        // busca dados do arquivo
        $sql = "SELECT 
				doc.idComprovante AS id,
				tipodoc.dsTipoDocumento,
				doc.nmComprovante AS Nome,
				arq.nmArquivo,
				CONVERT(CHAR(10), doc.dtEnvioComprovante,103) + ' ' + CONVERT(CHAR(8), doc.dtEnvioComprovante,108) AS DataRecebimento,
				CONVERT(CHAR(10), doc.dtParecer,103) + ' ' + CONVERT(CHAR(8), doc.dtParecer,108) AS DataResposta,
			    doc.stParecerComprovante AS StatusComprovante
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc,
			     BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc,
			     BDCORPORATIVO.scCorp.tbArquivo arq 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento
				AND doc.idArquivo = arq.idArquivo
				AND doc.stComprovante = 'A' 
				AND doc.idPRONAC = $idPronac 
				AND idComprovante <> $idComprovante 
				AND idComprovanteAnterior = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC";

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha subcomprovantesemavaliacao()
    
    
    
    /**
     * M�todo visualizarcomprovantedeferido()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function visualizarcomprovantedeferido($idPronac, $idComprovante)
    {
        // busca os dados do comprovante
        $sql = "SELECT 
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa, 
				doc.dsParecerComprovante AS Parecer 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovante = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha visualizarcomprovantedeferido()
    
    
    
    /**
     * M�todo visualizarcomprovanteindeferido()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function visualizarcomprovanteindeferido($idPronac, $idComprovante)
    {
        // busca os dados do comprovante
        $sql = "SELECT 
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa, 
				doc.dsParecerComprovante AS Parecer 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovante = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    } // fecha visualizarcomprovanteindeferido()
    
    
    
    /**
     * M�todo visualizarcomprovantesubstituido()
     * @access public
     * @param integer $id
     * @return object $db->fetchAll($sql)
     */
    public static function visualizarcomprovantesubstituido($idPronac, $idComprovante)
    {
        // busca os dados do comprovante
        $sql = "SELECT 
				pro.IdPRONAC, 
				pro.NomeProjeto, 
				tipodoc.dsTipoDocumento, 
				doc.nmComprovante AS Titulo, 
				doc.dsComprovante AS Descricao, 
				doc.idArquivo, 
				arq.nmArquivo, 
				doc.dsJustificativaAlteracao AS Justificativa 
			FROM BDCORPORATIVO.scSAC.tbComprovanteExecucao doc, 
				BDCORPORATIVO.scSAC.tbTipoDocumento tipodoc, 
				BDCORPORATIVO.scCorp.tbArquivo arq, 
				BDCORPORATIVO.scSAC.Projetos pro 
			WHERE doc.idTipoDocumento = tipodoc.idTipoDocumento 
				AND doc.idArquivo = arq.idArquivo 
				AND doc.idPRONAC = pro.IdPRONAC 
				AND doc.idPRONAC = $idPronac 
				AND doc.idComprovante = $idComprovante 
			ORDER BY doc.dtEnvioComprovante DESC;";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);
        return $db->query($sql);
    }
} 
