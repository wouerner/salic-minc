<?php

use Application\Modules\Perfil\Service\Perfil\Perfil as PerfilService1;

class Perfil_PerfilRestController extends MinC_Controller_Rest_Abstract
{
    public function __construct(
        Zend_Controller_Request_Abstract $request,
        Zend_Controller_Response_Abstract $response,
        array $invokeArgs = array())
    {
        $permissionsPerMethod  = ['*'];

        $this->setValidateUserIsLogged();
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }

    public function init()
    {
        $this->_helper->getHelper('contextSwitch')
            ->addActionContext('get', 'json')
            ->addActionContext('index', 'json')
            ->addActionContext('post', 'json')
            ->addActionContext('put', 'json')
            ->addActionContext('delete', 'json')
            ->initContext('json');
    }

    public function indexAction()
    {
        $perfilService = new PerfilService1($this->getRequest(), $this->getResponse());
        $resposta = $perfilService->alterarPerfil();

        $this->renderJsonResponse($resposta, 200);
    }

    public function getAction()
    {
        $this->renderJsonResponse(200);
    }

    public function headAction(){}

    public function postAction()
    {
        $this->renderJsonResponse(201);

    }

    public function putAction()
    {
        $this->renderJsonResponse(200);
    }

    public function deleteAction()
    {
        $this->getResponse()->setHttpResponseCode(204);
    }
}
