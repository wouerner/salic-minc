<?php

class Recurso_RecursoPropostaController extends Proposta_GenericController
{
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        throw new Exception("Implementar");
    }

    public function visaoProponenteAction()
    {

        $sugestaoEnquadramentoDbTable = new Admissibilidade_Model_DbTable_SugestaoEnquadramento();
        $sugestaoEnquadramentoDbTable->sugestaoEnquadramento->setIdPreprojeto($this->idPreProjeto);
        $this->view->recursoEnquadramento = $sugestaoEnquadramentoDbTable->obterRecursoEnquadramentoProposta();
        if (!empty($this->view->recursoEnquadramento['idArquivo'])
            && !is_null($this->view->recursoEnquadramento['idArquivo'])) {
            $tbArquivo = new tbArquivo();
            $this->view->arquivoRecursoProponente = $tbArquivo->buscarDados($this->view->recursoEnquadramento['idArquivo']);
        }
    }

    /**
     * @todo Refatorar esse trecho de c&oacute;digo pois as demandas desse m&oacute;dulo foram emergenciais.
     */
    public function visaoProponenteSalvarAction()
    {

        $post = $this->getRequest()->getPost();

        $id_preprojeto = trim($post['id_preprojeto']);
        if (empty($id_preprojeto) || is_null($id_preprojeto)) {
            throw new Exception("Identificador da Proposta n&atilde;o foi localizado.");
        }

        $tpSolicitacao = trim($post['tpSolicitacao']);
        if (empty($tpSolicitacao) || is_null($tpSolicitacao)) {
            throw new Exception("O campo 'Tipo de Solicita&amp;ccedil;&amp;atilde;o' &eacute; de preenchimento obrigat&oacute;rio.");
        }

        $justificativa = trim($post['dsRecursoProponente']);
        if (empty($justificativa) || is_null($justificativa)) {
            throw new Exception("O campo 'Justificativa' &eacute; de preenchimento obrigat&oacute;rio.");
        }

        $recursoEnquadramentoDbTable = new Recurso_Model_DbTable_TbRecursoProposta();
        $recursoEnquadramento = $recursoEnquadramentoDbTable->obterRecursoAtualVisaoProponente($id_preprojeto);


        $idArquivo = $this->uploadArquivoProponente($recursoEnquadramento);
        $tbRecursoModel = new Recurso_Model_TbRecursoProposta([
            'idRecursoProposta' => $recursoEnquadramento['idRecursoProposta'],
            'idPreProjeto' => $recursoEnquadramento['idPreProjeto'],
            'dtRecursoProponente' => $recursoEnquadramentoDbTable->getExpressionDate(),
            'dsRecursoProponente' => $justificativa,
            'tpRecurso' => Recurso_Model_TbRecursoProposta::TIPO_RECURSO_PEDIDO_DE_RECONSIDERACAO,
            'tpSolicitacao' => $tpSolicitacao,
            'idArquivo' => $idArquivo,
        ]);
        $tbRecursoMapper = new Recurso_Model_TbRecursoPropostaMapper();
        $tbRecursoMapper->save($tbRecursoModel);

        parent::message(
            'Dados armazenados com sucesso.',
            "/recurso/recurso-proposta/visao-proponente/idPreProjeto/{$id_preprojeto}",
            'CONFIRM'
        );
    }

    /**
     * @return int|null
     */
    private function uploadArquivoProponente(array $recursoEnquadramento)
    {
        if ($recursoEnquadramento['idArquivo']) {
            $tbArquivoDbTable = new tbArquivo();
            $tbArquivoImagemDAO = new tbArquivoImagem();
            $tbArquivoImagemDAO->delete("idArquivo = {$recursoEnquadramento['idArquivo']}");
            $tbArquivoDbTable->delete("idArquivo = {$recursoEnquadramento['idArquivo']}");
        }

        $recursoEnquadramentoDbTable = new Recurso_Model_DbTable_TbRecursoProposta();
        $recursoEnquadramentoDbTable->update([
            'idArquivo' => new Zend_Db_Expr('NULL')
        ], [
            'idRecursoProposta = ?' => $recursoEnquadramento['idRecursoProposta'],
            'idPreProjeto = ?' => $recursoEnquadramento['idPreProjeto']
        ]);
        return $this->uploadArquivoSqlServer('arquivo');
    }

    /**
     * @todo Mover esse m&eacute;todo para o local correto.
     * @param string $upload_field_name
     * @param int $maxSizeFile
     * @return int|null $idArquivo
     */
    private function uploadArquivoSqlServer(
        $upload_field_name = 'arquivo',
        $maxSizeFile = 10485760
    )
    {
        $idArquivo = null;
        $file = new Zend_File_Transfer();
        if ($file->isUploaded()) {
            if (!empty($file->getFileInfo())) {

                $fileInformation = $file->getFileInfo();

                $arquivoNome = $fileInformation[$upload_field_name]['name'];
                $arquivoTemp = $fileInformation[$upload_field_name]['tmp_name'];
                $arquivoTamanho = $fileInformation[$upload_field_name]['size'];
                $arquivoHash = '';

                if (!empty($arquivoNome) && !empty($arquivoTemp)) {
                    $arquivoExtensao = Upload::getExtensao($arquivoNome);
                    $arquivoBinario = Upload::setBinario($arquivoTemp);
                    $arquivoHash = Upload::setHash($arquivoTemp);
                }

                if ($arquivoTamanho > $maxSizeFile) {
                    throw new Exception("O arquivo n&atilde;o pode ser maior do que 10MB!");
                }

                $auth = Zend_Auth::getInstance();
                $authIdentity = array_change_key_case((array)$auth->getIdentity());
                $tbArquivoDbTable = new tbArquivo();
                $dadosArquivo = [];
                $dadosArquivo['nmArquivo'] = $arquivoNome;
                $dadosArquivo['sgExtensao'] = $arquivoExtensao;
                $dadosArquivo['nrTamanho'] = $arquivoTamanho;
                $dadosArquivo['dtEnvio'] = $tbArquivoDbTable->getExpressionDate();
                $dadosArquivo['stAtivo'] = 'A';
                $dadosArquivo['dsHash'] = $arquivoHash;
                $dadosArquivo['idUsuario'] = $authIdentity['idusuario'];

                $idArquivo = $tbArquivoDbTable->insert($dadosArquivo);

                $tbArquivoImagemDAO = new tbArquivoImagem();
                $dadosBinario = array(
                    'idArquivo' => $idArquivo,
                    'biArquivo' => new Zend_Db_Expr("CONVERT(varbinary(MAX), {$arquivoBinario})")
                );
                $idArquivo = $tbArquivoImagemDAO->inserir($dadosBinario);
            }
        }
        return $idArquivo;
    }

    public function downloadAnexoProponente()
    {
        throw new Exception('Implementar esse método');
    }
}
