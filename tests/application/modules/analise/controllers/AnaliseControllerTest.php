<?php

class AnaliseControllerTest extends MinC_Test_ControllerActionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->idPreProjeto = $this->getIdPreProjeto();
        $this->autenticar();

        $this->resetRequest()
            ->resetResponse();

        $this->alterarPerfil(Autenticacao_Model_Grupos::COORDENADOR_ANALISE, Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI);

        $this->resetRequest()
            ->resetResponse();
    }
    private function getIdPreProjeto()
    {
        $projetos = new Projetos();
        $select = $projetos->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('p' => 'PreProjeto'),
            'p.idPreProjeto AS idPreProjeto',
            'sac.dbo'
        );

        $select->joinInner(
            array('a' => 'Agentes'),
            'a.idAgente = p.idAgente',
            array(''),
            'agentes.dbo'
        );

        $select->where('p.stEstado = ?', 1);
        $select->limit(1);

        $result = $projetos->fetchAll($select);
        if (count($result) > 0)
        {
            return $result[0]['idPreProjeto'];
        } else {
            return false;
        }
    }

    public function testAnaliseListarprojetosAction()
    {
        $this->dispatch('/analise/analise/listarprojetos');
        $this->assertUrl('analise', 'analise', 'listarprojetos');
    }

    public function testAnaliseListarProjetosAjaxAction()
    {
        $this->dispatch('/analise/analise/listar-projetos-ajax');
        $this->assertUrl('analise', 'analise', 'listar-projetos-ajax');
    }

    public function testAnaliseRedistribuiranaliseitemAction()
    {
        $this->dispatch('/analise/analise/redistribuiranaliseitem');
        $this->assertUrl('analise', 'analise', 'redistribuiranaliseitem');
    }

//    public function testAnaliseRedistribuiranaliseitemComboTecnicoAction()
//    {
//        $this->dispatch('/analise/analise/redistribuiranaliseitem?idpronac=209649');
//        $this->assertUrl('analise', 'analise', 'redistribuiranaliseitem');
//        $this->assertQueryCountMin('form#frmRedistAnalise select.select_simples option', 2);
//    }

    public function testAnaliseVizualizarProjetosAction()
    {
        $this->dispatch('/analise/analise/visualizarprojeto?idpronac=' . $this->idPreProjeto);
        $this->assertUrl('analise','analise', 'visualizarprojeto');
    }
}