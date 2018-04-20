<?php

/**
 * AgentesControllerTest
 *
 * @author wouerner <woeurner@gmail.como>
 */
class AgentesControllerTest extends MinC_Test_ControllerActionTestCase
{

    /**
     * TestIncluiragente Acesso a tela de incluir agente
     *
     * @access public
     * @return void
     */
    public function testIncluiragente()
    {
        $this->autenticar();

        //reset para garantir respostas.
        $this->resetRequest()
            ->resetResponse();

        $this->perfilParaProponente();

        //reset para garantir respostas.
        $this->resetRequest()
            ->resetResponse();

        $this->dispatch('agente/agentes/incluiragente?menuLateral=false&acao=prop');
        $this->assertModule('agente');
        $this->assertController('agentes');
        $this->assertAction('incluiragente');
    }
    public function setUp()
    {
        parent::setUp();
        $this->idPronac = '209649';

        $this->hashIdPronac = "501eac548e7d4fa987034573abc6e179MjAxNzEzZUA3NWVmUiEzNDUwb3RT";

        $this->autenticar();

        $this->resetRequest()
            ->resetResponse();

        $this->alterarPerfil(Autenticacao_Model_Grupos::COMPONENTE_COMISSAO, Orgaos::ORGAO_SUPERIOR_SAV);

        $this->resetRequest()
            ->resetResponse();
    }

    public function testagentesAction()
    {
        $this->dispatch('/agente/agentes/agentes');
        $this->assertUrl('agente', 'agentes', 'agentes');
    }

    public function testenderecosAction()
    {
        $this->alterarPerfil(Autenticacao_Model_Grupos::COMPONENTE_COMISSAO, Orgaos::ORGAO_SUPERIOR_SAV);
        $this->dispatch('/agente/agentes/enderecos');
        $this->assertUrl('agente', 'agentes', 'enderecos');
    }

    public function testemailsAction()
    {
        $this->dispatch('/agente/agentes/emails');
        $this->assertUrl('agente', 'agentes', 'emails');
    }

    public function testinfoAdicionaisAction()
    {
        $this->dispatch('/agente/agentes/info-adicionais');
        $this->assertUrl('agente', 'agentes', 'info-adicionais');
    }

    public function testincluiragenteAction()
    {
        $this->alterarPerfil(Autenticacao_Model_Grupos::GESTOR_SALIC, Orgaos::ORGAO_SUPERIOR_SEFIC);
        $this->dispatch('/agente/agentes/incluiragente');
        $this->assertUrl('agente', 'agentes', 'incluiragente');
    }

    public function testbuscaragenteAction()
    {
        $this->alterarPerfil(Autenticacao_Model_Grupos::GESTOR_SALIC, Orgaos::ORGAO_SUPERIOR_SEFIC);
        $this->dispatch('/agente/agentes/buscaragente');
        $this->assertUrl('agente', 'agentes', 'buscaragente');
    }
}
