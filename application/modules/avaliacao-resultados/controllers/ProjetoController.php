<?php

class AvaliacaoResultados_ProjetoController extends MinC_Controller_Rest_Abstract
{

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $profiles = [
            // Autenticacao_Model_Grupos::TECNICO_PRESTACAO_DE_CONTAS,
            // Autenticacao_Model_Grupos::COORDENADOR_PRESTACAO_DE_CONTAS,
            // Autenticacao_Model_Grupos::COORDENADOR_GERAL_PRESTACAO_DE_CONTAS,
        ];

        $permissionsPerMethod  = [
        ];
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }

    public function getAction(){
        $idPronac = $this->getRequest()->getParam('idPronac');
        
        $planilhaAprovacaoModel = new PlanilhaAprovacao();
        $resposta = $planilhaAprovacaoModel->obterItensAprovados($idPronac);
        var_dump($resposta);
        die;

        $vlTotalComprovar = 0;
        $vlComprovado = 0;
        $vlAprovado = 0;
        foreach ($resposta as $item) {
            $vlComprovar = $item->vlAprovado - $item->vlComprovado;
            $vlTotalComprovar += $vlComprovar;

            $vlAprovado += $item->vlAprovado;
            $vlComprovado += $item->vlComprovado;

            $nomeProjeto = $item->NomeProjeto;
            $pronac = $item->Pronac;
        }

        $this->view->vlTotalComprovar = $vlTotalComprovar;
        $this->view->vlAprovado = $vlAprovado;
        $this->view->vlComprovado = $vlComprovado;
        $this->view->pronac = $pronac;
        $this->view->nomeProjeto = $nomeProjeto;

        $diligencia = new Diligencia();
        $this->view->existeDiligenciaAberta = $diligencia->existeDiligenciaAberta($idpronac);

        $fluxo = new FluxoProjetoService();
        $estado = $fluxo->estado($idpronac);
        $this->view->estado = $estado ? $estado->toArray() : null;

        $documento = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $documento = $documento->obterDocumentoAssinatura($idpronac, 622);

        $this->view->idDocumento = $documento['idDocumentoAssinatura'];
        $this->renderJsonResponse([$idPronac], 200);
    }

    public function indexAction(){}

    public function headAction(){}

    public function postAction(){}

    public function putAction(){}

    public function deleteAction(){}

}
