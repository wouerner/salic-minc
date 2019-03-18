<?php

namespace Application\Modules\Documento\Service\Documento;

use MinC\Servico\IServicoRestZend;

class Documento implements IServicoRestZend
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    private $acceptedTypes;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function inserir(
        array $params,
        array $acceptedTypes
    ) {
        $this->acceptedTypes = $acceptedTypes;

        $this->acceptedTypes = [
            'pdf' => [
                'pdf' => 'application/pdf',
            ],
            'images' => [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' =>  'image/png',
            ],
        ];
        
        $tbArquivoDAO = new \tbArquivo();
        $tbArquivoImagemDAO = new \tbArquivoImagem();
        $tbDocumentoDAO = new \tbDocumento();
        
        list($arquivoNome, $arquivoTemp, $arquivoTipo, $arquivoErro, $arquivoTamanho) = $params;
        
        $idDocumento = null;
        if (!empty($arquivoTemp)) {
            $arquivoExtensao = \Upload::getExtensao($arquivoNome);
            $arquivoBinario = \Upload::setBinario($arquivoTemp);
            $arquivoHash = \Upload::setHash($arquivoTemp);
            
            if ($arquivoExtensao != 'pdf' && $arquivoExtensao != 'PDF') {
                throw new Exception('A extens&atilde;o do arquivo &eacute; inv&aacute;lida, envie somente arquivos <strong>.pdf</strong>!');
            } elseif ($arquivoTamanho > 5242880) { // tamanho máximo do arquivo: 5MB
                throw new Exception('O arquivo n&atilde;o pode ser maior do que <strong>5MB</strong>!');
            }

            $dadosArquivo = [
                'nmArquivo' => $arquivoNome,
                'sgExtensao' => $arquivoExtensao,
                'dsTipoPadronizado' => $arquivoTipo,
                'nrTamanho' => $arquivoTamanho,
                'dtEnvio' => new Zend_Db_Expr('GETDATE()'),
                'dsHash' => $arquivoHash,
                'stAtivo' => 'A'
            ];
            $idArquivo = $tbArquivoDAO->inserir($dadosArquivo);

            // ==================== Insere na Tabela tbArquivoImagem ===============================
            $dadosBinario = [
                'idArquivo' => $idArquivo,
                'biArquivo' => new Zend_Db_Expr("CONVERT(varbinary(MAX), {$arquivoBinario})")
            ];
            $idArquivo = $tbArquivoImagemDAO->inserir($dadosBinario);

            // TODO especifico / abstrair
            $dados = [
                'idTipoDocumento' => 38,
                'idArquivo' => $idArquivo,
                'dsDocumento' => 'Solicitação de Readequação',
                'dtEmissaoDocumento' => null,
                'dtValidadeDocumento' => null,
                'idTipoEventoOrigem' => null,
                'nmTitulo' => 'Readequacao'
            ];

            $documento = $tbDocumentoDAO->inserir($dados);

            return $documento['idDocumento'];
        }
    }
}
