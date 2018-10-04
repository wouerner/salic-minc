<?php

class Navegacao_Model_Perfil extends MinC_Db_Model
{
    protected $gru_nome;

    public function __construct($params)
    {
        $this->gru_nome = $params['gru_nome'];
    }

    /**
     * @return int
     */
    public function getGruNome()
    {
        return $this->gru_nome;
    }

    /**
     * @param int $gru_nome
     */
    public function setGruNome($gru_nome)
    {
        $this->$gru_nome = $gru_nome;
    }
}
