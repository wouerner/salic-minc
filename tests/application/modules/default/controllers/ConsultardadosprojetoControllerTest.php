<?php
/**
 * Projeto_ConsultardadosprojetoController
 *
 * @package
 * @author ShinNin-Chan <ananji.costa@gmail.com>
 */
class ConsultardadosprojetoControllerTest extends MinC_Test_ControllerActionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->idPronac = '209649';

        $this->hashIdPronac = "501eac548e7d4fa987034573abc6e179MjAxNzEzZUA3NWVmUiEzNDUwb3RT";
        
        $this->autenticar();
        
        $this->resetRequest()
            ->resetResponse();
        
        $this->alterarPerfil(Autenticacao_Model_Grupos::COORDENADOR_ANALISE, Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI);
        
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
        $this->dispatch('/consultardadosprojeto?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'index');
    }

    /**
     * TestIndexAction
     *
     * @access public
     * @return void
     */
    public function testIndexActionHash()
    {
        
        $this->dispatch('/consultardadosprojeto?idPronac=' . $this->hashIdPronac);
        $this->assertUrl('default','consultardadosprojeto', 'index');
    }
    
    
    /**
     * TestCertidoesNegativasAction
     *
     * @access public
     * @return void
     */
    public function testCertidoesNegativasAction()
    {
        $this->dispatch('/consultardadosprojeto/certidoes-negativas?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'certidoes-negativas');
    }

    /**
     * TestCertidoesNegativasAction
     *
     * @access public
     * @return void
     */
    public function testCertidoesNegativasActionHash()
    {
        $this->dispatch('/consultardadosprojeto/certidoes-negativas?idPronac=' . $this->hashIdPronac);
        $this->assertUrl('default','consultardadosprojeto', 'certidoes-negativas');
    }    

    /**
     * TestDadosComplementaresAction
     *
     * @access public
     * @return void
     */
    public function testDadosComplementaresAction()
    {
        $this->dispatch('/consultardadosprojeto/dados-complementares?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'dados-complementares');
    }

    /**
     * TestDadosComplementaresAction
     *
     * @access public
     * @return void
     */
    public function testDadosComplementaresActionHash()
    {
        $this->dispatch('/consultardadosprojeto/dados-complementares?idPronac=' . $this->hashIdPronac);
        $this->assertUrl('default','consultardadosprojeto', 'dados-complementares');
    }    
    
    /**
     * TestDocumentosAnexadosAction
     *
     * @access public
     * @return void
     */
    public function testDocumentosAnexadosAction()
    {
        $this->dispatch('/consultardadosprojeto/documentos-anexados?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'documentos-anexados');
    }

    /**
     * TestDiligenciasAction
     *
     * @access public
     * @return void
     */
    public function testDiligenciasAction()
    {
        $this->dispatch('/consultardadosprojeto/diligencias?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'diligencias');
    }

    /**
     * TestLocalRealizacaoDeslocamentoAction
     *
     * @access public
     * @return void
     */
    public function testLocalRealizacaoDeslocamentoAction()
    {
        $this->dispatch('/consultardadosprojeto/local-realizacao-deslocamento?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'local-realizacao-deslocamento');
    }

    /**
     * TestPlanoDeDivulgacaoAction
     *
     * @access public
     * @return void
     */
    public function testPlanoDeDivulgacaoAction()
    {
        $this->dispatch('/consultardadosprojeto/plano-de-divulgacao?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'plano-de-divulgacao');
    }

    /**
     * TestTramitacaoDocumentoAction
     *
     * @access public
     * @return void
     */
    public function testTramitacaoDocumentoAction()
    {
        $this->dispatch('/consultardadosprojeto/tramitacao-documento?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'tramitacao-documento');
    }

    /**
     * TestHistoricoEncaminhamentoAction
     *
     * @access public
     * @return void
     */
    public function testHistoricoEncaminhamentoAction()
    {
        $this->dispatch('/consultardadosprojeto/historico-encaminhamento?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'historico-encaminhamento');
    }

   /**
     * TestAnaliseProjetoAction
     *
     * @access public
     * @return void
     */
    public function testAnaliseProjetoAction()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(
                array(
                    'idPronac' => $this->idPronac,
                    'tipoAnalise' => 'inicial'
                )
            );
        
        $this->dispatch('/consultardadosprojeto/analise-projeto');
        $this->assertUrl('default','consultardadosprojeto', 'analise-projeto');
    }

   /**
     * TestAnaliseParecerTecnicoConsolidadoAction
     *
     * @access public
     * @return void
     */
    public function testAnaliseParecerTecnicoConsolidadoAction()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(
                array(
                    'idPronac' => $this->idPronac,
                    'tipoAnalise' => 'inicial'
                )
            );
        
        $this->dispatch('/consultardadosprojeto/analise-parecer-tecnico-consolidado');
        $this->assertUrl('default','consultardadosprojeto', 'analise-parecer-tecnico-consolidado');
    }

   /**
     * TestAnaliseDeConteudoAction
     *
     * @access public
     * @return void
     */
    public function testAnaliseDeConteudoAction()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(
                array(
                    'idPronac' => $this->idPronac,
                    'tipoAnalise' => 'inicial'
                )
            );
        
        $this->dispatch('/consultardadosprojeto/analise-de-conteudo');
        $this->assertUrl('default','consultardadosprojeto', 'analise-de-conteudo');
    }

  /**
     * TestAprovacaoAction
     *
     * @access public
     * @return void
     */
    public function testAprovacaoAction()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(
                array(
                    'idPronac' => $this->idPronac
                )
            );
        
        $this->dispatch('/consultardadosprojeto/aprovacao');
        $this->assertUrl('default','consultardadosprojeto', 'aprovacao');
    }

    /**
     * TestRecursoAction
     *
     * @access public
     * @return void
     */
    public function testRecursoActionPOST()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(
                array(
                    'idPronac' => $this->idPronac
                )
            );
        
        $this->dispatch('/consultardadosprojeto/recurso');
        $this->assertUrl('default','consultardadosprojeto', 'recurso');
    }

    /**
     * TestRecursoAction
     *
     * @access public
     * @return void
     */
    public function testRecursoActionGET()
    {
        $this->dispatch('/consultardadosprojeto/recurso?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'recurso');
    }

    /**
     * TestDadosBancariosAction
     *
     * @access public
     * @return void
     */
    public function testDadosBancariosAction()
    {
        $this->dispatch('/consultardadosprojeto/dados-bancarios?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'dados-bancarios');
    }

    /**
     * TestDadosBancariosLiberacaoAction
     *
     * @access public
     * @return void
     */
    public function testDadosBancariosLiberacaoAction()
    {
        $this->dispatch('/consultardadosprojeto/dados-bancarios-liberacao?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'dados-bancarios-liberacao');
    }

    /**
     * TestDadosBancariosCaptacaoAction
     *
     * @access public
     * @return void
     */
    public function testDadosBancariosCaptacaoAction()
    {
        $this->dispatch('/consultardadosprojeto/dados-bancarios-captacao?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'dados-bancarios-captacao');
    }    

    /**
     * TestExtratosBancariosCaptacaoAction
     *
     * @access public
     * @return void
     */
    public function testExtratosBancariosCaptacaoAction()
    {
        $this->dispatch('/consultardadosprojeto/extratos-bancarios?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'extratos-bancarios');
    }

    /**
     * TestExtratoDeSaldoBancarioAction
     *
     * @access public
     * @return void
     */
    public function testExtratoDeSaldoBancarioAction()
    {
        $this->dispatch('/consultardadosprojeto/extrato-de-saldo-bancario-consolidado?idPronac=' . $this->idPronac);
        $this->assertUrl('default','consultardadosprojeto', 'extrato-de-saldo-bancario-consolidado');
    }
}