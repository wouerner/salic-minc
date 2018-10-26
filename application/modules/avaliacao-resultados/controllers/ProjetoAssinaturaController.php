<?php

use Application\Modules\AvaliacaoResultados\Service\Fluxo\FluxoProjetoAssinatura as FluxoProjetoAssinaturaService;

class AvaliacaoResultados_ProjetoAssinaturaController extends MinC_Controller_Rest_Abstract
{
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $profiles = [
            Autenticacao_Model_Grupos::TECNICO_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_GERAL_PRESTACAO_DE_CONTAS,
        ];

        $permissionsPerMethod  = [];
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }

    public function indexAction()
    {
        $projetosAssinaturaService = new FluxoProjetoAssinaturaService($this->getRequest(), $this->getResponse());
        $projetos = $projetosAssinaturaService->projetosAguardandoAssinatura();

        $this->renderJsonResponse(\TratarArray::utf8EncodeArray($projetos->toArray()), 200);
    }

    public function getAction(){}

    public function headAction(){}

    public function postAction(){}

    public function putAction(){}

    public function deleteAction(){}
}
