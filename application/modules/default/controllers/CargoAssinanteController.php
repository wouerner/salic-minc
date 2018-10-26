<?php

class CargoAssinanteController extends Zend_Controller_Action
{
    public function incluirAction()
    {
        $mensagem = null;
        $tipo = 'ERROR';
        try {
            $cargoModel = new CargoAssinantePrestacaoDeConstasModel();
            $cargoModel
              ->setCargo($this->getRequest()->getParam('nomeCargo'))
              ->setJustificativa($this->getRequest()->getParam('cargoJustificativa'));
            $cargoModel->salvar();
            $tipo = 'CONFIRM';
            $mensagem = 'Cargo cadastrado com sucesso.';
        } catch (InvalidArgumentException $exception) {
            $mensagem = $exception->getMessage();
        } catch (InvalidArgumentException $exception) {
            $mensagem = 'N�o foi poss�vel cadastrar o cargo!';
        }
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->flashMessenger->addMessage($mensagem);
        $this->_helper->flashMessengerType->addMessage($tipo);
        $this->redirect("realizarprestacaodecontas/manter-assinantes?tipoFiltro={$this->getRequest()->getParam('tipoFiltro')}");
    }
}
