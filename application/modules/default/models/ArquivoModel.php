<?php
class ArquivoModel
{
    private $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @throws Exception
     */
    public function cadastrar($inputName)
    {
        // pega as informa��es do arquivo
        $arquivoNome = $_FILES[$inputName]['name']; // nome
        $arquivoTemp = $_FILES[$inputName]['tmp_name']; // nome tempor�rio
        $arquivoTipo = $_FILES[$inputName]['type']; // tipo
        $arquivoTamanho = $_FILES[$inputName]['size']; // tamanho
        
        if (!empty($arquivoNome) && !empty($arquivoTemp)) {
            $arquivoExtensao = Upload::getExtensao($arquivoNome); // extens�o
            $arquivoBinario = Upload::setBinario($arquivoTemp); // bin�rio
            $arquivoHash = Upload::setHash($arquivoTemp); // hash
            if ($arquivoExtensao != 'doc' and $arquivoExtensao != 'docx' and $arquivoExtensao != '') {
                // cadastra dados do arquivo
                $dadosArquivo = array(
                    'nmArquivo' => $arquivoNome,
                    'sgExtensao' => $arquivoExtensao,
                    'dsTipoPadronizado' => $arquivoTipo,
                    'nrTamanho' => $arquivoTamanho,
                    'dtEnvio' => new Zend_Db_Expr('GETDATE()'),
                    'dsHash' => $arquivoHash,
                    'stAtivo' => 'A'
                );
                ArquivoDAO::cadastrar($dadosArquivo);
                // pega o id do �ltimo arquivo cadastrado
                $idUltimoArquivo = ArquivoDAO::buscarIdArquivo();
                $this->setId((int) $idUltimoArquivo[0]->id);
                // cadastra o bin�rio do arquivo
                ArquivoImagemDAO::cadastrar(array('idArquivo' => $this->getId(), 'biArquivo' => $arquivoBinario));
            }
        } else {
            throw new ErrorException('Arquivo inv�lido.');
        }
    }

    public function deletar($idArquivo)
    {
        ArquivoDAO::deletar($idArquivo);
    }

    public function buscar()
    {
        if (null === $this->getId()) {
            throw new BadMethodCallException('Informe o id do arquivo');
        }
        $arquivoModel = new Arquivo();
        $arquivoRowset = $arquivoModel->buscar(array('idArquivo = ?' => $this->getId()));
        if ($arquivoRowset->count()) {
            return $arquivoRowset->current();
        }
    }
}
