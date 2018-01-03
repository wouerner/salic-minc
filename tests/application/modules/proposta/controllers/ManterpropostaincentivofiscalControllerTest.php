<?php

/**
 * ManterpropostaincentivofiscalControllerTest
 *
 * @author  wouerner <wouerner@gmail.com>
 */
class ManterpropostaincentivofiscalControllerTest extends MinC_Test_ControllerActionTestCase
{
     public function setUp()
     {
        parent::setUp();

        $this->idPreProjeto = '240102';
        $this->autenticar();

        //reset para garantir respostas.
        $this->resetRequest()
            ->resetResponse();

        // trocar para perfil Proponente
        $this->perfilParaProponente();

        //reset para garantir respostas.
        $this->resetRequest()
            ->resetResponse();
     }
    /**
     * TestListarpropostaAction Verifica acesso a tela.
     *
     * @access public
     * @return void
     */
    public function testListarpropostaAction()
    {
        $this->dispatch('/proposta/manterpropostaincentivofiscal/listarproposta');
        $this->assertModule('proposta');
        $this->assertController('manterpropostaincentivofiscal');
        $this->assertAction('listarproposta');

        //verifica se tela carregou corretamente
        $this->assertQuery('div.container-fluid div');
    }

    public function testIdentificacaodapropostaAction()
    {
        $this->dispatch('/proposta/manterpropostaincentivofiscal/identificacaodaproposta' . '/idPreProjeto/240102');
        $this->assertModule('proposta');
        $this->assertController('manterpropostaincentivofiscal');
        $this->assertAction('identificacaodaproposta');
    }

    public function testResponsabilidadesocialAction() 
    {
        $this->dispatch('/proposta/manterpropostaincentivofiscal/responsabilidadesocial' . '/idPreProjeto/' . $this->idPreProjeto);
        $this->assertUrl('proposta','manterpropostaincentivofiscal', 'responsabilidadesocial');
    }

    public function testDetalhestecnicosAction() 
    {
        $this->dispatch('/proposta/manterpropostaincentivofiscal/detalhestecnicos' . '/idPreProjeto/' . $this->idPreProjeto);
        $this->assertUrl('proposta','manterpropostaincentivofiscal', 'detalhestecnicos');
    }

    public function testVerificaPermissaoAcessoProposta(){}
    public function testIndexAction(){}
    public function testDeclaracaonovapropostaAction(){}
    public function testBuscaproponenteAction(){}
    public function testValidaagenciaAction(){}
    public function testSalvarAction(){}
    public function testCarregaProposta(){}
    public function testEditarAction(){}

    public function testOutrasinformacoesAction()
    {
        $this->dispatch('/proposta/manterpropostaincentivofiscal/outrasinformacoes' . '/idPreProjeto/' . $this->idPreProjeto);
        $this->assertUrl('proposta','manterpropostaincentivofiscal', 'outrasinformacoes');
    }

    public function testEncaminharprojetoaomincAction(){}
    public function testExcluirAction(){}
    public function testEnviarPropostaAction(){}
    public function testValidarEnvioPropostaComSp(){}
    public function testValidarEnvioPropostaSemSp(){}
    public function testConfirmarEnvioPropostaAoMincAction(){}
    public function testValidaDatasAction(){}
    public function testListarPropostasAjaxAction(){}
    public function testConsultarresponsaveisAction(){}
    public function testVincularpropostasAction(){}
    public function testVincularprojetosAction(){}
    public function testNovoresponsavelAction(){}
    public function testRespnovoresponsavelAction(){}
    public function testAtualizarDadosPessoaJuridicaVerificandoCNAECultural(){}
}
