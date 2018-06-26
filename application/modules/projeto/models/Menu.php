<?php

class Projeto_Model_Menu extends MinC_Db_Table_Abstract
{
    private $projeto;
    private $usuarioInterno;

    public function obterMenu($idPronac) {
        return $this->obterArrayMenuMecenato($idPronac);
    }

    public function liberarLink($idPronac)
    {
        $auth = Zend_Auth::getInstance();

        if (!isset($auth->getIdentity()->usu_codigo)) {
            $this->view->blnProponente = $this->blnProponente;

            $proj = new Projetos();
            $cpf = $proj->buscarProponenteProjeto($idPronac);
            $cpf = $cpf->CgcCpf;
            $idUsuarioLogado = $auth->getIdentity()->IdUsuario;

            $links = new fnLiberarLinks();
            $linksXpermissao = $links->links(2, $cpf, $idUsuarioLogado, $idPronac);

            $linksGeral = str_replace(' ', '', explode('-', $linksXpermissao->links));

            $arrayLinks = array(
                'Permissao' => $linksGeral[0],
                'FaseDoProjeto' => $linksGeral[1],
                'Diligencia' => $linksGeral[2],
                'Recursos' => $linksGeral[3],
                'Readequacao' => $linksGeral[4],
                'ComprovacaoFinanceira' => $linksGeral[5],
                'RelatorioTrimestral' => $linksGeral[6],
                'RelatorioFinal' => $linksGeral[7],
                'Analise' => $linksGeral[8],
                'Execucao' => $linksGeral[9],
                'PrestacaoContas' => $linksGeral[10],
                'Readequacao_50' => $linksGeral[11],
                'Marcas' => $linksGeral[12],
                'SolicitarProrrogacao' => $linksGeral[13],
                'ReadequacaoPlanilha' => $linksGeral[14],
                'ReadequacaoTransferenciaRecursos' => $linksGeral[15]
            );
            $this->view->fnLiberarLinks = $arrayLinks;
            $projetos = new Projeto_Model_DbTable_Projetos();
            $this->view->isAdequarARealidade = $projetos->fnChecarLiberacaoDaAdequacaoDoProjeto($idPronac);
        }
    }

    public function obterArrayMenuConvenio($idPronac)
    {
        $idPronacHash = Seguranca::encrypt($idPronac);

        $menu = [];
        $menu['dadosprojeto'] = array(
            'id' => 'dadosdoprojeto',
            'label' => 'Dados básicos',
            'title' => '',
            'link' => '/projeto/convenio/visualizar/idPronac/' . $idPronacHash,
            'ajax' => false,
            'icon' => 'home',
            'submenu' => '',
            'grupo' => []
        );

        $menu['proponente'] = array(
            'id' => 'proponente',
            'label' => 'Proponente',
            'title' => '',
            'link' => '/default/consultardadosprojeto/dados-proponente/idPronac/' . $idPronacHash,
            'ajax' => true,
            'icon' => 'person',
            'submenu' => '',
            'grupo' => []
        );

        return $menu;
    }

