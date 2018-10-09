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
        $result = $this->montaPerfis($perfis);

        return $this->utf8Encode($result);
    }


    private function montaPerfis($perfis)
    {
        $result = [];

        foreach ($perfis as $perfil) {
            $current_object = [];
            $current_object['usu_orgao'] = $perfil->getUsuOrgao();
            $current_object['usu_orgao_lotacao'] = $perfil->getUsuOrgaoLotacao();
            $current_object['uog_orgao'] = $perfil->getUogOrgao();
            $current_object['orgao_sigla_autorizada'] = $perfil->getOrgaoSiglaAutorizada();
            $current_object['org_nome_autorizado'] = $perfil->getOrgNomeAutorizado();
            $current_object['gru_codigo'] = $perfil->getGruCodigo();
            $current_object['nome_grupo'] = $perfil->getNomeGrupo();
            $current_object['org_superior'] = $perfil->getOrgSuperior();
            $current_object['uog_status'] = $perfil->getUogStatus();
            $current_object['id_unico'] = $perfil->getIdUnico();

            array_push($result, $current_object);
        }

        return $result;
    }

    private function utf8Encode($perfis) {
        array_walk($perfis, function (&$value) {
            $value = array_map('utf8_encode', $value);
        });

        return $perfis;
    }
}
