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
//        $parametros = $this->request->getParams();
//        $acao = $this->identificaColuna($parametros['acao']);
//        $idPronac = $parametros['idPronac'];
//
//        $mapper = new \Readequacao_Model_TbTransferenciaRecursosEntreProjetosMapper();
//        $result = $mapper->obterTransferenciaRecursosEntreProjetos($idPronac, $acao);

        # Convertendo os objetos da sessao em array, transformando as chaves em minusculas.
        $auth = Zend_Auth::getInstance();
        $objIdentity = $auth->getIdentity();
        $arrAuth = array_change_key_case((array)$objIdentity);

        $objModelUsuario = new Autenticacao_Model_DbTable_Usuario(); // objeto usuario
        $UsuarioAtivo = new Zend_Session_Namespace('UsuarioAtivo'); // cria a sessao com o usuario ativo
        $GrupoAtivo = new Zend_Session_Namespace('GrupoAtivo'); // cria a sessao com o grupo ativo
//        xd('AAAAAAAAAA', $UsuarioAtivo, $GrupoAtivo->codGrupo, $GrupoAtivo->codOrgao, $objIdentity, $idAgente);

        // somente autenticacao zend
        $resposta = [];
        $from = base64_encode($this->getRequest()->getRequestUri());
        if (0 == 0) {


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
//                $this->view->idAgente = $idAgente;
//                $this->view->usuario = $objIdentity; // manda os dados do usuario para a visao
//                $this->view->arrayGrupos = $grupos; // manda todos os grupos do usuario para a visao
//                $this->view->grupoAtivo = $GrupoAtivo->codGrupo; // manda o grupo ativo do usuario para a vis?o
//                $this->view->orgaoAtivo = $GrupoAtivo->codOrgao; // manda o orgao ativo do usuario para a vis?o

            $resposta = $grupos->toArray();
        }

        array_walk($resposta, function (&$value) {
            $value = array_map('utf8_encode', $value);
        });

        return $resposta;
    }
}
