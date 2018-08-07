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
            $menu = $this->analise();
            $menu += $this->prestacaoContas();
            $this->view->assign('data', $menu );
//            $this->view->assign('data',  $this->analise() );
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
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'painel'],
                'grupo' =>[126]
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [125],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'painel'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [125],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'manter-assinantes'],
                'title' => 'Ir para Assinantes',
                'label' => 'Assinantes'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [124],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'tecnicoprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [12],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'conjurprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Ir para Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [177],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'aeciprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [132],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'chefedivisaoprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [93],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'coordenadorpareceristaprestacaocontas'],
                'title' => 'Analisar Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [94, 93],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'pareceristaprestacaocontas'],
                'title' => 'Ir para Presta&ccedil;&atilde;o de Contas',
                'label' => 'Analisar Presta&ccedil;&atilde;o de Contas'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [126,148,151],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'analisar-laudo-final'],
                'title' => 'Ir para Analisar Laudo Final',
                'label' => 'Analisar Laudo Final'
            ];
            $arrMenu['prestacao-contas']['menu'][] = [
                'grupo' => [124,125,132],
                'url' => ['controller' => 'realizarprestacaodecontas', 'action' => 'consultar-laudo-final'],
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


