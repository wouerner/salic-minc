<?php

class PrestacaoContas_ComprovantePagamentoController extends Zend_Rest_Controller
{
    public function init()
    {
        $this->_helper->getHelper('contextSwitch')
            ->addActionContext('index', 'json')
            ->addActionContext('post', 'json')
            ->initContext('json');
    }

    public function headAction(){}

    public function indexAction()
    {
        $idPronac = $this->_request->getParam("idPronac");
        $idPlanilhaItem = $this->_request->getParam("idPlanilhaItem");
        $codigoProduto = $this->getRequest()->getParam('produto');
        $stItemAvaliado = $this->getRequest()->getParam('stItemAvaliado');

        $vwComprovacoes = new PrestacaoContas_Model_vwComprovacaoFinanceiraProjetoPorItemOrcamentario();
        $comprovantes = $vwComprovacoes->comprovacoes(
            $idPronac,
            $idPlanilhaItem,
            $stItemAvaliado,
            $codigoProduto
        );

        $data = [];

        foreach($comprovantes->toArray() as $key => $value){
            $data[] =  array_map('utf8_encode', $value);
        }

        $this->view->assign('data', $data);
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function getAction()
    {}

    public function postAction()
    {
        if (!$idPronac) {
            throw new Exception('Falta pronac');
        }

        /* $this->view->assign('data',['message' => 'Existe dilig&ecirc;ncia aguardando resposta!']); */
        /* $this->getResponse()->setHttpResponseCode(405); */

        /* $this->view->assign('data',['message' => 'criado!']); */
        /* $this->getResponse()->setHttpResponseCode(201); */

        $this->getRequest()->getParam('comprovantePagamento');
        foreach ($this->getRequest()->getParam('comprovantePagamento') as $comprovantePagamento) {
            try {
                $rsComprovantePag = $tblComprovantePag
                    ->buscar(
                        array(
                            'idComprovantePagamento = ?' => $comprovantePagamento['idComprovantePagamento'],
                        )
                    )
                    ->current();

                $rsComprovantePag->dtValidacao = date('Y/m/d H:i:s');
                $rsComprovantePag->dsJustificativa = isset($comprovantePagamento['observacao']) ? $comprovantePagamento['observacao'] : null;
                $rsComprovantePag->stItemAvaliado = $comprovantePagamento['situacao'];
                $rsComprovantePag->save();
                $itemValidado = true;
            } catch (Exception $e) {
                $this->_helper->flashMessenger->addMessage($e->getMessage());
                $this->_helper->flashMessengerType->addMessage('ERROR');
                $tblComprovantePag->getAdapter()->rollBack();
                $redirector->redirectAndExit();
            }
        }

    }

    public function putAction()
    {
         $this->getResponse()->setHttpResponseCode(400);
    }

    public function deleteAction()
    {}
}
