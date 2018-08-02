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
                'url' => ['controller' => 'areadetrabalho', 'action' => 'index'],
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
                'url' => ['controller' => 'gerenciarpautareuniao', 'action' => 'gerenciarpautareuniao'],
                'grupo' => [118,Autenticacao_Model_Grupos::MEMBROS_NATOS_CNIC]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Reuni&atilde;o CNIC',
                'title' => 'Ir para Gerenciar Pauta da Reuni&atilde;o',
                'url' => ['controller' => 'gerenciarpautareuniao', 'action' => 'gerenciarpresidenteemreuniao'],
                'grupo' => [Autenticacao_Model_Grupos::PRESIDENTE_CNIC]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Reuni&atilde;o CNIC',
                'title' => 'Ir para Gerenciar Pauta da Reuni&atilde;o',
                'url' => ['controller' => 'gerenciarpautareuniao', 'action' => 'gerenciaradministrativo'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_CNIC,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerenciar Pareceres',
                'title' => 'Ir para Gerenciar Pareceres',
                'url' => ['controller' => 'gerenciarpareceres', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE, Autenticacao_Model_Grupos::TECNICO_ANALISE,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Imprimir Parecer T&eacute;cnico',
                'title' => 'Ir para Imprimir Parecer T&eacute;cnico',
                'url' => ['controller' => 'gerenciarpareceres', 'action' => 'imprimir-parecer-tecnico'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER,Autenticacao_Model_Grupos::GESTOR_SALIC,Autenticacao_Model_Grupos::COORDENADOR_ANALISE,137]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerenciar Componente da Comiss&atilde;o',
                'title' => 'Ir para Gerenciar Componente da Comiss&atilde;o',
                'url' => ['controller' => 'projetosgerenciar', 'action' => 'index'],
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
                'url' => ['controller' => 'gerartermodeaprovacao', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,Autenticacao_Model_Grupos::TECNICO_ANALISE,Autenticacao_Model_Grupos::COORDENADOR_CNIC,Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'CheckList para Publica&ccedil;&atilde;o',
                'title' => 'Ir para CheckList para Publica&ccedil;&atilde;o',
                'url' => ['controller' => 'checklistpublicacao', 'action' => 'listas'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,Autenticacao_Model_Grupos::TECNICO_ANALISE,Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO,148,151]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Certid&otilde;es Negativas',
                'title' => 'Ir para Certid&otilde;es Negativas',
                'url' => ['module' => 'default', 'controller' => 'manterregularidadeproponente', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::COORDENADOR_ANALISE,Autenticacao_Model_Grupos::TECNICO_ANALISE,Autenticacao_Model_Grupos::COORDENADOR_ATENDIMENTO]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Gerar Publica&ccedil;&atilde;o para DOU',
                'title' => 'Ir para Gerar Publica&ccedil;&atilde;o para DOU',
                'url' => ['controller' => 'publicacaodou', 'action' => 'index'],
                'grupo' => [Autenticacao_Model_Grupos::TECNICO_PORTARIA]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Atualiza&ccedil;&atilde;o de Portaria',
                'title' => 'Ir para Atualiza&ccedil;&atilde;o de Portaria',
                'url' => ['controller' => 'publicacaodou', 'action' => 'consultar-portaria'],
                'grupo' => [Autenticacao_Model_Grupos::TECNICO_PORTARIA]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Cadastrar Projetos FNC',
                'title' => 'Ir para Cadastrar Projetos FNC',
                'url' => ['controller' => 'cadastrar-projeto', 'action' => 'index'],
                'grupo' => [142]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Calend&aacute;rio CNIC',
                'title' => 'Ir para Calend&aacute;rio CNIC',
                'url' => ['controller' => 'mantercalendariocnic', 'action' => 'index'],
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
                'url' => ['controller' => 'aprovacaoeparecer', 'action' => 'index'],
                'grupo' => [143]
            ];
            $arrMenu['analise']['menu'][] = [
                'label' => 'Aprova&ccedil;&atilde;o FNC',
                'title' => 'Ir para Aprova&ccedil;&atilde;o FNC',
                'url' => ['controller' => 'aprovacaoeparecer', 'action' => 'index'],
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
                'url' => ['controller' => 'configuracoes', 'action' => 'secretarios'],
                'grupo' => [Autenticacao_Model_Grupos::TECNICO_PORTARIA]
            ];






            $this->view->assign('data',  $arrMenu);
            $this->getResponse()->setHttpResponseCode(200);
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


