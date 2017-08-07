<?php

/**
 * Class Arquivo_Model_TbArquivoMapper
 */
class Arquivo_Model_TbArquivoMapper extends MinC_Db_Mapper
{

    public function __construct()
    {
        $this->setDbTable('Arquivo_Model_DbTable_TbArquivo');
    }

    public function salvarArquivo()
    {
        /**
         * SELECT
         * a.idArquivo,
         * a.nmArquivo,
         * a.sgExtensao,
         * a.nrTamanho,
         * a.dtEnvio,a.stAtivo,
         * b.biArquivo,
         * c.idDocumento,
         * c.idTipoDocumento,
         * c.dsDocumento,
         * d.idAgente,
         * d.stAtivoDocumentoAgente
         * FROM  BDCORPORATIVO.scCorp.tbArquivo               a
         * INNER JOIN BDCORPORATIVO.scCorp.tbArquivoImagem    b on (a.idArquivo = b.idArquivo)
         * INNER JOIN BDCORPORATIVO.scCorp.tbDocumento        c on (a.idArquivo = c.idArquivo)
         * INNER JOIN BDCORPORATIVO.scCorp.tbDocumentoAgente d on (c.idTipoDocumento = d.idTipoDocumento and c.idDocumento = d.idDocumento)
         * $db = Zend_Db_Table::getDefaultAdapter();
         * $db->setFetchMode(Zend_DB :: FETCH_OBJ);
         *
         * try {
         * $db->beginTransaction();
         *
         * if (!empty($_FILES['arquivo'])):
         * $dadosArquivo = array('nmArquivo' => $arquivoNome,
         * 'sgExtensao' => $arquivoExtensao,
         * 'stAtivo' => 'A',
         * 'dsHash' => $arquivoHash,
         * 'dtEnvio' => $dtAtual
         * );
         *
         * $salvarArquivo = $tbArquivo->cadastrarDados($dadosArquivo);
         * $idArquivo = $tbArquivo->buscarUltimo();
         *
         * $dadosArquivoImagem = array('idArquivo' => $idArquivo['idArquivo'],
         * 'biArquivo' => $arquivoBinario
         * );
         *
         * $dadosAI = "Insert into BDCORPORATIVO.scCorp.tbArquivoImagem
         * (idArquivo, biArquivo) values (" . $idArquivo['idArquivo'] . ", " . $arquivoBinario . ") ";
         *
         * $salvarArquivoImagem = $tbArquivoImagem->salvarDados($dadosAI);
         *
         * $dadosDocumento = array('idTipoDocumento' => 0,
         * 'idArquivo' => $idArquivo['idArquivo']
         * );
         *
         * $salvarDocumento = $tbDocumento->cadastrarDados($dadosDocumento);
         * $ultimoDocumento = $tbDocumento->ultimodocumento();
         *
         * $idDocumento = $ultimoDocumento['idDocumento'];
         * endif;
         *
         *
         * $arrayDados = array('idAgente' => $idAgente,
         * 'idTipoEscolaridade' => $tipoEscolaridade,
         * 'nmCurso' => $curso,
         * 'nmInstituicao' => $instituicao,
         * 'dtInicioCurso' => $dtEntrada,
         * 'dtFimCurso' => $dtSaida,
         * 'idDocumento' => $idDocumento,
         * 'idPais' => $pais
         * );
         *
         * $salvarInfo = $tbEscolaridade->inserirEscolaridade($arrayDados);
         *
         * $db->commit();
         * parent::message("Cadastrado realizado com sucesso!", "agente/agentes/escolaridade/id/" . $idAgente, "CONFIRM");
         * } catch (Exception $e) {
         * $db->rollBack();
         * parent::message("Erro ao cadastrar! " . $e->getMessage(), "agente/agentes/escolaridade/id/" . $idAgente, "ERROR");
         * }
         */


    }