    public function obterArrayMenuMecenato($idPronac)
    {
        $idPronacHash = Seguranca::encrypt($idPronac);

        $menu = [];
        $menu['dadosprojeto'] = [
            'id' => 'dadosdoprojeto',
            'label' => 'Dados básicos',
            'title' => '',
            'link' => '/projeto/convenio/visualizar/idPronac/' . $idPronacHash,
            'ajax' => false,
            'icon' => 'home',
            'submenu' => '',
            'grupo' => []
        ];

        $menu['proponente'] = [
            'id' => 'proponente',
            'label' => 'Proponente',
            'title' => '',
            'link' => '/default/consultardadosprojeto/dados-proponente/idPronac/' . $idPronacHash,
            'ajax' => true,
            'icon' => 'person',
            'submenu' => '',
            'grupo' => []
        ];

        $menu['outrasinformacoes'] = [
            'id' => 'outrasinformacoes',
            'label' => 'Outras Informações',
            'title' => 'Outras Informações',
            'link' => '',
            'ajax' => false,
            'icon' => 'style',
            'submenu' => '',
            'grupo' => []
        ];

         $menu['outrasinformacoes']['submenu'][] = [
            'label' => 'Certid&otilde;es Negativas',
            'title' => 'Ir para Dados Certid&otilde;es Negativas',
            'link' => '/default/consultardadosprojeto/certidoes-negativas/?idPronac=' . $idPronacHash,
            'ajax' => true,
            'grupo' => []
        ];

         $menu['outrasinformacoes']['submenu'][] = [
            'label' => 'Dados complementares do projeto',
            'title' => 'Ir para Dados complementares do projeto',
            'link' => '/default/consultardadosprojeto/dados-complementares/?idPronac=' . $idPronacHash,
            'ajax' => true,
            'grupo' => []
        ];
         
          $menu['outrasinformacoes']['submenu'][] = [
            'label' => 'Documentos anexados',
            'title' => 'Ir para  Documentos anexados',
            'link' => '/default/consultardadosprojeto/documentos-anexados/?idPronac=' . $idPronacHash,
            'ajax' => true,
            'grupo' => []
        ];

        $menu['outrasinformacoes']['submenu'][] = [
            'label' => 'Documentos assinados',
            'title' => 'Ir para Documentos assinados',
            'link' => '/assinatura/index/visualizar-documentos-assinatura-ajax/?idPronac=' . $idPronacHash,
            'ajax' => true,
            'grupo' => []
        ];

        $menu['outrasinformacoes']['submenu'][] = [
            'label' => 'Dilig&ecirc;ncias do projeto',
            'title' => 'Ir para Dilig&ecirc;ncias do projeto',
            'link' => '/default/consultardadosprojeto/diligencias/?idPronac=' . $idPronacHash,
            'ajax' => true,
            'grupo' => []
        ];

        $menu['outrasinformacoes']['submenu'][] = [
            'label' => 'Local de realiza&ccedil;&atilde;o/Deslocamento',
            'title' => 'Ir para Local de realiza&ccedil;&atilde;o/Deslocamento',
            'link' => '/default/consultardadosprojeto/local-realizacao-deslocamento/?idPronac=' . $idPronacHash,
            'ajax' => true,
            'grupo' => []
        ];


        if ($this->IN2017) {
            $menu['outrasinformacoes']['submenu'][] = [
                'label' => 'Plano de distribui&ccedil;&atilde;o',
                'title' => 'Ir para Plano de distribui&ccedil;&atilde;o',
                'link' => '/default/consultardadosprojeto/plano-de-distribuicao/?idPronac=' . $idPronacHash,
                'ajax' => true,
                'grupo' => []
            ];
        } else {
            $menu['outrasinformacoes']['submenu'][] = [
                'label' => 'Plano de distribui&ccedil;&atilde;o',
                'title' => 'Ir para Plano de distribui&ccedil;&atilde;o',
                'link' => '/proposta/visualizar-plano-distribuicao/visualizar/idPreProjeto/' . $this->projeto->idProjeto,
                'ajax' => true,
                'grupo' => []
            ];
        }

        $menu['outrasinformacoes']['submenu'][] = [
            'label' => 'Provid&ecirc;ncia tomada',
            'title' => 'Ir para Provid&ecirc;ncia tomada',
            'link' => '/default/consultardadosprojeto/providencia-tomada/?idPronac=' . $idPronacHash,
            'ajax' => false,
            'grupo' => []
        ];

        $menu['outrasinformacoes']['submenu'][] = [
            'label' => 'Tramita&ccedil;&atilde;o',
            'title' => 'Ir para Tramita&ccedil;&atilde;o',
            'link' => '/default/consultardadosprojeto/tramitacao/?idPronac=' . $idPronacHash,
            'ajax' => true,
            'grupo' => []
        ];

        if ($this->usuarioInterno) {
            $menu['outrasinformacoes']['submenu'][] = [
                'label' => 'Hist&oacute;rico encaminhamento',
                'title' => 'Ir para Hist&oacute;rico encaminhamento',
                'link' => '/default/consultardadosprojeto/historico-encaminhamento/?idPronac=' . $idPronacHash,
                'ajax' => true,
                'grupo' => []
            ];
        }

        return $menu;
    }

}
