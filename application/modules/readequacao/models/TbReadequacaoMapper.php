<?php

class Readequacao_Model_TbReadequacaoMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Readequacao_Model_DbTable_TbReadequacao');
    }

    public function save($model)
    {
        return parent::save($model);
    }

    public function salvarSolicitacaoReadequacao($arrData) {

        try {
            $auth = Zend_Auth::getInstance();
            $tblAgente = new Agente_Model_DbTable_Agentes();
            $rsAgente = $tblAgente->buscar(array('CNPJCPF=?' => $auth->getIdentity()->Cpf))->current();

            $dados = array();
            $dados['idPronac'] = $arrData['idPronac'];
            $dados['idTipoReadequacao'] = $arrData['idTipoReadequacao'];
            $dados['dtSolicitacao'] = new Zend_Db_Expr('GETDATE()');
            $dados['idSolicitante'] = $rsAgente->idAgente;
            $dados['dsJustificativa'] = $arrData['descJustificativa'];
            $dados['dsSolicitacao'] = $arrData['descSolicitacao'];
            $dados['idDocumento'] = $arrData['idDocumento'];
            $dados['stAtendimento'] = 'N';
            $dados['siEncaminhamento'] = Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_CADASTRADA_PROPONENTE;
            $dados['stEstado'] = 0;

            $id = $this->save(new Readequacao_Model_TbReadequacao($dados));
            if($this->getMessage()) {
                throw new Exception($this->getMessage());
            }

            return $id;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
