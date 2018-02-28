<?php

class AdmissibilidadeControllerTest extends MinC_Test_ControllerActionTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->idPreProjeto = 276034;

        $this->autenticar();

        $this->resetRequest()
            ->resetResponse();

        $this->alterarPerfil(Autenticacao_Model_Grupos::COORDENADOR_ADMISSIBILIDADE, Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI);

        $this->resetRequest()
            ->resetResponse();
    }


    public function testAdmissibilidadeAvaliacaoAction()
    {
        $this->dispatch('/admissibilidade/admissibilidade/listar-propostas');
        $this->assertUrl('admissibilidade', 'admissibilidade', 'listar-propostas');

        $this->assertQuery('div.container-fluid div');
    }

    public function testExibirpropostaculturalAction()
    {
        $this->dispatch('/admissibilidade/admissibilidade/exibirpropostacultural?idPreProjeto=' . $this->idPreProjeto);
        $this->assertUrl('admissibilidade', 'admissibilidade', 'exibirpropostacultural');

        $this->assertQuery('div .exibir-proposta-cultural');
    }

    public function testAlterarunidadedeanalisepropostaAction()
    {
        $this->dispatch('/admissibilidade/admissibilidade/alterarunianalisepropostaconsulta');
        $this->assertUrl('admissibilidade', 'admissibilidade', 'alterarunianalisepropostaconsulta');

        $this->assertQuery('form table.tabela');
    }

    public function testMensagemAction()
    {
        $this->dispatch('/admissibilidade/mensagem' . '?idPronac=' . $this->idPronac);
        $this->assertUrl('admissibilidade', 'mensagem', 'index');
    }

    public function testDesarquivarPropostaAction()
    {
        $this->dispatch('/admissibilidade/admissibilidade/desarquivarpropostas');
        $this->assertUrl('admissibilidade', 'admissibilidade', 'desarquivarpropostas');
    }

    public function testRedistribuiranaliseAction()
    {
        $this->dispatch('/admissibilidade/admissibilidade/redistribuiranalise');
        $this->assertUrl('admissibilidade', 'admissibilidade', 'redistribuiranalise');
    }

    public function testGerenciaranalistasAction()
    {
        $this->dispatch('/admissibilidade/admissibilidade/gerenciaranalistas');
        $this->assertUrl('admissibilidade', 'admissibilidade', 'gerenciaranalistas');
    }

    public function testGerenciaranalistaAction()
    {
        $this->dispatch('/admissibilidade/admissibilidade/gerenciaranalista?usu_cod=6927&usu_orgao=262&gru_codigo=92');
        $this->assertUrl('admissibilidade', 'admissibilidade', 'gerenciaranalista');
    }
}
