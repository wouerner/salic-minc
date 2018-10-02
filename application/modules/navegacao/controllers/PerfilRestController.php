<?php
//namespace Application\Modules\navegacao\controllers;

class Navegacao_PerfilRestController extends MinC_Controller_Rest_Abstract
{
    private $response;

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
        # Convertendo os objetos da sessao em array, transformando as chaves em minusculas.
        $auth = Zend_Auth::getInstance();
        $objIdentity = $auth->getIdentity();
        $arrAuth = array_change_key_case((array)$objIdentity);

        $objModelUsuario = new Autenticacao_Model_DbTable_Usuario(); // objeto usuario
        $UsuarioAtivo = new Zend_Session_Namespace('UsuarioAtivo'); // cria a sessao com o usuario ativo
        $GrupoAtivo = new Zend_Session_Namespace('GrupoAtivo'); // cria a sessao com o grupo ativo
        // somente autenticacao zend
        $perfisDisponiveis = [];
        $from = base64_encode($this->getRequest()->getRequestUri());
        if (0 == 0) {
            if ($auth->hasIdentity()) // caso o usuario esteja autenticado
            {

                // pega as unidades autorizadas, orgaos e grupos do usuario (pega todos os grupos)
                if (isset($objIdentity->usu_codigo) && !empty($arrAuth['usu_codigo'])) {
                    $grupos = $objModelUsuario->buscarUnidades($arrAuth['usu_codigo'], 21);
                    $objAgente = $objModelUsuario->getIdUsuario($arrAuth['usu_codigo']);
                    $idAgente = $objAgente['idagente'];
                    $cpfLogado = $objAgente['usu_identificacao'];
                } elseif (isset($objIdentity->auth) && isset($objIdentity->auth['uid'])) {

                    $this->tratarPerfilOAuth($objIdentity);
                } else {
                    return $this->_helper->redirector->goToRoute(array('controller' => 'index', 'action' => 'logout', 'module' => 'autenticacao', 'from' => $from), null, true);
                }

                // manda os dados para a visao
//                $this->view->idAgente = $idAgente;
//                $this->view->usuario = $objIdentity; // manda os dados do usuario para a visao
//                $this->view->arrayGrupos = $grupos; // manda todos os grupos do usuario para a visao
//                $this->view->grupoAtivo = $GrupoAtivo->codGrupo; // manda o grupo ativo do usuario para a vis?o
//                $this->view->orgaoAtivo = $GrupoAtivo->codOrgao; // manda o orgao ativo do usuario para a vis?o

                $perfisDisponiveis = $grupos->toArray();

//                return $perfisDisponiveis;
            } else {

                return $this->_helper->redirector->goToRoute(
                    array(
                        'controller' => 'index',
                        'action' => 'logout',
                        'module' => 'autenticacao',
                        'from' => $from
                    )
                    , null
                    , true
                );
            }
        }

        array_walk($perfisDisponiveis, function (&$value) {
            $value = array_map('utf8_encode', $value);
        });

//        xd($perfisDisponiveis);
        $this->renderJsonResponse($perfisDisponiveis, 200);
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
