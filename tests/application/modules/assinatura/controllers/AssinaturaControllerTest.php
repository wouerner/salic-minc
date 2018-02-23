<?php

class AssinaturaControllerTest extends MinC_Test_ControllerActionTestCase
{

    /**
     * TestGerenciarAssinatura
     *
     * @access public
     * @return void
     */
    public function testGerenciarAssinaturas()
    {
        $this->autenticar();

        $this->alterarPerfil(Autenticacao_Model_Grupos::COORDENADOR_GERAL_ADMISSIBILIDADE, Orgaos::ORGAO_SEFIC_DIC);

        //reset para garantir respostas.
        $this->resetRequest()
            ->resetResponse();

        $this->dispatch('/assinatura/index/gerenciar-assinaturas');
        $this->assertModule('assinatura');
        $this->assertController('index');
        $this->assertAction('gerenciar-assinaturas');
    }

    /**
     * TestVisualizarAssinatura
     *
     * @access public
     * @return void
     */
    public function testVisualizarAssinaturas()
    {
        $this->autenticar();

        $this->alterarPerfil(Autenticacao_Model_Grupos::COORDENADOR_GERAL_ADMISSIBILIDADE, Orgaos::ORGAO_SEFIC_DIC);

        //reset para garantir respostas.
        $this->resetRequest()
            ->resetResponse();

        $this->dispatch('/assinatura/index/visualizar-assinaturas');
        $this->assertModule('assinatura');
        $this->assertController('index');
        $this->assertAction('visualizar-assinaturas');
    }

    /**
     * TestVisualizarProjeto
     *
     * @access public
     * @return void
     */
    public function testVisualizarProjeto()
    {
        $this->autenticar();

        $this->alterarPerfil(Autenticacao_Model_Grupos::COORDENADOR_GERAL_ADMISSIBILIDADE, Orgaos::ORGAO_SEFIC_DIC);

        //reset para garantir respostas.
        $this->resetRequest()
            ->resetResponse();

        $this->dispatch('/assinatura/index/visualizar-projeto?idDocumentoAssinatura=5842');
        $this->assertModule('assinatura');
        $this->assertController('index');
        $this->assertAction('visualizar-projeto');
    }
}
