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
        $this->assertUrl('assinatura','index', 'gerenciar-assinaturas');
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
        $this->assertUrl('assinatura','index', 'visualizar-assinaturas');
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
        $this->assertUrl('assinatura','index', 'visualizar-projeto');
    }
}
