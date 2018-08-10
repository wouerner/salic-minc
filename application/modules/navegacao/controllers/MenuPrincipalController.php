<?php

    class Navegacao_MenuPrincipalController extends Zend_Rest_Controller{

        public function init()
        {
            $this->_helper->getHelper('contextSwitch')
                ->addActionContext('get', 'json')
                ->addActionContext('index', 'json')
                ->addActionContext('post', 'json')
                ->addActionContext('put', 'json')
                ->addActionContext('delete', 'json')
                ->initContext('json');
        }

        public function indexAction()
        {
            $menu = [];
            $menu += $this->prestacaoContas();
            $menu += $this->analise();
            $menu += $this->administrativo();
            $menu += $this->proposta();
            $menu += $this->projeto();
            $menu += $this->solicitacoes();
            $menu += $this->usuario();
            $menu += $this->assinatura();
            $menu += $this->atendimento();
            $menu += $this->acompanhamento();
            $menu += $this->menuAdministrativo();
            $menu += $this->protocolo();
            $this->view->assign('data', $menu );
            $this->getResponse()->setHttpResponseCode(200);
        }

        public function prestacaoContas(){
            $arrMenu['prestacao-contas'] = [
                'id' => 'prestacao-contas',
                'label' => 'Presta&ccedil;&atilde;o de Contas',
                'title' => 'Ir para Presta&ccedil;&atilde;o de Contas',
                'menu' => [],
                'grupo' => [100,124,125,126,132,148,151],
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'title' => 'Ir para Analisar Presta&ccedil;&atilde;o de Contas',
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'painel'],
                'grupo' =>[126]
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [125],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'painel'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [125],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'manter-assinantes'],
                'title' => 'Ir para Assinantes',
                'label' => 'Assinantes'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [124],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'tecnicoprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [12],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'conjurprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Ir para Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [177],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'aeciprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [132],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'chefedivisaoprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [93],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'coordenadorpareceristaprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [94, 93],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'pareceristaprestacaocontas'],
                'title' => 'Ir para Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [126,148,151],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'analisar-laudo-final'],
                'title' => 'Ir para Analisar Laudo Final',
                'label' => 'Analisar Laudo Final'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [124,125,132],
                'url' => ['module' => 'default','controller' => 'realizarprestacaodecontas', 'action' => 'consultar-laudo-final'],
                'title' => 'Ir para Analisar Laudo Final',
                'label' => 'Analisar Laudo Final'
            ];

            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [147,148,149,150,151,152],
                'url' =>['module' => 'admissibilidade', 'controller' => 'enquadramento-assinatura', 'action' => 'gerenciar-assinaturas'],
                'title' => 'Assinatura',
                'label' => 'Assinatura'
            ];
            return $arrMenu;
        }

        public function analise (){
            $arrMenu['analise'] = [
                'id' => 'analise',
                'label' => 'An&aacute;lise',
                'title' => 'Ir para An&aacute;lise',
                'menu' => [],
                'grupo' => [
                    Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA,
                    Autenticacao_Model_Grupos::SUPERINTENDENTE_DE_VINCULADA,
                    Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER,
                    Autenticacao_Model_Grupos::PARECERISTA,
                    Autenticacao_Model_Grupos::GESTOR_SALIC,
                    Autenticacao_Model_Grupos::COORDENADOR_ANALISE,
                    Autenticacao_Model_Grupos::TECNICO_ANALISE,
                    118,
                    Autenticacao_Model_Grupos::PRESIDENTE_CNIC,
                    Autenticacao_Model_Grupos::COORDENADOR_CNIC,
                    Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO,
                    Autenticacao_Model_Grupos::TECNICO_PORTARIA,
                    132,
                    Autenticacao_Model_Grupos::MEMBROS_NATOS_CNIC,
                    137,
                    141,
                    142,
                    143,148,151],
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Realizar An&aacute;lise',
                'title' => 'Ir para An&aacute;lise do Membro da Comiss&atilde;o',
                'url' => [ 'module' => 'default' , 'controller' => 'areadetrabalho', 'action' => 'index'],
                'grupo' => [118,148,151]
            ];

            $arrMenu['analise']['menu'][] =[
                'label' => 'Avaliar adequa&ccedil;&atilde;o de projeto',
                'title' => 'Ir para Avaliar adequa&ccedi;&atilde;o de projeto',
                'url' => ['module' => 'analise', 'controller' => 'analise', 'action' => 'listarprojetos'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE, Autenticacao_Model_Grupos::TECNICO_ANALISE],
            ];

            $arrMenu['analise']['menu'][] = [
                'label' => 'Reuni&atilde;o CNIC',
                'title' => 'Ir para Gerenciar Pauta da Reuni&atilde;o',
                'url' => ['module'=> 'default' ,'controller' => 'gerenciarpautareuniao', 'action' => 'gerenciarpautareuniao'],
                'grupo' => [118,Autenticacao_Model_Grupos::MEMBROS_NATOS_CNIC]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Reuni&atilde;o CNIC',
                'title' => 'Ir para Gerenciar Pauta da Reuni&atilde;o',
                'url' => ['module'=>'default', 'controller' => 'gerenciarpautareuniao', 'action' => 'gerenciarpresidenteemreuniao'],
                'grupo' => [Autenticacao_Model_Grupos::PRESIDENTE_CNIC]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Reuni&atilde;o CNIC',
                'title' => 'Ir para Gerenciar Pauta da Reuni&atilde;o',
                'url' => ['module' => 'default', 'controller' => 'gerenciarpautareuniao', 'action' => 'gerenciaradministrativo'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_CNIC,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerenciar Pareceres',
                'title' => 'Ir para Gerenciar Pareceres',
                'url' => ['module' => 'default', 'controller' => 'gerenciarpareceres', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE, Autenticacao_Model_Grupos::TECNICO_ANALISE,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Imprimir Parecer T&eacute;cnico',
                'title' => 'Ir para Imprimir Parecer T&eacute;cnico',
                'url' => ['module'=> 'default' ,'controller' => 'gerenciarpareceres', 'action' => 'imprimir-parecer-tecnico'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER,Autenticacao_Model_Grupos::GESTOR_SALIC,Autenticacao_Model_Grupos::COORDENADOR_ANALISE,137]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerenciar Componente da Comiss&atilde;o',
                'title' => 'Ir para Gerenciar Componente da Comiss&atilde;o',
                'url' => ['module'=> 'default', 'controller' => 'projetosgerenciar', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Homologar Projetos',
                'title' => 'Ir para Homologa&ccedil;&atilde;o dos Projetos',
                'url' => ['module' => 'projeto', 'controller' => 'homologacao', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Assinar Homologa&ccedil;&atilde;o do Projetos',
                'title' => 'Ir para Assinatura de Homologa&ccedil;&atilde;o dos Projetos',
                'url' => ['module' => 'projeto', 'controller' => 'assinatura', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerar Termo de Decis&atilde;o',
                'title' => 'Ir para Gerar Termo de Decis&atilde;o',
                'url' => ['module' => 'default' ,'controller' => 'gerartermodeaprovacao', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,Autenticacao_Model_Grupos::TECNICO_ANALISE,Autenticacao_Model_Grupos::COORDENADOR_CNIC,Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'CheckList para Publica&ccedil;&atilde;o',
                'title' => 'Ir para CheckList para Publica&ccedil;&atilde;o',
                'url' => ['module' => 'default' ,'controller' => 'checklistpublicacao', 'action' => 'listas'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,Autenticacao_Model_Grupos::TECNICO_ANALISE,Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Certid&otilde;es Negativas',
                'title' => 'Ir para Certid&otilde;es Negativas',
                'url' => ['module' => 'default' ,'controller' => 'manterregularidadeproponente', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,Autenticacao_Model_Grupos::TECNICO_ANALISE,Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerar Publica&ccedil;&atilde;o para DOU',
                'title' => 'Ir para Gerar Publica&ccedil;&atilde;o para DOU',
                'url' => ['module'=> 'default' ,'controller' => 'publicacaodou', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::TECNICO_PORTARIA]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Atualiza&ccedil;&atilde;o de Portaria',
                'title' => 'Ir para Atualiza&ccedil;&atilde;o de Portaria',
                'url' => ['module' => 'default', 'controller' => 'publicacaodou', 'action' => 'consultar-portaria'],
                'grupo' => [Autenticacao_Model_Grupos::TECNICO_PORTARIA]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Cadastrar Projetos FNC',
                'title' => 'Ir para Cadastrar Projetos FNC',
                'url' => ['module' => 'default' ,'controller' => 'cadastrar-projeto', 'action' => 'index'],
                'grupo' => [142]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Calend&aacute;rio CNIC',
                'title' => 'Ir para Calend&aacute;rio CNIC',
                'url' => ['module'=> 'default' ,'controller' => 'mantercalendariocnic', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_CNIC]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerenciar Pareceres',
                'title' => 'Ir para Gerenciar Pareceres',
                'url' => ['module' => 'parecer', 'controller' => 'gerenciar-parecer', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerenciar Pareceres',
                'title' => 'Ir para Gerenciar Pareceres',
                'url' => ['module' => 'parecer', 'controller' => 'gerenciar-parecer', 'action' => 'finalizar-parecer'],
                'grupo' => [Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerenciar Pareceres',
                'title' => 'Ir para Gerenciar Pareceres',
                'url' => ['module' => 'parecer', 'controller' => 'gerenciar-parecer', 'action' => 'finalizar-parecer'],
                'grupo' => [Autenticacao_Model_Grupos::SUPERINTENDENTE_DE_VINCULADA]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'An&aacute;lise T&eacute;cnica Inicial',
                'title' => 'Ir para An&aacute;lise T&eacute;cnica Inicial',
                'url' => ['module' => 'parecer', 'controller' => 'analise-inicial', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::PARECERISTA]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Parecer T&eacute;cnico FNC',
                'title' => 'Ir para Parecer T&eacute;cnico FNC',
                'url' => ['module'=> 'default','controller' => 'aprovacaoeparecer', 'action' => 'index'],
                'grupo' => [143]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Aprova&ccedil;&atilde;o FNC',
                'title' => 'Ir para Aprova&ccedil;&atilde;o FNC',
                'url' => ['module' => 'default','controller' => 'aprovacaoeparecer', 'action' => 'index'],
                'grupo' => [141,142]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Recurso',
                'title' => 'Ir para Recurso',
                'url' => ['module' => 'default', 'controller' => 'recursos', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO]
            ];

            $arrMenu['analise']['menu'][] = [
                'label' => 'Avaliar Recursos',
                'title' => 'Ir para Avaliar Recursos',
                'url' => ['module' => 'default', 'controller' => 'recursos', 'action' => 'painel-recursos'],
                'grupo' => [ Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER, Autenticacao_Model_Grupos::PARECERISTA, Autenticacao_Model_Grupos::TECNICO_ANALISE]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Avaliar Readequa&ccedil;&otilde;es',
                'title' => 'Ir para Avaliar Readequa&ccedil;&otilde;es',
                'url' => ['module' => 'readequacao', 'controller' => 'readequacoes', 'action' => 'painel-readequacoes'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER, Autenticacao_Model_Grupos::PARECERISTA, Autenticacao_Model_Grupos::TECNICO_ANALISE],
            ];

            $arrMenu['analise']['menu'][] = [
                'label' => 'Avaliar Readequa&ccedil;&otilde;es',
                'title' => 'Ir para Avaliar Readequa&ccedil;&otilde;es',
                'url' => ['module' => 'readequacao', 'controller' => 'readequacoes', 'action' => 'analisar-readequacoes-cnic'],
                'grupo' => [118]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Avaliar Recursos',
                'title' => 'Ir para Avaliar Recursos',
                'url' => ['module' => 'default', 'controller' => 'recursos', 'action' => 'analisar-recursos-cnic'],
                'grupo' => [118]
            ];

            $arrMenu['analise']['menu'][] = [
                'label' => 'Configurar Assinatura',
                'title' => 'Ir para Configurar Assinatura',
                'url' => ['module'=> 'default', 'controller' => 'configuracoes', 'action' => 'secretarios '],
                'grupo' => [Autenticacao_Model_Grupos::TECNICO_PORTARIA]
            ];
            $arrMenu['analise']['menu'][] = [
                'grupo' => [ 147, 148, 149, 150, 151, 152 ],
                'url' => ['module' => 'admissibilidade', 'controller' => 'enquadramento-assinatura', 'action' => 'gerenciar-assinaturas'],
                'title' => 'Assinatura',
                'label' => 'Assinatura'
            ];

            return $arrMenu;
        }

        public function administrativo(){

            $arrMenuProponente['administrativo'] = [
                'id' => 'administrativo',
                'label' => 'Administrativo',
                'title' => 'Ir para Administrativo',
                'menu' => [],
                'grupo' => [],
            ];
            $arrMenuProponente['administrativo']['menu'][] = [
                'label' => 'Cadastrar Proponente',
                'title' => 'Ir para Manter Agentes',
                'url' => ['module' => 'agente', 'controller' => 'agentes', 'action' => 'incluiragente'],
                'grupo' => []
            ];

            //if ($this->idAgenteKeyLog != 0) {
            $arrMenuProponente['administrativo']['menu'][] = [
                'label' => 'Gerenciar respons&aacute;veis',
                'title' => 'Ir para Aceitar vinculo',
                'url' =>['module' => 'proposta', 'controller' => 'manterpropostaincentivofiscal', 'action' => 'consultarresponsaveis'],
                'grupo' => []
                ];
         //   }
            $arrMenuProponente['administrativo']['menu'][] = [
                'label' => 'Procura&ccedil;&atilde;o',
                'title' => 'Ir para Procura&ccedil;&atilde;o',
                'url' => ['module'=> 'default','controller' => 'procuracao', 'action' => 'index'],
                'grupo' => []
            ];

            return $arrMenuProponente;
        }
        public function Proposta(){
            $arrMenuProponente['proposta'] = [
                'id' => 'proposta',
                'label' => 'Proposta',
                'title' => 'Ir para Proposta',
                'menu' => [],
                'grupo' => [],
            ];
            $arrMenuProponente['proposta']['menu'][] = [
                'label' => 'Listar',
                'title' => 'Ir para Manter Proposta por Incentivo Fiscal',
                'url' => ['module' => 'proposta', 'controller' => 'manterpropostaincentivofiscal', 'action' => 'listarproposta'],
                'grupo' => []
            ];

            $arrMenuProponente['proposta']['menu'][] = [
                'label' => 'Arquivadas',
                'title' => 'Propostas Arquivadas',
                'url' => ['module' => 'proposta', 'controller' => 'manterpropostaincentivofiscal', 'action' => 'listar-propostas-arquivadas'],
                'grupo' => []
            ];
            return $arrMenuProponente;
        }

        public function projeto (){

            $arrMenuProponente['projeto'] = [
                'id' => 'projeto',
                'label' => 'Projeto',
                'title' => 'Ir para Projetos',
                'menu' => [],
                'grupo' => [],
            ];
            $arrMenuProponente['projeto']['menu'][] = [
                'label' => 'Listar Projetos',
                'title' => 'Ir para Listar Projetos',
                'url' => ['module' => 'projeto', 'controller' => 'index', 'action' => 'listar'],
                'grupo' => []
            ];

            return $arrMenuProponente;
        }

        public function solicitacoes (){
            $arrMenuProponente['solicitacoes'] = [
                'id' => 'solicitacoes',
                'label' => 'Solicita&ccedil;&otilde;es',
                'title' => 'Ir para Solicitacoes',
                'menu' => [],
                'grupo' => []
            ];
            $arrMenuProponente['solicitacoes']['menu'][] = [
                'label' => 'Listar Solicita&ccedil;&otilde;es', 'title' => 'Ir para Listar Solicita&ccedil;&otilde;es',
                'url' => ['module' => 'solicitacao', 'controller' => 'mensagem', 'action' => 'index'],
                'grupo' => []
                ];
            return $arrMenuProponente;
        }
        public function usuario(){
            $arrMenuProponente['usuario'] = [
                'id' => 'usuario',
                'label' => 'Usu&aacute;rio',
                'title' => 'Ir para Usu&aacute;rio',
                'menu' => [],
                'grupo' => [],
            ];
            $arrMenuProponente['usuario']['menu'][] = [
                'label' => 'Alterar Senha',
                'title' => 'Ir para Alterar Senha',
                'url' => ['module' => 'autenticacao', 'controller' => 'index', 'action' => 'alterarsenha'],
                'grupo' => []
            ];
            $arrMenuProponente['usuario']['menu'][] = [
                'label' => 'Alterar Dados',
                'title' => 'Ir para Alterar Dados',
                'url' => ['module' => 'autenticacao', 'controller' => 'index', 'action' => 'alterardados'],
                'grupo' => []
            ];
            return $arrMenuProponente;
        }

        public function assinatura(){
            $arrMenu['assinatura'] = [
                'id' => 'assinatura',
                'label' => 'Assinatura',
                'title' => 'Ir para Assinatura',
                'menu' => [],
//    'grupo' => array(90,91,92,93,96,97,Autenticacao_Model_Grupos::COORDENADOR_ANALISE,104,110,114,115,Autenticacao_Model_Grupos::PRESIDENTE_CNIC,Autenticacao_Model_Grupos::COORDENADOR_CNIC,121,122,123,124,125,126,Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO,Autenticacao_Model_Grupos::TECNICO_PORTARIA,131,132,135,138,139,148,151),
            ];
            $arrMenu['assinatura']['menu'][] = [
//    'grupo' => array(114,130),
                'url' => ['module' => 'assinatura', 'controller' => 'index', 'action' => 'gerenciar-assinaturas'],
                'title' => 'Ir para Gerenciamento de assinaturas',
                'label' => 'Gerenciar Assinaturas'
            ];

            $arrMenu['assinatura']['menu'][] = [
                'url' => ['module' => 'assinatura', 'controller' => 'index', 'action' => 'visualizar-assinaturas'],
                'title' => 'Ir para Visualização de Assinaturas',
                'label' => 'Visualizar Assinaturas'
            ];

            $arrMenu['assinatura']['menu'][] = [
                'grupo' => [
                    Autenticacao_Model_Grupos::PARECERISTA,
                    Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER,
                    Autenticacao_Model_Grupos::DIRETOR_DEPARTAMENTO,
                    Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA,
                    Autenticacao_Model_Grupos::COORDENADOR_GERAL_ACOMPANHAMENTO,
                    Autenticacao_Model_Grupos::TECNICO_ACOMPANHAMENTO,
                    Autenticacao_Model_Grupos::COORDENADOR_ACOMPANHAMENTO,
                    Autenticacao_Model_Grupos::SECRETARIO,
                ],
                'url' => ['module' => 'readequacao', 'controller' => 'readequacao-assinatura', 'action' => 'gerenciar-assinaturas'],
                'title' => 'Ir para Readequa&ccedil;&atilde;o - Gerenciar Assinaturas',
                'label' => 'Gerenciar Assinaturas - Readequa&ccedil;&atilde;o'
            ];


            $arrMenu['assinatura']['menu'][] = [
                'grupo' => [
                    Autenticacao_Model_Grupos::TECNICO_PRESTACAO_DE_CONTAS,
                    Autenticacao_Model_Grupos::COORDENADOR_PRESTACAO_DE_CONTAS,
                    Autenticacao_Model_Grupos::COORDENADOR_GERAL_PRESTACAO_DE_CONTAS,
                ],
                'url' => ['module' => 'assinatura', 'controller' => 'index', 'action' => 'gerenciar-assinaturas'] . "?idTipoDoAtoAdministrativo=" . \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_LAUDO_PRESTACAO_CONTAS,
                'title' => 'Ir para Readequa&ccedil;&atilde;o - Gerenciar Assinaturas',
                'label' => 'Gerenciar Assinaturas - Laudo Presta&ccedil;&atilde;o de Contas'
            ];

            $arrMenu['assinatura']['menu'][] = [
                'grupo' => [97],
                'url' => ['module' => 'assinatura', 'controller' => 'ato-administrativo', 'action' => 'gerir-atos-administrativos'],
                'title' => 'Ir para Gerir Atos Administrativos',
                'label' => 'Gerir Atos Administrativos'
            ];
            return $arrMenu;

        }
        public function atendimento(){
            $arrMenu['atendimento'] = [
                'id' => 'atendimento',
                'title' => 'Ir para Assinatura',
                'label' => 'Atendimento',
                'menu' => [],
                'grupo' => [Autenticacao_Model_Grupos::TECNICO_DE_ATENDIMENTO]
            ];

            $arrMenu['atendimento']['menu'][] = [
                'title' => 'Ir para Solicita&ccedil;&otilde;es',
                'label' => 'Solicita&ccedil;&otilde;es Proponente',
                'url' => ['module' => 'solicitacao', 'controller' => 'mensagem', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::TECNICO_DE_ATENDIMENTO]
            ];
            return $arrMenu;
        }
        public function acompanhamento(){
            $arrMenu['acompanhamento'] = [
                'title' => 'Ir para Acompanhamento',
                'label' => 'Acompanhamento',
                'id' => 'acompanhamento',
                'menu' => [],
                'grupo' => [94, 121, 122, 123, 124, 125, 126, 129, 134, 135, 137, 138, 139, 148, 151],
            ];

            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Ir para CheckList de Publica&ccedil;&atilde;o',
                'label' => 'CheckList para Publica&ccedil;&atilde;o',
                'url' => ['module'=> 'default','controller' => 'checklistpublicacao', 'action' => 'listas'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE, 110, 121, 122, 123, Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO]
            ];

            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Ir para Movimenta&ccedil;&atilde;o Banc&aacute;ria',
                'label' => 'Movimenta&ccedil;&atilde;o Banc&aacute;ria',
                'grupo' => [272, 166, 121, 122, 123, 129, 148, 151], // restringe ao �rgao SACAV && CAP
                'url' => ['module'=> 'default','controller' => 'movimentacaodeconta', 'action' => 'resultado-extrato-de-conta-captacao'],
            ];

            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Ir para Certid&otilde;es Negativas',
                'label' => 'Certid&otilde;es Negativas',
                'url' => ['module' => 'default', 'controller' => 'manterregularidadeproponente', 'action' => 'index'],
                'grupo' => [108, 121, 122, 123, 124, 125, 134, 135, 138, 139]
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Analisar Relat&oacute;rios Trimestrais',
                'label' => 'Analisar Relat&oacute;rios Trimestrais',
                'url' => ['module'=> 'default','controller' => 'analisarexecucaofisica', 'action' => 'projetos'],
                'grupo' => [122, 123]
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Verificar Readequa&ccedil;&atilde;o de Projetos',
                'label' => 'Verificar Readequa&ccedil;&atilde;o de Projeto',
                'url' => ['module'=> 'default','controller' => 'verificarreadequacaodeprojeto', 'action' => 'verificarreadequacaodeprojetocoordparecerista'],
                'grupo' => [93]
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Enviar Pareceres para Pagamento',
                'label' => 'Enviar Pareceres para Pagamento',
                'url' => ['module'=> 'default','controller' => 'gerenciarparecer', 'action' => 'enviarpagamento'],
                'grupo' => [93]
            ];
            /*if ($this->grupoAtivo == 94) : ?>
            <li><a href="<?php echo $this->url(array('controller' => 'parecerista', 'action' => 'confirmacao-pagamento-parecerista'), '', true); ?>" title="Meus pagamentos">Meus Pagamentos</a></li>
            <li><a href="<?php echo $this->url(array('controller' => 'verificarreadequacaodeprojeto', 'action' => 'verificarreadequacaodeprojetoparecerista'), '', true); ?>" title="Verificar Readequacao de Projetos">Verificar Readequacao de Projeto</a></li>
            <?php endif;*/
            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Meus pagamentos',
                'label' => 'Meus Pagamentos',
                'url' => ['module'=> 'default','controller' => 'parecerista', 'action' => 'confirmacao-pagamento-parecerista'],
                'grupo' => [94],
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Analisar Relat&oacute;rios Trimestrais',
                'label' => 'Analisar Relat&oacute;rios Trimestrais',
                'grupo' => [121, 129],
                'url' => ['module'=> 'default','controller' => 'analisarexecucaofisicatecnico', 'action' => 'index'],
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Ir para Fiscalizar Projeto',
                'label' => 'Fiscalizar Projeto',
                'grupo' => [134, 135],
                'url' => ['module'=> 'default','controller' => 'pesquisarprojetofiscalizacao', 'action' => 'grid'],
            ];

            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Ir para Analisar Projeto Parecer',
                'label' => 'Analisar Comprova&ccedil;&atilde;o do Objeto',
                'grupo' => [138],
                'url' => ['module'=> 'default','controller' => 'avaliaracompanhamentoprojeto', 'action' => 'index'],
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Ir para Analisar Projeto Parecer',
                'label' => 'Analisar Comprova&ccedil;&atilde;o do Objeto',
                'grupo' => [139, 148, 151],
                'url' => ['module'=> 'default','controller' => 'avaliaracompanhamentoprojeto', 'action' => 'index-tecnico'],
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'title' => 'Ir para Pagamento de parecerista',
                'label' => 'Pagamento de Pareceristas',
                'grupo' => [137],
                'url' => ['module'=> 'default','controller' => 'parecerista', 'action' => 'configurar-pagamento-parecerista'],
            ];
            $arrMenu['acompanhamento']['menu'][] =[
                'grupo' => [137],
                'url' => ['module'=> 'default','controller' => 'gerenciarparecer', 'action' => 'enviarpagamento'],
                'title' => 'Ir para Gerar Memorando',
                'label' => 'Gerar memorando de pagamento'
            ];

            $arrMenu['acompanhamento']['menu'][] = [
                'grupo' => [121, 122, 123],
                'url' => ['module'=> 'default','controller' => 'gerartermodeaprovacao', 'action' => 'index'],
                'title' => 'Ir para Gerenciar Termo de Decis&atilde;o',
                'label' => 'Gerar Termo de Decis&atilde;o'
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'grupo' => [121],
                'url' => ['module'=> 'default','controller' => 'marcas', 'action' => 'index'],
                'title' => 'Processar Marcas',
                'label' => 'Processar Marcas'
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'grupo' => [121, 122],
                'url' => ['module'=> 'default','controller' => 'avaliarpedidoprorrogacao', 'action' => 'index'],
                'title' => 'Avaliar Pedido de Prorroga&ccedil;&atilde;o',
                'label' => 'Avaliar Pedido de Prorroga&ccedil;&atilde;o'
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'grupo' => [122, 123, 148, 151],
                'url' => ['module' => 'readequacao', 'controller' => 'readequacoes', 'action' => 'painel'],
                'title' => 'Readequa&ccedil;&otilde;es',
                'label' => 'Readequa&ccedil;&otilde;es'
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'grupo' => [93, 121],
                'url' => ['module' => 'readequacao', 'controller' => 'readequacoes', 'action' => 'painel-readequacoes'],
                'title' => 'Avaliar Readequa&ccedil;&otilde;es',
                'label' => 'Avaliar Readequa&ccedil;&otilde;es'
            ];
            $arrMenu['acompanhamento']['menu'][] = [
                'grupo' => [
                    147
                , 148
                , 149
                , 150
                , 151
                , 152
                ],
                'url' => ['module' => 'admissibilidade', 'controller' => 'enquadramento-assinatura', 'action' => 'gerenciar-assinaturas'],
                'title' => 'Assinatura',
                'label' => 'Assinatura'
                ];
            return $arrMenu;
        }
        public function menuAdministrativo(){

            $arrMenu['administrativo'] = [
                'id' => 'administrativo',
                'label' => 'Administrativo',
                'title' => 'Ir para Administrativo',
                'menu' => [],
                'grupo' => [
                    93,
                    94,
                    97,
                    Autenticacao_Model_Grupos::COORDENADOR_ANALISE,
                    118,
                    Autenticacao_Model_Grupos::COORDENADOR_CNIC,
                    121,
                    122,
                    123,
                    137,
                ],
            ];
            $arrMenu['administrativo']['menu'][] = [
                'label' => 'Manter Agentes',
                'title' => 'Ir para Manter Agentes',
                'url' => ['module' => 'agente', 'controller' => 'agentes', 'action' => 'agentes'],
                'grupo' => [97, Autenticacao_Model_Grupos::COORDENADOR_CNIC, 121, 122, 123]
            ];
            $arrMenu['administrativo']['menu'][] = [
                'label' => 'Gerenciar meus dados', 'title' => 'Ir para Gerenciar meus dados',
                'url' => ['module' => 'agente', 'controller' => 'agentes', 'action' => 'agentes'],
                'grupo' => [94, 118]
            ];
            $arrMenu['administrativo']['menu'][] = [
                'label' => 'Desvincular Agentes',
                'title' => 'Ir para Desvincular Agentes',
                'url' => ['controller' => 'desvincularagentes', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE, Autenticacao_Model_Grupos::COORDENADOR_CNIC, 122]
            ];
            $arrMenu['administrativo']['menu'][] = [
                'label' => 'Analisar Procura&ccedil;&atilde;o',
                'title' => 'Ir para Analisar Procura&ccedil;&atilde;o',
                'url' => ['controller' => 'procuracao', 'action' => 'analisar'],
                'grupo' => [122, Autenticacao_Model_Grupos::COORDENADOR_ANALISE]
            ];
            $arrMenu['administrativo']['menu'][] = [
                'label' => 'Manter Parecerista',
                'title' => 'Ir para Manter Parecerista',
                'url' =>['module' => 'agente', 'controller' => 'agentes', 'action' => 'painelcredenciamento'],
                'grupo' => [137, 93]
            ];
            $arrMenu['administrativo']['menu'][] = ['label' => 'Gerenciar assinantes',
                'title' => 'Ir para Gerenciar assinantes',
                'url' => ['controller' => 'parecerista', 'action' => 'gerenciar-assinantes'],
                'grupo' => [137]
            ];
            $arrMenu['administrativo']['menu'][] = [
                'label' => 'Manter Termo de Decis&atilde;o',
                'title' => 'Ir para Manter Termo de Decis&atilde;o',
                'url' => ['controller' => 'mantertermodecisao', 'action' => 'index'],
                'grupo' => [97]
            ];
            $arrMenu['administrativo']['menu'][] = [
                'label' => 'Manter Secret&aacute;rio',
                'title' => 'Ir para Manter Secret&aacute;rio',
                'url' => ['controller' => 'mantersecretarioorgao', 'action' => 'index'],
                'grupo' => [97]
            ];
            $arrMenu['administrativo']['menu'][] = ['label' => 'Comunicados',
                'title' => 'Ir para Comunicados',
                'url' => ['controller' => 'comunicados', 'action' => 'index'],
                'grupo' => [97]
            ];
            $arrMenu['administrativo']['menu'][] = [
                'label' => 'Analisar Solicita&ccedil;&atilde;o de Item',
                'title' => 'Ir para Analisar Solicita&ccedil;&atilde;o de Item',
                'url' => ['module' => 'proposta', 'controller' => 'analisarsituacaoitem', 'action' => 'index'],
                'grupo' => [97]
            ];
            return $arrMenu;

        }
        public function protocolo(){
            $arrMenu['protocolo'] = [
                'id' => 'protocolo',
                'title' => 'Ir para Protocolo',
                'label' => 'Protocolo',
                'menu' => [],
                'grupo' => [90, 91, 97, 104, 109, 115],
            ];
            $arrMenu['protocolo']['menu'][] = [
                'grupo' => [91, 97, 104, 109, 115],
                'url' => ['controller' => 'tramitarprojetos', 'action' => 'despacharprojetos'],
                'title' => 'Ir para Tramitar Projetos',
                'label' => 'Tramitar Projetos'
            ];
            $arrMenu['protocolo']['menu'][] = [
                'grupo' => [90, 91, 97, 104, 109, 115],
                'url' => ['controller' => 'tramitardocumentos', 'action' => 'index'],
                'title' => 'Ir para Tramitar Documentos',
                'label' => 'Tramitar Documentos'
            ];
            return $arrMenu;
        }









        public function getAction()
        {
            $parametros = $this->getRequest()->getParams();
            $barService = new BarService($this->getRequest(), $this->getResponse());
            $resposta = $barService->buscar($parametros['id']);

            $this->view->assign('data', $resposta);

            $this->getResponse()->setHttpResponseCode(200);
        }

        public function headAction()
        {
            $this->getResponse()->setHttpResponseCode(200);
        }

        public function postAction()
        {
            $barService = new BarService($this->getRequest(), $this->getResponse());
            $resposta = $barService->salvarRegistro();

            $this->view->assign('data', $resposta);
            $this->getResponse()->setHttpResponseCode(201);
        }

        public function putAction()
        {

            $this->view->assign('data', 'asda');
            $this->getResponse()->setHttpResponseCode(200);
        }

        public function deleteAction()
        {
            $this->getResponse()->setHttpResponseCode(204);
        }
    }


