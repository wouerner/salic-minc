<?php

use Application\Modules\AvaliacaoResultados\Service\ParecerTecnico\Encaminhamento as EncaminhamentoService;

class AvaliacaoResultados_HistoricoController extends MinC_Controller_Rest_Abstract
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
        $encaminhamentoService = new EncaminhamentoService($this->getRequest(), $this->getResponse());
        $resposta = $encaminhamentoService->buscarHistorico();

        $this->renderJsonResponse(\TratarArray::utf8EncodeArray($resposta), 200);
    }

    public function indexAction(){}

    public function headAction(){}

    public function postAction(){}

    public function putAction(){}

    public function deleteAction(){}

}
