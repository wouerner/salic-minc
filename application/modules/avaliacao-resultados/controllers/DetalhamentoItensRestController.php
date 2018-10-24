<?php
// use Application\Modules\AvaliacaoResultados\Service\TipoAvaliacao as TipoAvaliacao;

class AvaliacaoResultados_DetalhamentoItensRestController extends MinC_Controller_Rest_Abstract
{
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $permissionsPerMethod  = ['*'];

        $this->setValidateUserIsLogged();
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }

    public function indexAction()
    {
        xd('AAAAAAAAAAAAAAAA');
        $this->renderJsonResponse([], 200);
    }

    public function getAction()
    {

        $this->renderJsonResponse([],200);
    }

    public function headAction()
    {
        $this->renderJsonResponse([],200);
    }

    public function postAction()
    {
        $this->renderJsonResponse([],200);
    }

    public function putAction()
    {
        $this->renderJsonResponse([],200);
    }

    public function deleteAction()
    {
        $this->renderJsonResponse([],204);
    }
}
