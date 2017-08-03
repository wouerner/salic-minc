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

    public function saveCustom($arrPost, Zend_File_Transfer $file)
    {
        $idArquivo = false;
        $files = $file->getFileInfo();

        if ($file->isUploaded()) {

            $arquivoNome = $files['arquivo']['name']; # nome
            $arquivoTemp = $files['arquivo']['tmp_name']; # nome temporario
            $arquivoTipo = $files['arquivo']['type']; # tipo
            $arquivoTamanho = $files['arquivo']['size']; # tamanho

            if (!empty($arquivoNome) && !empty($arquivoTemp)) {
                $arquivoExtensao = Upload::getExtensao($arquivoNome); # extensao
                $arquivoBinario = Upload::setBinario($arquivoTemp); # binario
                $arquivoHash = Upload::setHash($arquivoTemp); # hash
            }

            # Tamanho do arquivo: 10MB
            if ($arquivoTamanho > 10485760) {
                $this->setMessage('O arquivo não pode ser maior do que 10MB!');
            } else {

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
                    'c.idTipoDocumento' => '',
                    'c.dsDocumento' => '',
                    'idArquivo' => 'tbArquivo.idArquivo = tbDocumento.idArquivo',
                    'dtEmissaoDocumento' => '',
                    'dtValidadeDocumento' => '',
                    'idTipoEventoOrigem' => '',
                    'nmTitulo' => '',
                    'nrDocumento' => ''
                ];


                $tableTbArquivo = $this;
//                $tableTbArquivoImagem = new Arquivo_Model_TbArquivoImagem();
//                $tableTbDocumento = new Arquivo_Model_TbDocumento();

                $modelTbArquivo = new Arquivo_Model_TbArquivo();

                $tbArquivoImagem = new Arquivo_Model_DbTable_TbArquivoImagem();
                $tbDocumento = new Arquivo_Model_DbTable_TbDocumento();

                try {

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
            }
        } else {
            $this->setMessage('Falha ao anexar arquivo! O tamanho m&aacute;ximo permitido &egrave; de 10MB.');

        }

        return $idArquivo;
    }

}
