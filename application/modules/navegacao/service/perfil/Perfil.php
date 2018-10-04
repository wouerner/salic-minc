<?php

namespace Application\Modules\Navegacao\Service\Perfil;

class Perfil
{
    private $request;

    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarPerfisDisponoveis()
    {
        $auth = \Zend_Auth::getInstance();
        $objIdentity = $auth->getIdentity();
        $arrAuth = array_change_key_case((array)$objIdentity);

        $objModelUsuario = new \Navegacao_Model_PerfilMapper();
        $grupos = $objModelUsuario->buscarPerfisDisponiveis($arrAuth['usu_codigo'], 21);

        return array_map('utf8_encode', $grupos);
    }
}
