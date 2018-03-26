<?php

class Recurso_Model_DbTable_TbRecursoProposta extends MinC_Db_Table_Abstract
{
    protected $_schema = 'sac';
    protected $_name = 'tbRecursoProposta';

    public function inativarRecursos($id_preprojeto)
    {
        if (!is_null($id_preprojeto) && !empty($id_preprojeto)) {
            $this->alterar(
                array('stAtivo' => Recurso_Model_TbRecursoProposta::SITUACAO_RECURSO_INATIVO),
                ['idPreProjeto = ?' => $id_preprojeto]
            );
        }
    }

    public function cadastrarRecurso($idPreProjeto)
    {
        if (!$idPreProjeto) {
            throw new Exception("Identificador do projeto n&atilde;o informado.");
        }

        $preprojetoDbTable = new Proposta_Model_DbTable_PreProjeto();
        $arrPreprojeto = $preprojetoDbTable->findBy(['idPreProjeto' => $idPreProjeto]);
        $dados = [
            'idPreProjeto' => $idPreProjeto,
            'idProponente' => $arrPreprojeto['idAgente'],
            'dtRecursoProponente' => $this->getExpressionDate(),
            'stAtendimento' => Recurso_Model_TbRecursoProposta::SITUACAO_ATENDIMENTO_SEM_AVALIACAO,
            'stAtivo' => Recurso_Model_TbRecursoProposta::SITUACAO_RECURSO_ATIVO,
        ];

        $this->inativarRecursos($idPreProjeto);
        $this->inserir($dados);
    }

}
