<?php

class AvaliacaoResultados_AvaliacaoTecnicaRevisaoRestController extends MinC_Controller_Rest_Abstract
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


    public function indexAction()
{
    $this->customRenderJsonResponse([], 204);
}

    public function getAction()
{
    if (!isset($this->_request->idPronac)){
        $this->customRenderJsonResponse([], 422);
    }

    $revisaoService = new RevisaoAvaliacaoFinanceiraRevisao($this->getRequest(), $this->getResponse());

    $resposta = $revisaoService;
    $this->renderJsonResponse(\TratarArray::utf8EncodeArray($resposta), 200);
}

    public function headAction(){}

    public function postAction()
{
    $this->putAction();
}

    public function putAction()
{
    $revisaoService = new RevisaoAvaliacaoFinanceiraRevisao($this->getRequest(), $this->getResponse());
    $response = $revisaoService->salvar();
    $this->customRenderJsonResponse($response, 200);
}

    public function deleteAction(){}

}
