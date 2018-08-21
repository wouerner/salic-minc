<?php

use Application\Modules\AvaliacaoResultados\Service\ParecerTecnico\ParecerTecnico as ParecerTecnico;

class AvaliacaoResultados_FinalizarAvaliacaoFinanceiraRestController extends MinC_Controller_Rest_Abstract
{

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $profiles = [
            Autenticacao_Model_Grupos::TECNICO_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_GERAL_PRESTACAO_DE_CONTAS,
            parent::COD_ORGAO_PROPONENTE
        ];

        $permissionsPerMethod  = [
            'index' => $profiles,
            'post' => $profiles
        ];
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }


    public function indexAction()
    {
        $this->getAction();
    }

    public function getAction()
    {
        $resposta = ['asdasd'];
        $this->renderJsonResponse($resposta, 200);
    }

    public function headAction()
    {
    }

    public function postAction()
    {

    }

    public function putAction()
    {

    }

    public function deleteAction()
    {

    }
}
