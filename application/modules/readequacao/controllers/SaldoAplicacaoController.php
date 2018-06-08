<?php

class Readequacao_SaldoAplicacaoController extends Readequacao_GenericController 
{
    public function init()
    {
        parent::init();
        
        $idPronac = $this->_request->getParam('idPronac');
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }
        $this->idPronac = $idPronac;
        $this->view->idTipoReadequacao = Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_SALDO_APLICACAO;
        $this->view->idPronac = $idPronac;
    }

    public function indexAction()
    {
        $this->view->projeto = $this->projeto;
    }

    public function criarSolicicacaoAction()
    {
        
    }

    public function salvarReadequacaoAction()
    {
        $dados = $this->getRequest()->getPost();

        try {
            
            if ($this->idPerfil != Autenticacao_Model_Grupos::PROPONENTE) {
                throw new Exception("Acesso negado!");
            }
            
            $dados['idTipoReadequacao'] = Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_SALDO_APLICACAO;
            $dados['stAtendimento'] = 'D';
            $dados['idDocumento'] = null;
            $dados['dsJustificativa'] = $dados['justificativa'];
            
            $readequacaoMapper = new Readequacao_Model_TbReadequacaoMapper();
            $dados = $readequacaoMapper->salvarSolicitacaoReadequacao($dados);

            $this->_helper->json(array('readequacao' => $dados, 'success' => 'true', 'msg' => 'Readequa&ccedil;&atilde;o salva com sucesso!'));
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(412);
            $this->_helper->json(array('data' => $dados, 'success' => 'false', 'msg' => $e->getMessage()));
        }
    }    
}