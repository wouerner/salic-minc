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
        $perfis = $objModelUsuario->buscarPerfisDisponiveis($arrAuth['usu_codigo'], 21);

//        $objAgente = $objModelUsuario->getIdUsuario($arrAuth['usu_codigo']);
//        $idAgente = $objAgente['idagente'];
//        $cpfLogado = $objAgente['usu_identificacao'];

        $grupo_orgao = $this->montaPerfis($perfis);

        return array_map('utf8_encode', $grupo_orgao);
    }

    private function montaPerfis($perfis)
    {
        $result =[];

        foreach ($perfis as $perfil) {
            $nome_grupo = $perfil->getNomeGrupo();
            $orgao_sigla_autorizada = $perfil->getOrgaoSiglaAutorizada();
            $concatenacao_grupo_orgao = $orgao_sigla_autorizada . '' . $nome_grupo;
            array_push($result, $concatenacao_grupo_orgao);
        }

        return $result;
    }
}
