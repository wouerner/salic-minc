<?php

// use \Application\Modules\Proposta\Service\Proposta\Visualizar as VisualizarService;

class Solicitacao_MensagemRestController extends MinC_Controller_Rest_Abstract
{
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {

        $permissionsPerMethod  = ['*'];

        $this->setValidateUserIsLogged();
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }

    public function historicoSolicitacoesAction()
    {
        $idPreProjeto = $this->_request->getParam('idPreProjeto');
        $idPronac = $this->_request->getParam('idPronac');

        try {
            if (strlen($idPronac) > 7) {
                $idPronac = Seguranca::dencrypt($idPronac);
            }

            $where = [];
            if ($idPronac) {
                $where['a.idPronac = ?'] = (int) $idPronac;
            }

            if ($idPreProjeto) {
                $where['a.idProjeto = ?'] = (int) $idPreProjeto;
            }

            # Proponente
            if (isset($this->usuario['cpf'])) {
                $where["(a.idAgente = {$this->idAgente} OR a.idSolicitante = {$this->idUsuario})"] = '';
            }

            $obterSolicitacoes = new Solicitacao_Model_DbTable_TbSolicitacao();
            $solicitacoes = $obterSolicitacoes->obterSolicitacoes($where)->toArray();

            array_walk($solicitacoes, function (&$value) {
                $value = array_map('utf8_encode', $value);
            });

            $this->renderJsonResponse($solicitacoes, 200);
        } catch (Exception $e) {
            $this->renderJsonResponse($solicitacoes, 400);
        }
    }

    public function indexAction()
    {
        $this->renderJsonResponse(200);
    }

    public function getAction()
    {
        $this->renderJsonResponse(200);
    }

    public function headAction()
    {
        $this->renderJsonResponse(200);
    }

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
