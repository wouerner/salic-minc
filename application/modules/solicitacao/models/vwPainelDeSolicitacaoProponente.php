<?php

class Solicitacao_Model_vwPainelDeSolicitacaoProponente extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name = 'vwPainelDeSolicitacaoProponente';
    protected $_primary = 'idSolicitacao';

    public function contarSolicitacoesNaoLidasUsuario($idUsuario, $idAgente)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('vw' => $this->_name),
            array(
                'count(idSolicitacao)'
            ),
            $this->_schema
        );

        $select->where('stLeitura = ?', 0);
        $select->where('dtResposta IS NOT NULL');
        $select->where("idAgente = {$idAgente} OR idSolicitante = {$idUsuario}");

        $db = Zend_Db_Table::getDefaultAdapter();
        return $db->fetchOne($select);
    }

    public function contarSolicitacoesNaoRespondidasTecnico($idTecnico, $idOrgao)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('vw' => $this->_name),
            array(
                'count(idSolicitacao)'
            ),
            $this->_schema
        );

        $select->where('idTecnico = ?', $idTecnico);
        $select->where('idOrgao = ?', $idOrgao);
        $select->where('dtResposta is null', '');
        $select->where('siEncaminhamento = ?', Solicitacao_Model_TbSolicitacao::SOLICITACAO_ENCAMINHADA);

        $db = Zend_Db_Table::getDefaultAdapter();
        return $db->fetchOne($select);
    }
}