<?php

use Application\Modules\Readequacao\Service\Readequacao as ReadequacaoService;

class Readequacao_DadosReadequacaoController extends MinC_Controller_Rest_Abstract
{

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $profiles = [
            // Autenticacao_Model_Grupos::PROPONENTE,
            // Autenticacao_Model_Grupos::TECNICO_ACOMPANHAMENTO,
            // Autenticacao_Model_Grupos::COORDENADOR_ACOMPANHAMENTO,
            // Autenticacao_Model_Grupos::COORDENADOR_GERAL_ACOMPANHAMENTO,
        ];

        $permissionsPerMethod  = [
        ];
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);
        print_r($request);
        parent::__construct($request, $response, $invokeArgs);
    }

    public function getAction() {
        $idPronac = $this->getRequest()->getParam('idPronac');
        $idReadequacao = $this->getRequest()->getParam('idReadequacao');
        $data = [];
        $code = 200;
        
        $data['idPronac'] = $idPronac;
        $data['idReadequacao'] = $idReadequacao;
        $data['texto'] = 'agojaeogh aiughaeuigh aeuihg euiahgiuaeh giuah gi';
            
        //        $data = \TratarArray::utf8EncodeArray($data);
        
        $this->renderJsonResponse($data, $code);
    }

    public function indexAction(){}

    public function headAction(){}

    public function postAction(){}

    public function putAction(){}

    public function deleteAction(){}

}
