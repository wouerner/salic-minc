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

    public function dadosReadequacaoAction()
    {
        $this->_helper->layout->disableLayout();
        $idReadequacao = $this->_request->getParam('idReadequacao');

        $tbReadequacao = new Readequacao_Model_DbTable_TbReadequacao();
        $readequacao = $tbReadequacao->obterReadequacaoTransferenciaRecursos($idReadequacao, $idPronac);
        
        if (empty($readequacao)) {
            $mensagem = 'Nenhuma readequa&ccedil;&atilde;o para o idPronac ' . $this->idPronac;
        }
        
        $this->_helper->json(
            [
                'readequacao' => $readequacao,
                'mensagem' => $mensagem
            ]
        );        
    }
    
    public function dadosProjetoTransferidorAction()
    {
        $this->_helper->layout->disableLayout();

        $mensagem = '';
        $projetos = new Projetos();

        try {
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
        } catch (Exception $objException) {
            $this->_helper->json([
                'mensagem' => 'Houve um erro na consulta do projeto transferidor.',
                'error' => $objException->getMessage()
            ]);
        }
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

            $readequacao = $tbReadequacao->obterReadequacaoTransferenciaRecursos($idReadequacao);
            
            if (count($readequacao) > 0) {
                $this->_helper->json(
                    [
                        'readequacao' => $readequacao,
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

    public function listarProjetosRecebedoresDisponiveisAction()
    {
        $this->_helper->layout->disableLayout();
        $this->view->arrResult = [];
    }
    
    public function listarProjetosRecebedoresAction()
    {
        $this->_helper->layout->disableLayout();
        $this->view->arrResult = [];
        
        $idReadequacao = $this->_request->getParam('idReadequacao');
        $TbSolicitacaoTransferenciaRecursos = new Readequacao_Model_DbTable_TbSolicitacaoTransferenciaRecursos();
        
        try {
            $projetosRecebedores = $TbSolicitacaoTransferenciaRecursos->obterProjetosRecebedores($idReadequacao);
            
            if (count($projetosRecebedores) > 0) {
                $projetosRecebedores = [
                    'idPronacRecebedor' => $projetosRecebedores->idPronacRecebedor,
                    'nome' => utf8_encode($projeto->NomeProjeto),
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
        } catch (Exception $objException) {
            $this->_helper->json([
                'mensagem' => 'Houve um erro na consulta do projeto transferidor.',
                'error' => $objException->getMessage()
            ]);
        }
    }

    public function incluirProjetoRecebedorAction()
    {
        $this->_helper->layout->disableLayout();

        $dados = [];        
        $Readequacao_Model_DbTable_TbSolicitacaoTransferenciaRecursos = new Readequacao_Model_DbTable_TbSolicitacaoTransferenciaRecursos();
        
        try {
            $dados['idReadequacao'] = $this->_request->getParam('idReadequacao');
            $dados['tpTransferencia'] = $this->_request->getParam('tipoTransferencia');            
            $dados['idPronacRecebedor'] = $this->_request->getParam('idPronacRecebedor');
            $dados['vlRecebido'] = (float) str_replace(',', '.', $this->_request->getParam('valorRecebido'));
            $dados['siAnaliseTecnica'] = '';
            $dados['siAnaliseComissao'] = '';
            $dados['stEstado'] = 0;
            
            $idSolicitacaoTransferenciaRecursos = $Readequacao_Model_DbTable_TbSolicitacaoTransferenciaRecursos->inserir($dados);
            
            $this->_helper->json(
                [
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