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

            $dadosArquivo=[];
            $dadosArquivo['NmArquivo'] = $arquivoNome;
            $dadosArquivo['SgExtensao'] = $arquivoExtensao;
            $dadosArquivo['NrTamanho'] = $arquivoTamanho;
            $dadosArquivo['DtEnvio'] = date('Y-m-d h:i:s');
            $dadosArquivo['StAtivo'] = 'I';
            $dadosArquivo['DsHash'] = $arquivoHash;
            $dadosArquivo['tIdUsuario'] = $this->idUsuario;

            $dadosTbArquivoImagem = [
                'biArquivo' => new Zend_Db_Expr("CONVERT(varbinary(MAX), {$arquivoBinario})")
            ];

            $dadosTbDocumento = [
                'idTipoDocumento' => $arrData['idTipoDocumento'],
                'dsDocumento' => $arrData['dsDocumento'],
            ];

            $tbArquivo = new Arquivo_Model_DbTable_TbArquivo();
            $idArquivo = $tbArquivo->inserirArquivo($dadosArquivo, $dadosTbArquivoImagem, $dadosTbDocumento);

           return $idArquivo;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function excluirArquivo($idDocumento) {

        if(!empty($idDocumento)){
            $tbDocumento = new tbDocumento();
            $dadosArquivo = $tbDocumento->buscar(array('idDocumento =?'=>$idDocumento))->current();

            if($dadosArquivo){
//                    $vwAnexarComprovantes = new vwAnexarComprovantes();
//                    $x = $vwAnexarComprovantes->excluirArquivo($dadosArquivo->idArquivo);

                $tbDocumento = new tbDocumento();
                $tbDocumento->excluir("idArquivo = {$dadosArquivo->idArquivo} and idDocumento= {$idDocumento} ");

                $tbArquivoImagem = new tbArquivoImagem();
                $tbArquivoImagem->excluir("idArquivo =  {$dadosArquivo->idArquivo} ");

                $tbArquivo = new tbArquivo();
                $tbArquivo->excluir("idArquivo = {$dadosArquivo->idArquivo} ");
            }
        }
    }

}
