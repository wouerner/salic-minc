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
        $UF = $this->getRequest()->getParam('uf');
        $idmunicipio = $this->getRequest()->getParam('idmunicipio');

        $vwComprovacoes = new PrestacaoContas_Model_vwComprovacaoFinanceiraProjetoPorItemOrcamentario();
        $comprovantes = $vwComprovacoes->comprovacoes(
            $idPronac,
            $idPlanilhaItem,
            $stItemAvaliado,
            $codigoProduto
        );

        $data = [];

        foreach($comprovantes->toArray() as $key => $value) {
            $data[] =  array_map('utf8_encode', $value);
        }

        $dataAux = [];
        foreach($data as $key => $value) {
            $dataAux[$key] = $value;
            $dataAux[$key]['tipo'] = $value['idTpDocumento'];
            $dataAux[$key]['numero'] = $value['nrComprovante'];
            $dataAux[$key]['serie'] = $value['nrSerie'];
            $dataAux[$key]['forma'] = $value['idTpFormaPagamento'];
            $dataAux[$key]['valor'] = $value['vlComprovacao'];
            $dataAux[$key]['justificativa'] = $value['dsJustificativa'];
            $dataAux[$key]['numeroDocumento'] = $value['nrDocumentoDePagamento'];
            $dataAux[$key]['fornecedor']['CNPJCPF'] = $value['CNPJCPF'];
            $dataAux[$key]['fornecedor']['nome'] = $value['nmFornecedor'];
            $dataAux[$key]['arquivo']['nome'] = $value['nmArquivo'];
            $dataAux[$key]['arquivo']['id'] = $value['idArquivo'];
        }
        /* var_dump($data); */
        /* die; */

        $this->view->assign('data', $dataAux);
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function getAction()
    {}

    public function postAction()
    {
        $idPronac = $this->getRequest()->getParam('idpronac');
        $observacao = $this->getRequest()->getParam('observacao');
        $situacao = $this->getRequest()->getParam('situacao');
        $idComprovantePagamento = $this->getRequest()->getParam('idcomprovantepagamento');

        if (!$idPronac) {
            throw new Exception('Falta pronac');
        }

        if (!$observacao) {
            throw new Exception('Falta observacao');
        }

        if (!$idComprovantePagamento) {
            throw new Exception('Falta Comprovante Pagamento');
        }

        $tblComprovantePag = new ComprovantePagamentoxPlanilhaAprovacao();
        $rsComprovantePag = $tblComprovantePag
            ->buscar( [ 'idComprovantePagamento = ?' => $idComprovantePagamento] )
            ->current();

        $rsComprovantePag->dtValidacao = date('Y/m/d H:i:s');
        $rsComprovantePag->dsJustificativa = $observacao;
        $rsComprovantePag->stItemAvaliado = $situacao;

        try {
            $rsComprovantePag->save();
            $this->view->assign('data',['message' => 'criado!']);
            $this->getResponse()->setHttpResponseCode(200);
        } catch (Exception $e) {
            $tblComprovantePag->getAdapter()->rollBack();
            $this->view->assign('data',['message' => $e->getMessage()]);
        }
    }

    public function putAction()
    {
         $this->getResponse()->setHttpResponseCode(400);
    }

    public function deleteAction()
    {}
}
