<?php

namespace Application\Modules\Perfil\Service\Perfil;

class Perfil
{
    private $request;
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function alterarPerfil()
    {
        xd('service');
//        $auth = \Zend_Auth::getInstance();
//        $objIdentity = $auth->getIdentity();
//        $arrAuth = array_change_key_case((array)$objIdentity);
//
//        $objModelUsuario = new \Navegacao_Model_PerfilMapper();
//        $perfis = $objModelUsuario->buscarPerfisDisponiveis($arrAuth['usu_codigo'], 21);
//
//        $grupo_orgao = $this->montaPerfis($perfis);
//
//        return array_map('utf8_encode', $grupo_orgao);
    }
}
