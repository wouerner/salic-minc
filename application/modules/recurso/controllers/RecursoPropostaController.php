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

//xd($_FILES, $_POST, $_GET);

        $auth = Zend_Auth::getInstance();
        $authIdentity = array_change_key_case((array)$auth->getIdentity());
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
        $file = new Zend_File_Transfer();

        $recursoEnquadramentoDbTable = new Recurso_Model_DbTable_TbRecursoProposta();
        $recursoEnquadramento = $recursoEnquadramentoDbTable->obterRecursoAtualVisaoProponente($id_preprojeto);
        xd($recursoEnquadramento);

//        $model->setIdDocumento($model->getIdDocumento());
        if ($file->isUploaded()) {
            if (!empty($file->getFileInfo())) {

                $fileInformation = $file->getFileInfo();

                $arquivoNome = $fileInformation['arquivo']['name']; # nome
                $arquivoTemp = $fileInformation['arquivo']['tmp_name']; # nome temporario
                $arquivoTipo = $fileInformation['arquivo']['type']; # tipo
                $arquivoTamanho = $fileInformation['arquivo']['size']; # tamanho
                $arquivoHash = ''; # hash

                if (!empty($arquivoNome) && !empty($arquivoTemp)) {
                    $arquivoExtensao = Upload::getExtensao($arquivoNome); # extensao
                    $arquivoBinario = Upload::setBinario($arquivoTemp); # binario
                    $arquivoHash = Upload::setHash($arquivoTemp); # hash
                }

                $maxSizeFile = 10485760;

                if ($arquivoTamanho > $maxSizeFile) {
                    throw new Exception("O arquivo n&atilde;o pode ser maior do que 10MB!");
                }

                $tbArquivoDbTable = new tbArquivo();
                $dadosArquivo = [];
                $dadosArquivo['nmArquivo'] = $arquivoNome;
                $dadosArquivo['sgExtensao'] = $arquivoExtensao;
                $dadosArquivo['nrTamanho'] = $arquivoTamanho;
                $dadosArquivo['dtEnvio'] = $tbArquivoDbTable->getExpressionDate();
                $dadosArquivo['stAtivo'] = 'I';
                $dadosArquivo['dsHash'] = $arquivoHash;
                $dadosArquivo['idUsuario'] = $authIdentity['idusuario'];

                $idArquivo = $tbArquivoDbTable->insert($dadosArquivo);

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

            }
        }


        /**
         * @todo : Implementar :
         * - consulta pelo recurso, caso tenha idArquivo:
         *      * Atualizar registro do idArquivo da tabela tbRecursoProposta para null
         *      * Remover registro da tabela idArquivo
         */

//        if ($id = $this->save($model)) {
//            $booStatus = $id;
//            $this->setMessage($mensagemSucesso);
//        } else {
//            $this->setMessage('N&atilde;o foi poss&iacute;vel efetuar a opera&ccedil;&atilde;o!');
//        }

        ///
//        $authIdentity = array_change_key_case((array)$auth->getIdentity());
//        $objEnquadramento = new Admissibilidade_Model_Enquadramento();
//
//        $arrayArmazenamentoEnquadramento = [
//            'AnoProjeto' => $projeto['AnoProjeto'],
//            'Sequencial' => $projeto['Sequencial'],
//            'Enquadramento' => $post['enquadramento_projeto'],
//            'DtEnquadramento' => $objEnquadramento->getExpressionDate(),
//            'Observacao' => $tpSolicitacao,
//            'Logon' => $authIdentity['usu_codigo'],
//            'IdPRONAC' => $projeto['IdPRONAC']
//        ];
//
//        $objEnquadramento = new Admissibilidade_Model_Enquadramento();
//        $objEnquadramento->salvar($arrayArmazenamentoEnquadramento);
//
//        $projetos = new Projeto_Model_DbTable_Projetos();
//        $projetos->atualizarProjetoEnquadrado(
//            $projeto,
//            $authIdentity['usu_codigo']
//        );
//
//        parent::message(
//            'Enquadramento cadastrado com sucesso.',
//            '/admissibilidade/enquadramento/gerenciar-enquadramento',
//            'CONFIRM'
//        );
    }

    public function downloadAnexoProponente()
    {

    }
}
