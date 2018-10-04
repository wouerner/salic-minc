<?php

class Navegacao_Model_Perfil extends MinC_Db_Model
{
    private $orgao_sigla_autorizada;
    private $nome_grupo;

    public function __construct($params)
    {
        $this->nome_grupo = $params['gru_nome'];
        $this->orgao_sigla_autorizada = $params['org_siglaautorizado'];
    }

    public function getOrgaoSiglaAutorizada()
    {
        return $this->orgao_sigla_autorizada;
    }

    public function setOrgaoSiglaAutorizada($orgao_sigla_autorizada)
    {
        $this->orgao_sigla_autorizada = $orgao_sigla_autorizada;
    }

    public function getNomeGrupo()
    {
        return $this->nome_grupo;
    }

    public function setNomeGrupo($nome_grupo)
    {
        $this->$nome_grupo = $nome_grupo;
    }
}
