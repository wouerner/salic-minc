<?php
/**
 * ReadequacoesControllerTest
 *
 * @package
 * @author
 */
class ReadequacoesControllerTest extends MinC_Test_ControllerActionTestCase
{
    public function setUp()
    {
        parent::setUp();

        // Marcado para refatoração futura
        // * fixture do banco de dados com dados controlados
        $this->idPronac = '209649';
        $this->hashPronac = '501eac548e7d4fa987034573abc6e179MjA4OTQ3ZUA3NWVmUiEzNDUwb3RT';
        
        $this->autenticar();
        
        $this->resetRequest()
            ->resetResponse();
        
        $this->perfilParaProponente();
        
        $this->resetRequest()
            ->resetResponse();
        
    }

    /**
     * TestIndexAction
     *
     * @access public
     * @return void
     */    
    public function testIndexAction()
    {
        $this->dispatch('/readequacoes?idPronac=' . $this->hashPronac);
        $this->assertUrl('default','readequacoes', 'index');
    }

    /**
     * TestIndexIdUfAction
     *
     * @access public
     * @return void
     */    
    public function testIndexIdUfAction()
    {
        $iduf = 43; // RS
        
        $this->request->setMethod('POST')
            ->setPost([
                'iduf' => $iduf
            ]);        
        $this->dispatch('/readequacoes?idPronac=' . $this->hashPronac);
        //        $this->assertEquals();
    }
    
    /**
     * TestPlanilhaOrcamentariaAction
     *
     * @access public
     * @return void
     */    
    public function testPlanilhaOrcamentariaAction()
    {
        $this->dispatch('/readequacoes/planilha-orcamentaria?idPronac=' . $this->hashPronac);
        $this->assertUrl('default','readequacoes', 'planilha-orcamentaria');
    }

    /**
     * TestPlanilhaOrcamentariaCondicoesNaoSatisfeitas()
     *
     * @access public
     * @return void
     */    
    public function testPlanilhaOrcamentariaCondicoesNaoSatisfeitas()
    {
        // puxar um projetos com condições não satisfeitos
        // verificar que não consegue acessar página de readequação de planilha
        
        /* Condições para realizar uma readequação de planilha orçamentária
         
         Regras
         - NÃO POSSUIR ((readequação OU remanejamento 50%) E (em andamento)))
         - POSSUIR (conta liberada)
         - POSSUIR (período de execução vigente))
         
         Ação
         - ACESSAR url

        */
        $idPronac = 206025;
        $tbReadequacao = new tbReadequacao();
        $possuiReadequacao = $tbReadequacao->existeReadequacaoEmAndamento($idPronac);
        
        $this->assertTrue($possuiReadequacao);

    }
    
}