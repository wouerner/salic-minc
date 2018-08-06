<?php

class Readequacao_IndexController extends Projeto_GenericController
{
    public function init()
    {
        parent::init();
        $this->validarPerfis();
    }

    private function validarPerfis()
    {
        $auth = Zend_Auth::getInstance();

        $PermissoesGrupo = array();
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::PROPONENTE;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::TECNICO_ACOMPANHAMENTO;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::COORDENADOR_ACOMPANHAMENTO;
        $PermissoesGrupo[] = Autenticacao_Model_Grupos::COORDENADOR_GERAL_ACOMPANHAMENTO;
    }
    
    private function carregarScripts()
    {
        $gitTag = '?v=' . $this->view->gitTag();
        $this->view->headScript()->offsetSetFile(99, '/public/dist/js/manifest.js' . $gitTag, 'text/javascript', array('charset' => 'utf-8'));
        $this->view->headScript()->offsetSetFile(100, '/public/dist/js/vendor.js' . $gitTag, 'text/javascript', array('charset' => 'utf-8'));
        $this->view->headScript()->offsetSetFile(101, '/public/dist/js/readequacao.js'. $gitTag, 'text/javascript', array('charset' => 'utf-8'));
    }

    public function indexAction()
    {
        $this->carregarScripts();
    }

}
