<?php

class AvaliacaoResultados_TipoLaudoController extends MinC_Controller_Rest_Abstract
{
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $profiles = [
            Autenticacao_Model_Grupos::TECNICO_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_GERAL_PRESTACAO_DE_CONTAS,
        ];

        $permissionsPerMethod  = [
//            'index' => $profiles,
//            'post' => $profiles
        ];
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }

    public function headAction()
    {
        $this->renderJsonResponse(["Nenhum conteúdo"], 204);
    }

    public function indexAction()
    {
        $laudoFinal = new AvaliacaoResultados_Model_DbTable_LaudoFinal();
        $laudoFinal = $laudoFinal->all();
        $this->customRenderJsonResponse($laudoFinal->toArray(), 200);
    }

    public function getAction()
    {
    }

    public function postAction()
    {
        // TODO: Implement postAction() method.
    }

    public function putAction()
    {
        // TODO: Implement putAction() method.
    }
    public function deleteAction()
    {
//        403 Proibido
        $this->customRenderJsonResponse(["Método não permitido"], 405);
    }

}
