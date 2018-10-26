<?php

use Application\Modules\AvaliacaoResultados\Service\Assinatura\Parecer\DocumentoAssinatura as DocumentoAssinaturaService;

class AvaliacaoResultados_AssinaturaController extends MinC_Controller_Rest_Abstract
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

    }

    public function getAction()
    {
        $idPronac = $this->getRequest()->getParam('idpronac');
        $idTipoDoAtoAdministrativo = $this->getRequest()->getParam('idtipodoatoadministrativo');


        $documentoEstado = new DocumentoAssinaturaService($idPronac, $idTipoDoAtoAdministrativo);

        $documento = $documentoEstado->consultarDocumento($idPronac, $idTipoDoAtoAdministrativo);

        $this->customRenderJsonResponse([$documento], 200);
    }

    public function headAction(){}

    public function postAction()
    {
        $idPronac = $this->getRequest()->getParam('idpronac');
        $idTipoDoAtoAdministrativo = $this->getRequest()->getParam('idtipodoatoadministrativo');

        $assinatura = new DocumentoAssinaturaService($idPronac, $idTipoDoAtoAdministrativo);
        $idDocumentoAssinatura = $assinatura->iniciarFluxo();

        $this->renderJsonResponse(
            [
                'idDocumentoAssinatura' => $idDocumentoAssinatura,
                'idPronac' =>  $idPronac,
                'idTipoDoAtoAdministrativo' =>  $idTipoDoAtoAdministrativo
            ],
            200
        );
    }

    public function putAction()
    {
    }

    public function deleteAction(){}
}
