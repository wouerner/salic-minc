<?php

class Navegacao_Model_PerfilMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
    }

    public function buscarPerfisDisponiveis($usu_codigo, $sis_codigo)
    {
        $tbPerfil = new \Navegacao_Model_DbTable_TbPerfil();
        $result = $tbPerfil->buscarPerfisDisponiveis($usu_codigo, $sis_codigo);

        return $result;
    }

    public function getIdUsuario($usu_codigo)
    {
        $tbPerfil = new \Navegacao_Model_DbTable_TbPerfil();
        $queryResult = $tbPerfil->getIdUsuario($usu_codigo);

        return $queryResult;
    }
}
