<?php

namespace Application\Modules\DadosBancarios\Service\DepositoEquivocado;

class DepositoEquivocado
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarDepositosEquivocados()
    {
        $idPronac = $this->request->idPronac;
        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        # aportes
        $whereData = ['idPronac = ?' => $idPronac, 'nrLote = ?' => -1];
//        if ($this->getRequest()->getParam('dtDevolucaoInicio')) {
//            $whereData['dtLote >= ?'] = ConverteData($this->getRequest()->getParam('dtDevolucaoInicio'), 13);
//        }
//        if ($this->getRequest()->getParam('dtDevolucaoFim')) {
//            $whereData['dtLote <= ?'] = ConverteData($this->getRequest()->getParam('dtDevolucaoFim'), 13);
//        }
        $aporteModel = new \tbAporteCaptacao();
        $dados = $aporteModel->pesquisarDepositoEquivocado($whereData)->toArray();
//        $this->view->dataDevolucaoInicio = $this->getRequest()->getParam('dtDevolucaoInicio');
//        $this->view->dataDevolucaoFim = $this->getRequest()->getParam('dtDevolucaoFim');

        return $dados;
    }
}
