<?php

/**
 * Class Proposta_Model_TbDocumentosAgentesMapper
 * @todo mover para o módulo de agentes
 */

class Proposta_Model_TbDocumentosAgentesMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Proposta_Model_DbTable_TbDocumentosAgentes');
    }

    /**
     * @return bool
     */
    public function saveCustom($arrPost, Zend_File_Transfer $file)
    {
        $files = $file->getFileInfo();
        $booResult = true;
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
                $booResult = false;
            } else {
                # Verifica se tipo de documento ja esta cadastrado
                $tbPreProjeto = new Proposta_Model_DbTable_PreProjeto();
                $dadosProjeto = $tbPreProjeto->findBy(array('idpreprojeto' => $arrPost['idPreProjeto']));

                $where = array();
                $where['codigodocumento'] = $arrPost['documento'];
                if ($arrPost['tipoDocumento'] == 1) {
                    $where['idagente'] = $dadosProjeto['idAgente'];
                } else {
                    $where['idprojeto'] = $arrPost['idPreProjeto'];
                }

                $strPath = '/data/proposta/model/tbdocumentoagentes/';
                $strPathFull = APPLICATION_PATH . '/..' . $strPath;

                $dadosArquivo = array(
                    'codigodocumento' => $arrPost['documento'],
                    'idprojeto' => $arrPost['idPreProjeto'],
                    'data' => date('Y-m-d'),
                    'noarquivo' => $arquivoNome,
                    'taarquivo' => $arquivoTamanho,
                    'dsdocumento' => $arrPost['observacao'],
                    'idagente' => $dadosProjeto['idAgente'],
                );

                if ($arrPost['tipoDocumento'] == 1) {
                    $table = $this;
                    $model = new Proposta_Model_TbDocumentosAgentes();
                } else {
                    $table = new Proposta_Model_TbDocumentosPreProjetoMapper();
                    $model = new Proposta_Model_TbDocumentosPreProjeto();
                }

                $docCadastrado = $table->findBy($where);

                if ($table->findBy($where)) {
                    $this->setMessage('Tipo de documento j&aacute; cadastrado!');
                    $booResult = false;
                }
                if ($this->getDbTable()->getAdapter() instanceof Zend_Db_Adapter_Pdo_Mssql) {
                    $dadosArquivo['imdocumento'] = new Zend_Db_Expr("CONVERT(varbinary(MAX), {$arquivoBinario})");
                    //$dadosArquivo['imDocumento'] = new Zend_Db_Expr("CONVERT(varbinary(MAX), {$arquivoBinario})");
                    try {
                        if ($booResult) {
                            $model->setOptions($dadosArquivo);
                            $table->save($model);
                        }
                    } catch (Exception $e) {
                        $this->setMessage($e->getMessage());
                        $booResult = false;
                    }
                } else {
                    $strId = md5(uniqid(rand(), true));
                    $fileName = $strId . '.' . array_pop(explode('.', $file->getFileName()));
                    $dadosArquivo['imdocumento'] = $strPath . $fileName;
                    try {
                        if ($booResult) {
                            $model->setOptions($dadosArquivo);
                            $table->save($model);
                            $file->receive();
                            copy($file->getFileName(), $strPathFull . $fileName);
                        }
                    } catch (Exception $e) {
                        $this->setMessage($e->getMessage());
                        $booResult = false;
                    }
                }

                //var_dump($arrPost);die;
                # REMOVER AS PENDENCIAS DE DOCUMENTO
                $tblDocumentosPendentesProjeto = new Proposta_Model_DbTable_DocumentosProjeto();
                $tblDocumentosPendentesProponente = new Proposta_Model_DbTable_DocumentosProponente();
                $tblDocumentosPendentesProjeto->delete("idprojeto = {$arrPost['idPreProjeto']} AND codigodocumento = {$arrPost['documento']}");
                $tblDocumentosPendentesProponente->delete("idprojeto = {$arrPost['idPreProjeto']} AND codigodocumento = {$arrPost['documento']}");
            }
        } else {
            $this->setMessage('Falha ao anexar arquivo! O tamanho m&aacute;ximo permitido &egrave; de 10MB.');
            $booResult = false;
        }

        return $booResult;
    }

    public function save($model)
    {
        return parent::save($model);
    }
}
