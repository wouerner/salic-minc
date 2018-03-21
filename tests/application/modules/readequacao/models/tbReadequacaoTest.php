<?php
/**
 * Default_TbReadequacao
 *
 * @package
 */
class TbReadequacaoModelTest extends MinC_Test_ModelTestCase
{
    public function setUp()
    {
        parent::setUp();

        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $this->idPronac = $Readequacao_Model_tbReadequacao->buscarIdPronacReadequacaoEmAndamento(Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_PLANILHA_ORCAMENTARIA);
    }

    public function testExisteReadequacaoEmAndamento()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        
        $existeReadequacaoEmAndamento = $Readequacao_Model_tbReadequacao->existeReadequacaoEmAndamento($this->idPronac);
        $this->assertTrue($existeReadequacaoEmAndamento);
    }

    public function testExisteReadequacaoParcialEmAndamento()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        
        $existeReadequacaoEmAndamento = $Readequacao_Model_tbReadequacao->existeReadequacaoEmAndamento(
            $this->idPronac,
               Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL
        );
        
        $this->assertFalse($existeReadequacaoEmAndamento);
    }
    
    public function testExisteReadequacaoPlanilhaEmEdicao()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        
        $existeReadequacaoPlanilhaEmEdicao = $Readequacao_Model_tbReadequacao->existeReadequacaoPlanilhaEmEdicao($this->idPronac);
        
        $this->assertTrue($existeReadequacaoPlanilhaEmEdicao);
    }

    public function testExisteReadequacaoParcialEmEdicao()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        
        $existeReadequacaoParcialEmEdicao = $Readequacao_Model_tbReadequacao->existeReadequacaoParcialEmEdicao($this->idPronac);
        
        $this->assertFalse($existeReadequacaoParcialEmEdicao);
    }
    
    public function testExisteReadequacaoPlanilhaEmAndamento()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        
        $existeReadequacaoEmAndamento = $Readequacao_Model_tbReadequacao->existeReadequacaoEmAndamento(
            $this->idPronac,
               Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_PLANILHA_ORCAMENTARIA
        );
        
        $this->assertTrue($existeReadequacaoEmAndamento);
    }
    
    public function testDisponivelParaEdicaoReadequacaoPlanilha()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        
        $disponivelParaEdicaoReadequacaoPlanilha = $Readequacao_Model_tbReadequacao->disponivelParaEdicaoReadequacaoPlanilha($this->idPronac);
        $this->assertTrue($disponivelParaEdicaoReadequacaoPlanilha);
    }

    public function testDisponivelParaAdicaoItensReadequacaoPlanilha()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        
        $disponivelParaAdicaoItensReadequacaoPlanilha = $Readequacao_Model_tbReadequacao->disponivelParaAdicaoItensReadequacaoPlanilha($this->idPronac);
        $this->assertTrue($disponivelParaAdicaoItensReadequacaoPlanilha);
    }

    public function testBuscarIdReadequacaoAtiva()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $result = $Readequacao_Model_tbReadequacao->buscarIdReadequacaoAtiva($this->idPronac, Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_PLANILHA_ORCAMENTARIA);
        
        $this->assertNotEmpty($result);
    }

    public function testBuscarIdPronacReadequacaoEmAndamento()
    {
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $idPronac = $Readequacao_Model_tbReadequacao->buscarIdPronacReadequacaoEmAndamento(Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_PLANILHA_ORCAMENTARIA);
        
        $this->assertNotEmpty($idPronac);
    }
}