<?php

class SugestaoEnquadramentoTest extends MinC_Test_ModelActionTestCase
{
    public function testIsPropostaEnquadrada()
    {
        $sugestaoEnquadramentoDbTable = new Admissibilidade_Model_DbTable_SugestaoEnquadramento();
        $isPropostaEnquadrada = $sugestaoEnquadramentoDbTable->isPropostaEnquadrada(
            237487,
            171,
            92
        );
        $this->assertNotNull($isPropostaEnquadrada);
    }
}