    /**
     *
     * $arquivoData[
     *   'dsDocumento'       => 'Descrição do arquivo',
     *   'idTipoDocumento'   => 27
     *   );
     * ]
     * @param $arrPost
     * @param Zend_File_Transfer $file
     * @param $formats
     * @param $maxSizeFile
     * @return int
     */
    public function saveCustom($arrData, Zend_File_Transfer $file, $formats = array(), $maxSizeFile = 10485760)
    {

        $idArquivo = 0;

        $files = $file->getFileInfo();

        $db = Zend_Db_Table::getDefaultAdapter();

        $objArquivo = new Arquivo_Model_TbArquivo();

        $tbArquivoImagem = new Arquivo_Model_DbTable_TbArquivoImagem();
        $tbDocumento = new Arquivo_Model_DbTable_TbDocumento();
        $tableTbArquivo = new Arquivo_Model_DbTable_TbArquivo();

        try {

            if (!$file->isUploaded())
                throw new Exception("Falha ao anexar arquivo! Verifique o documento e tente novamente!");

            $arquivoNome = $files['arquivo']['name']; # nome
            $arquivoTemp = $files['arquivo']['tmp_name']; # nome temporario
            $arquivoTipo = $files['arquivo']['type']; # tipo
            $arquivoTamanho = $files['arquivo']['size']; # tamanho

            if (!empty($arquivoNome) && !empty($arquivoTemp)) {
                $arquivoExtensao = Upload::getExtensao($arquivoNome); # extensao
                $arquivoBinario = Upload::setBinario($arquivoTemp); # binario
                $arquivoHash = Upload::setHash($arquivoTemp); # hash
            }

            if (!empty($formats) && !in_array(strtolower($arquivoExtensao), $formats)) {
                $extensoesPermitidas = implode(", ", $formats);
                throw new Exception("Erro! Extens&otilde;es permitidas {$extensoesPermitidas}!");
            }

            if ($arquivoTamanho > $maxSizeFile) {
                throw new Exception("O arquivo n&atilde;o pode ser maior do que 10MB!");
            }

            $dadosTbArquivoImagem = [
                'idArquivo' => '',
                'biArquivo' => new Zend_Db_Expr("CONVERT(varbinary(MAX), {$arquivoBinario})")
            ];

            $dadosTbDocumento = [
                'idArquivo' => '',
                'idTipoDocumento' => $arrData['idTipoDocumento'],
                'dsDocumento' => $arrData['dsDocumento'],
            ];


            $objArquivo->setNmArquivo($arquivoNome);
            $objArquivo->setSgExtensao($arquivoExtensao);
            $objArquivo->setNrTamanho($arquivoTamanho);
            $objArquivo->setDtEnvio(date('Y-m-d h:i:s'));
            $objArquivo->setStAtivo('I');
            $objArquivo->setDsHash($arquivoHash);
//            $objArquivo->setIdUsuario($this->idUsuario);

            $obj=[];
            $obj['NmArquivo'] = $arquivoNome;
            $obj['SgExtensao'] = $arquivoExtensao;
            $obj['NrTamanho'] = $arquivoTamanho;
            $obj['DtEnvio'] = date('Y-m-d h:i:s');
            $obj['StAtivo'] = 'I';
            $obj['DsHash'] = $arquivoHash;
//            $obj['tIdUsuario'] = $this->idUsuario;


            # iniciar transacao
            $this->beginTransaction();

            $idArquivo = $this->save($objArquivo);
//            $idArquivo = $this->insert($objArquivo);
            # commit
            if ($idArquivo) {

                $dadosTbArquivoImagem['idArquivo'] = $idArquivo;
                $dadosTbDocumento['idArquivo'] = $idArquivo;

//                $tbArquivoImagem->insert($dadosTbArquivoImagem);
//                $tbDocumento->insert($dadosTbDocumento);

            }

            $this->rollBack();



        } catch (Exception $e) {
            #rollback
            $this->rollBack();
            xd($e, $idArquivo);
            return false;
        }

        return $idArquivo;
    }

}
