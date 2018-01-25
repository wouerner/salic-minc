<?php

class Admissibilidade_Model_DbTable_SugestaoEnquadramento extends MinC_Db_Table_Abstract
{
    protected $_name = "sugestao_enquadramento";
    protected $_schema = "sac";
    protected $_primary = "id_sugestao_enquadramento";

    public function obterHistoricoEnquadramento($id_preprojeto)
    {
        return $this->findAll(['id_preprojeto' => $id_preprojeto]);
    }

    public function isPropostaEnquadrada($id_preprojeto, $id_orgao, $id_perfil_usuario)
    {
        $resultado = $this->findAll(
            [
                'id_preprojeto' => $id_preprojeto,
                'id_orgao' => $id_orgao,
                'id_perfil_usuario' => $id_perfil_usuario
            ]
        );
        if (count($resultado) > 0) {
            return true;
        }
    }
}