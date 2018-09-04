<?php

/* use Application\Modules\AvaliacaoResultados\Service\ParecerTecnico\Encaminhamento as EncaminhamentoService; */

class AvaliacaoResultados_EstadoController extends MinC_Controller_Rest_Abstract
{
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $profiles = [
            Autenticacao_Model_Grupos::TECNICO_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_GERAL_PRESTACAO_DE_CONTAS,
        ];

        $permissionsPerMethod  = [
            /* '*' => [], */
//            'index' => $profiles,
//            'post' => $profiles
        ];
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }

    public function init()
    {
        $this->events = new Zend_EventManager_EventManager();

        $this->events->attach('teste',  function ($e) {
        });

        parent::init();
    }

    public function indexAction()
    {
        $estados = new AvaliacaoResultados_Model_DbTable_Estados();
        $estados = $estados->all();
        $this->customRenderJsonResponse($estados->toArray(), 200);
    }

    public function getAction()
    {
        $id = $this->getRequest()->getParam('id');

        $estado = new  AvaliacaoResultados_Model_DbTable_Estados();

        $estado = $estado->findBy($id);
        $estado['proximo'] = json_decode($estado['proximo']);

        $this->renderJsonResponse($estado, 200);
    }

    public function headAction(){}

    public function postAction()
    {
        $atual = $this->getRequest()->getParam('atual');
        $proximoEstado = $this->getRequest()->getParam('proximo');
        $params = $this->getRequest()->getParams();

        $estado = new  AvaliacaoResultados_Model_DbTable_Estados();
        $estado = $estado->findBy($atual);
        $proximo = json_decode($estado['proximo']);

        if (!in_array($proximoEstado, $proximo->proximo)) {
            throw new Exception('Esse fluxo não pode ser executado!');
        }

        include(APPLICATION_PATH . $proximo->path);

        $eventClass = new $proximo->class();

        $function = $proximo->function;
        $eventClass->$function($params);

        $this->renderJsonResponse(['post'], 200);
    }

    public function putAction()
    {
        $this->customRenderJsonResponse(['t1111 11este'], 200);

        $this->events->trigger('teste');
    }

    public function deleteAction(){}

    public function postDispatch() {
        /* die('teste'); */
    }
}
