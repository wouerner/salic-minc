<?php

class tbProrrogacaoPrazo extends MinC_Db_Table_Abstract
{
    protected $_schema = "BDCORPORATIVO.scSAC";
    protected $_name   = "tbProrrogacaoPrazo";

    /**
     * M�todo para buscar os prazos de capta��o e execu��o com solicita��o de readequa��o
     * @access public
     * @param integer $idPronac
     * @param string $tpProrrogacao
     * @return object
     */
    public function buscarDados($idPronac = null, $tpProrrogacao = null, $idPedidoAlteracao = null)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array("p" => $this->_name),
            array("p.idPedidoAlteracao"
                ,"p.tpProrrogacao"
                  ,new Zend_Db_Expr("CONVERT(CHAR(10), p.dtInicioNovoPrazo,103) AS dtInicioNovoPrazo")
                  ,new Zend_Db_Expr("CONVERT(CHAR(10), p.dtFimNovoPrazo,103) AS dtFimNovoPrazo")),
            $this->_schema
        );
        $select->joinInner(
            array("ped" => "tbPedidoAlteracaoProjeto"),
            "p.idPedidoAlteracao = ped.idPedidoAlteracao",
            array(),
            $this->_schema
        );

        // busca pelo id do projeto
        if (!empty($idPronac)) {
            $select->where("ped.IdPRONAC = ?", $idPronac);
        }

        // busca pelo tipo de prazo
        if (!empty($tpProrrogacao)) {
            $select->where("p.tpProrrogacao = ?", $tpProrrogacao);
        }

        // busca pelo id do pedido
        if (!empty($idPedidoAlteracao)) {
            $select->where("p.idPedidoAlteracao = ?", $idPedidoAlteracao);
        }

        return $this->fetchAll($select);
    } // fecha m�todo buscarDados()



    /**
     * Busca o hist�rico de readequa��o
     * @access public
     * @param array $where (filtros)
     * @param array $order (ordena��o)
     * @return object
     */
    public function historicoReadequacao($where = array(), $order = array())
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('h' => $this->_name),
            array('h.idPedidoAlteracao'
                ,'h.tpProrrogacao'
                  ,new Zend_Db_Expr('CONVERT(CHAR(10), h.dtInicioNovoPrazo,103) AS dtInicioNovoPrazo')
                  ,new Zend_Db_Expr('CONVERT(CHAR(10), h.dtFimNovoPrazo,103) AS dtFimNovoPrazo'))
        );
        $select->joinInner(
            array('p' => 'tbPedidoAlteracaoProjeto'),
            'p.idPedidoAlteracao = h.idPedidoAlteracao',
            array(
                'p.idPedidoAlteracao'
                ,'p.idSolicitante'
                ,new Zend_Db_Expr('CONVERT(CHAR(10), p.dtSolicitacao, 103) AS dtSolicitacao')
                ,new Zend_Db_Expr('CONVERT(CHAR(10), p.dtSolicitacao, 108) AS hrSolicitacao')),
            'BDCORPORATIVO.scSAC'
        );
        $select->joinInner(
            array('j' => 'tbPedidoAlteracaoXTipoAlteracao'),
            'p.idPedidoAlteracao = j.idPedidoAlteracao',
            array(
                new Zend_Db_Expr('CAST(j.dsJustificativa AS TEXT) AS dsProponente')
                ,'j.tpAlteracaoProjeto'),
            'BDCORPORATIVO.scSAC'
        );
        $select->joinInner(
            array('a' => 'tbAvaliacaoItemPedidoAlteracao'),
            'p.idPedidoAlteracao = a.idPedidoAlteracao AND j.tpAlteracaoProjeto = a.tpAlteracaoProjeto',
            array(
                'a.idAgenteAvaliador'
                ,new Zend_Db_Expr('CONVERT(CHAR(10), a.dtInicioAvaliacao, 103) AS dtInicioAvaliacao')
                ,new Zend_Db_Expr('CONVERT(CHAR(10), a.dtInicioAvaliacao, 108) AS hrInicioAvaliacao')
                ,new Zend_Db_Expr('CONVERT(CHAR(10), a.dtFimAvaliacao, 103) AS dtFimAvaliacao')
                ,new Zend_Db_Expr('CONVERT(CHAR(10), a.dtFimAvaliacao, 108) AS hrFimAvaliacao')
                ,'a.stAvaliacaoItemPedidoAlteracao AS stAvaliacao'
                ,new Zend_Db_Expr('CAST(a.dsAvaliacao AS TEXT) AS dsAvaliacao')),
            'BDCORPORATIVO.scSAC'
        );

        // adiciona quantos filtros foram enviados
        foreach ($where as $coluna => $valor) :
            $select->where($coluna, $valor);
        endforeach;

        // adicionando linha order ao select
        $select->order($order);

        return $this->fetchAll($select);
    } // fecha m�todo historicoReadequacao()



    /**
     * M�todo para cadastrar
     * @access public
     * @param array $dados
     * @return integer (retorna o �ltimo id cadastrado)
     */
    public function cadastrarDados($dados)
    {
        return $this->insert($dados);
    } // fecha m�todo cadastrarDados()
} // fecha class
