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

            $dadosTbArquivo = [
                'idArquivo' => '',
                'nmArquivo' => $arquivoNome,
                'sgExtensao' => $arquivoExtensao,
                'nrTamanho' => $arquivoTamanho,
                'dtEnvio' => GETDATE(),
                'stAtivo' => 'I', // @todo verificar se eh isso mesmo
                'dsHash' => $arquivoHash
            ];

            $dadosTbArquivoImagem = [
                'idArquivo' => 'tbArquivo.idArquivo = tbArquivoImagem.idArquivo',
                'biArquivo' => $arquivoBinario
            ];

            $dadosTbDocumento = [
                'c.idDocumento' => '',
                'c.idTipoDocumento' => $arrData['idTipoDocumento'],
                'c.dsDocumento' => $arrData['dsDocumento'],
                'idArquivo' => $idArquivo,
            ];
//
//            $tableTbArquivo = $this;
//
//            $objArquivo = new Arquivo_Model_TbArquivo();
//            $objArquivo->setNmArquivo($arquivoNome);
//            $objArquivo->setSgExtensao($arquivoExtensao);
//            $objArquivo->setNrTamanho($arquivoTamanho);
//            $objArquivo->setDtEnvio(GETDATE());
//            $objArquivo->setStAtivo('I');
//            $objArquivo->setDsHash($arquivoHash);
//
//            $objArquivoImagem = new Arquivo_Model_TbArquivoImagem();
//
////            $objArquivoImagem->setIdArquivo($idArquivo);
////            $objArquivoImagem->setBiArquivo($arquivoBinario);
//
//            $objDocumento = new Arquivo_Model_TbDocumento();



//            $objDocumento->setIdArquivo($idArquivo);
//            $objDocumento->setIdTipoDocumento($arrData['idTipoDocumento']);
//            $objDocumento->setDsDocumento($arrData['dsDocumento']);


            $modelTbArquivo = new Arquivo_Model_TbArquivo();

            $tableTbArquivo = $this;
            $tbArquivoImagem = new Arquivo_Model_DbTable_TbArquivoImagem();
            $tbDocumento = new Arquivo_Model_DbTable_TbDocumento();

            //$dadosTbArquivo['imdocumento'] = new Zend_Db_Expr("CONVERT(varbinary(MAX), {$arquivoBinario})");

            # iniciar transacao
            $modelTbArquivo->setOptions($dadosTbArquivo);
            $idArquivo = $tableTbArquivo->save($modelTbArquivo);

            $dadosTbArquivoImagem['idArquivo'] = $idArquivo;
            $dadosTbDocumento['idArquivo'] = $idArquivo;

            $tbArquivoImagem->insert($dadosTbArquivoImagem);
            $tbDocumento->insert($dadosTbDocumento);

            # commit

        } catch (Exception $e) {
            #rollback
            $this->setMessage($e->getMessage());
        }

        return $idArquivo;
    }

}
