<?php

use Application\Modules\Navegacao\Service\Perfil\Perfil as PerfilService;

class Navegacao_PerfilRestController extends MinC_Controller_Rest_Abstract
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
        $perfilService = new PerfilService($this->getRequest(), $this->getResponse());
        $perfisDisponoveis = $perfilService->buscarPerfisDisponoveis();
        $usuarioAtivo = new Zend_Session_Namespace('UsuarioAtivo');
        $grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');

        $resposta = [];
        $resposta['perfisDisponoveis'] = $perfisDisponoveis;
        $resposta['usuarioAtivo'] = $usuarioAtivo;
        $resposta['grupoAtivo'] = $grupoAtivo;

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
