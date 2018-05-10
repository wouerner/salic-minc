<?php

class Readequacao_TransferenciaRecursosController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        parent::init();
        
        $idPronac = $this->_request->getParam('idPronac');
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }
        $this->idPronac = $idPronac;
        $this->view->idTipoReadequacao = Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_TRANSFERENCIA_RECURSOS;
        $this->view->idPronac = $idPronac;
    }

    public function indexAction()
    {
        $this->view->projeto = $this->projeto;
    }

    private function obterReadequacao($idReadequacao = '', $idPronac = '')
    {
        $mensagem = '';
        $readequacaoArray = [];
        
        $tbReadequacao = new Readequacao_Model_DbTable_TbReadequacao();

        $where = [
                'a.idTipoReadequacao = ?' => Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_TRANSFERENCIA_RECURSOS,
                'a.stEstado = ?' => Readequacao_Model_DbTable_TbReadequacao::ST_ESTADO_EM_ANDAMENTO
        ];

        if ($idPronac) {
            $where['a.idPronac = ?'] = $idPronac;
        }
        if ($idReadequacao) {
            $where['a.idReadequacao = ?'] = $idReadequacao;   
        }
        
        $readequacao = $tbReadequacao->readequacoesCadastradasProponente($where);
        
        if (count($readequacao) > 0) {
            $readequacaoArray = [
                'idReadequacao' => $readequacao[0]['idReadequacao'],
                'idPronac' => $readequacao[0]['idPronac'],
                'idTipoReadequacao' => $readequacao[0]['idTipoReadequacao'],
                'tipoTransferencia' => $readequacao[0]['dsSolicitacao'],
                'justificativa' => $readequacao[0]['dsJustificativa'],
                'idArquivo' => $readequacao[0]['idArquivo'],
                'nomeArquivo' => $readequacao[0]['nmArquivo']                
            ];
        } else {
            $mensagem = 'Nenhuma readequa&ccedil;&atilde;o para o idPronac ' . $this->idPronac;
        }
        
        return [
            'readequacao' => $readequacaoArray,
            'mensagem' => $mensagem
        ];
    }
    
    public function dadosReadequacaoAction()
    {
        $this->_helper->layout->disableLayout();
        $idReadequacao = $this->_request->getParam('idReadequacao');
        
        $retorno = $this->obterReadequacao($idReadequacao, $idPronac);
        
        $this->_helper->json(
            $retorno
        );        
    }
    
    public function dadosProjetoTransferidorAction()
    {
        $this->_helper->layout->disableLayout();

        $mensagem = '';
        $projetos = new Projetos();
        $projeto = $projetos->buscarPorPronac($this->idPronac);
        
        if (count($projeto) > 0) {
            $projetoArr = [
                'pronac' => $projeto->Pronac,
                'idPronac' => $projeto->IdPRONAC,
                'nomeProjeto' => utf8_encode($projeto->NomeProjeto),
                'valorComprovar' => $projeto->ValorCaptado - $projeto->ValorAprovado, ## receber de 
                'saldoDisponivel' => $projeto->ValorCaptado - $projeto->ValorAprovado
            ];
        } else {
            $projetoArr = [];
            $mensagem = "Não existe nenhum projeto com o idPronac forncedido!";
        }
        
        $this->_helper->json(
            [
                'projeto' => $projetoArr,
                'mensagem' => $mensagem
            ]
        );
    }
    
    public function salvarReadequacaoAction()
    {
        $this->_helper->layout->disableLayout();

        $mensagem = '';
        $dados = [];
        
        $idReadequacao = $this->_request->getParam('idReadequacao');
        
        $Readequacao_Model_DbTable_TbReadequacao = new Readequacao_Model_DbTable_TbReadequacao();
        
        if (!$idReadequacao || $idReadequacao == '') {
            $auth = Zend_Auth::getInstance();        
            $tblAgente = new Agente_Model_DbTable_Agentes();
            $rsAgente = $tblAgente->buscar(array('CNPJCPF=?'=>$auth->getIdentity()->Cpf))->current();
            
            $dados['idPronac'] = $this->_request->getParam('idPronac');
            $dados['idTipoReadequacao'] = Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_TRANSFERENCIA_RECURSOS;
            $dados['dtSolicitacao'] = new Zend_Db_Expr('GETDATE()');
            $dados['idSolicitante'] = $rsAgente->idAgente;
            $dados['dsJustificativa'] = $this->_request->getParam('justificativa');
            $dados['dsSolicitacao'] = $this->_request->getParam('tipoTransferencia');
            $dados['stAtendimento'] = 'D';
            $dados['idDocumento'] = null;
            $dados['siEncaminhamento'] = Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_CADASTRADA_PROPONENTE;
            $dados['stEstado'] = Readequacao_Model_DbTable_TbReadequacao::ST_ESTADO_EM_ANDAMENTO;
        
            try {
                $idReadequacao = $Readequacao_Model_DbTable_TbReadequacao->inserir($dados);
                
                $this->_helper->json(
                    [
                        'readequacao' => [
                            'idReadequacao' => $idReadequacao,
                            'justificativa' => $this->_request->getParam('justificativa'),
                            'tipoTransferencia' => $this->_request->getParam('tipoTransferencia'),
                        ],
                        'mensagem' => 'Readequação inserida com sucesso.'
                    ]
                );
                
            } catch (Exception $objException) {            
                $this->_helper->json([
                    'mensagem' => 'Houve um erro na criação do registro de tbReadequacao',
                    'error' => $objException->getMessage()
                ]);
                $this->_helper->viewRenderer->setNoRender(true);
            }
            
        } else if ($idReadequacao) {
            $dados['dsJustificativa'] = $this->_request->getParam('justificativa');
            $dados['dsSolicitacao'] = $this->_request->getParam('tipoTransferencia');
            
            try {
                $update = $Readequacao_Model_DbTable_TbReadequacao->update(
                    $dados,
                    [
                        'idReadequacao = ?' => $idReadequacao
                    ]
                );
                
                $this->_helper->json(
                    [
                        'readequacao' => [
                            'idReadequacao' => $idReadequacao,
                            'justificativa' => $this->_request->getParam('justificativa'),
                            'tipoTransferencia' => $this->_request->getParam('tipoTransferencia'),
                        ],
                        'mensagem' => 'Readequação atualizada com sucesso.'
                    ]
                );
                
            } catch (Exception $objException) {            
                $this->_helper->json([
                    'mensagem' => 'Houve um erro na atualização do registro de tbReadequacao',
                    'error' => $objException->getMessage()
                ]);
                $this->_helper->viewRenderer->setNoRender(true);
            }            
        }        
    }
    
    public function uploadReadequacaoAction()
    {
        $this->_helper->layout->disableLayout();
        
        $mensagem = '';
        $dados = [];
        $idReadequacao = $this->_request->getParam('idreadequacao');
        $Readequacao_Model_DbTable_TbReadequacao = new Readequacao_Model_DbTable_TbReadequacao();
        
        try {
            $Readequacao_Model_DbTable_TbReadequacao = new Readequacao_Model_DbTable_TbReadequacao();
            $dados['idDocumento'] = $Readequacao_Model_DbTable_TbReadequacao->insereArquivo();
            
            $update = $Readequacao_Model_DbTable_TbReadequacao->update(
                $dados,
                [
                    'idReadequacao = ?' => $idReadequacao
                ]
            );

            $readequacao = $this->obterReadequacao($idReadequacao);
            
            if (count($readequacao) > 0) {
                $this->_helper->json(
                    [
                        'readequacao' => $readequacao['readequacao'],
                        'mensagem' => 'Readequação atualizada com sucesso.'
                    ]
                );
            }            
        } catch (Exception $objException) {
            $this->_helper->json([
                'mensagem' => 'Houve um erro ao subir o arquivo da readequação.',
                'error' => $objException->getMessage()
            ]);
            $this->_helper->viewRenderer->setNoRender(true);
        }
    }
    
    public function listarProjetosRecebedoresAction()
    {
        $this->_helper->layout->disableLayout();
        
        $this->view->arrResult = [];        
    }

    public function incluirProjetoRecebedorAction()
    {
        
    }
    
    public function excluirProjetoRecebedorAction()
    {
        
    }
    
    public function finalizarSolicitacaoTransferenciaRecursosAction()
    {
        try {
            $tbReadequacao = new Readequacao_Model_DbTable_TbReadequacao();

            // inclui
            
            $this->_helper->json(
                [
                    'readequacao' => $readequacao,
                    'resposta' => true
                ]
            );
        } catch (Exception $objException) {
            $this->_helper->json(
                [
                    'error ' => $objException->getMessage(),
                    'resposta' => false
                ]
            );
        }
    }
}