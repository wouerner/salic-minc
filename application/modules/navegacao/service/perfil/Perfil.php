<?php

namespace Application\Modules\Navegacao\Service\Perfil;

class Perfil
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarPerfisDisponoveis()
    {
        # Convertendo os objetos da sessao em array, transformando as chaves em minusculas.
        $auth = \Zend_Auth::getInstance();
        $objIdentity = $auth->getIdentity();
        $arrAuth = array_change_key_case((array)$objIdentity);

        $objModelUsuario = new \Autenticacao_Model_DbTable_Usuario(); // objeto usuario
//        $UsuarioAtivo = new \Zend_Session_Namespace('UsuarioAtivo'); // cria a sessao com o usuario ativo
//        $GrupoAtivo = new \Zend_Session_Namespace('GrupoAtivo'); // cria a sessao com o grupo ativo

        $grupos = $objModelUsuario->buscarUnidades($arrAuth['usu_codigo'], 21)->toArray();
//        $objAgente = $objModelUsuario->getIdUsuario($arrAuth['usu_codigo']);
//        $idAgente = $objAgente['idagente'];
//        $cpfLogado = $objAgente['usu_identificacao'];

        array_walk($grupos, function (&$value) {
            $value = array_map('utf8_encode', $value);
        });

        return $grupos;
    }
}
