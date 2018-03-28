<?php

class Recurso_RecursoPropostaController extends Proposta_GenericController
{
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        throw new Exception("Implementar");
    }

    public function visaoProponenteAction() {


        $sugestaoEnquadramentoDbTable = new Admissibilidade_Model_DbTable_SugestaoEnquadramento();
        $sugestaoEnquadramentoDbTable->sugestaoEnquadramento->setIdPreprojeto($this->idPreProjeto);
        $this->view->recursoEnquadramento = $sugestaoEnquadramentoDbTable->obterRecursoEnquadramentoProposta();
    }
}
