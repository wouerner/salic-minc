<?php

class PrestacaoContas_PrestacaoContasController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        $PermissoesGrupo = [
            Autenticacao_Model_Grupos::TECNICO_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_PRESTACAO_DE_CONTAS,
            Autenticacao_Model_Grupos::COORDENADOR_GERAL_PRESTACAO_DE_CONTAS
        ];

        $auth = Zend_Auth::getInstance();

        isset($auth->getIdentity()->usu_codigo) ? parent::perfil(1, $PermissoesGrupo) : parent::perfil(4, $PermissoesGrupo);

        isset($auth->getIdentity()->usu_codigo) ? $this->idUsuario = $auth->getIdentity()->usu_codigo : $this->idUsuario = $auth->getIdentity()->IdUsuario;

        $GrupoAtivo = new Zend_Session_Namespace('GrupoAtivo');

        if (isset($auth->getIdentity()->usu_codigo)) {
            $this->codGrupo = $GrupoAtivo->codGrupo;
            $this->codOrgao = $GrupoAtivo->codOrgao;
            $this->codOrgaoSuperior = (!empty($auth->getIdentity()->usu_org_max_superior)) ? $auth->getIdentity()->usu_org_max_superior : null;
        }

        parent::init();
    }

    public function indexAction()
    {
    }

    public function tipoAvaliacaoAction()
    {
        $idPronac = $this->_request->getParam("idPronac");
        if (!$idPronac) {
           throw new Exception('Não existe idPronac');
        }
        $informacoes = new PrestacaoContas_Model_vwInformacoesConsolidadasParaAvaliacaoFinanceira();
        $informacoes = $informacoes->informacoes($idPronac);
        $this->view->idPronac = $this->_request->getParam("idPronac");
        $this->view->informacoes = $informacoes->current();
    }

    /* @todo: adicionar função de salvar o tipo de amostragem*/
    public function tipoAvaliacaoSalvarAction()
    {
        $idPronac = $this->_request->getParam("idPronac");
        $avaliacao = $this->_request->getParam("avaliacao");
        if (!$idPronac) {
           throw new Exception('Não existe idPronac');
        }
        if (!$avaliacao) {
           throw new Exception('Não existe avaliacao');
        }
        if ($avaliacao == "todos") {
            $this->redirect('/realizarprestacaodecontas/planilhaorcamentaria/idPronac/' . $idPronac );
        }
        $this->redirect('/prestacao-contas/prestacao-contas/amostragem/idPronac/' . $idPronac . '/tipoAvaliacao/' . $avaliacao);
    }

    public function amostragemAction()
    {
        $idPronac = $this->_request->getParam("idPronac");
        $tipoAvaliacao = $this->_request->getParam("tipoAvaliacao");
        if (!$idPronac) {
           throw new Exception('Não existe idPronac');
        }
        if (!$tipoAvaliacao) {
           throw new Exception('Não existe tipoAvaliacao');
        }
        $comprovantes = new PrestacaoContas_Model_spComprovantes();
        $comprovantes = $comprovantes->exec($idPronac, $tipoAvaliacao);
        $this->view->idPronac = $idPronac;
        $this->view->comprovantes = $comprovantes;


        $projeto = new Projetos();
        $projeto = $projeto->buscarTodosDadosProjeto($idPronac);
        $projeto = $projeto->current();

        $this->view->nomeProjeto = $projeto->NomeProjeto;
        $this->view->pronac = $projeto->pronac;
        $this->view->idPronac = $projeto->IdPRONAC;

        $diligencia = new Diligencia();
        $this->view->existeDiligenciaAberta = $diligencia->existeDiligenciaAberta($idPronac, null);
    }

    public function salvarAnaliseAction()
    {
        $idPronac = $this->_request->getParam("idPronac");
        $idComprovantePagamento = $this->_request->getParam("idComprovantePagamento");
        $situacao = $this->_request->getParam("situacao");
        $justificativa = $this->_request->getParam("justificativa");
        if (!$idComprovantePagamento || !$situacao) {
           throw new Exception('Faltando dados');
        }
        $tblComprovantePag = new ComprovantePagamentoxPlanilhaAprovacao();
        $rsComprovantePag = $tblComprovantePag
            ->buscar(['idComprovantePagamento = ?' => $idComprovantePagamento])
            ->current();
        $rsComprovantePag->dtValidacao = date('Y/m/d H:i:s');
        $rsComprovantePag->dsJustificativa = isset($justificativa) ? $justificativa : null;
        $rsComprovantePag->stItemAvaliado = $situacao;
        $rsComprovantePag->save();
        $this->_helper->json(['idComprovantePagamento' => $idComprovantePagamento]);
    }

    public function planilhaAction()
    {
        $idpronac = (int)$this->_request->getParam('idpronac');

        if ($idpronac == 0) {
            throw new Exception('idpronac não informado!');
        }

        $planilhaAprovacaoModel = new PlanilhaAprovacao();
        $planilha = $planilhaAprovacaoModel->vwComprovacaoFinanceiraProjeto($idpronac); 

        $planilhaJSON = null;

        foreach($planilha as $item) {
            $planilhaJSON
                [$item->cdProduto]
                ['etapa']
                [$item->cdEtapa]
                ['UF']
                [$item->cdUF]
                ['cidade']
                [$item->cdCidade]
                ['item']
                [$item->idPlanilhaItens] = [
                    'item' => utf8_encode($item->Item),
                    'varlorAprovado' => $item->vlAprovado,
                    'varlorComprovado' => $item->vlComprovado,
                    'comprovacaoValidada' => $item->ComprovacaoValidada,
            ];

            $planilhaJSON[$item->cdProduto] += [
                    'produto' => utf8_encode($item->Produto),
                    'cdProduto' => $item->cdProduto, 
            ];

            $planilhaJSON[$item->cdProduto]['etapa'][$item->cdEtapa] += [
               'etapa' => utf8_encode($item->Etapa),
                'cdEtapa' =>  $item->cdEtapa
            ];

            $planilhaJSON[$item->cdProduto]['etapa'][$item->cdEtapa]['UF'][$item->cdUF] += [
                'Uf' => $item->Uf,
              'cdUF' => $item->cdUF
            ];

            $planilhaJSON[$item->cdProduto]['etapa'][$item->cdEtapa]['UF'][$item->cdUF]['cidade'][$item->cdCidade] += [
               'cidade' => utf8_encode($item->Cidade),
               'cdCidade' => $item->cdCidade
            ];
        }

        $this->_helper->json($planilhaJSON);
    }

    public function analiseFinanceiraVirtualAction(){
        $this->view->areaEncaminhamento = (new Orgaos())->obterAreaParaEncaminhamentoPrestacao($this->codOrgao);
    }

    public function obterProjetosAnaliseFinanceiraVirtualAction(){
        $situacaoEncaminhamentoPrestacao = $this->getRequest()->getParam('situacaoEncaminhamentoPrestacao');
        $start = $this->getRequest()->getParam('start');
        $length = $this->getRequest()->getParam('length');
        $draw = (int)$this->getRequest()->getParam('draw');
        $search = $this->getRequest()->getParam('search');
        $order = $this->getRequest()->getParam('order');

        $column = $order[0]['column']+1;
        $orderType = $order[0]['dir'];
        $order = $column.' '.$orderType;

        $tbPlanilhaAplicacao = new tbPlanilhaAprovacao();
        $projetos = $tbPlanilhaAplicacao->obterProjetosAnaliseFinanceiraVirtual(
            $this->codOrgao,
            $situacaoEncaminhamentoPrestacao,
            $order,
            $start,
            $length,
            $search
        );


        if (count($projetos) > 0) {
            foreach($projetos->toArray() as $coluna => $item){
                foreach($item as $key => $value){
                    $projetosAnaliseFinanceiraVirtual[$coluna][] = utf8_encode($value);
                }
            }
            $recordsTotal = $tbPlanilhaAplicacao->obterProjetosAnaliseFinanceiraVirtual(
                $this->codOrgao,
                $situacaoEncaminhamentoPrestacao,
                null,
                null,
                null,
                null
            );
            $recordsTotal = count($recordsTotal);


            $recordsFiltered = $tbPlanilhaAplicacao->obterProjetosAnaliseFinanceiraVirtual(
                $this->codOrgao,
                $situacaoEncaminhamentoPrestacao,
                null,
                null,
                null,
                $search);
            $recordsFiltered = count($recordsFiltered);

        }

        $this->_helper->json(
            [
                "data" => !empty($projetosAnaliseFinanceiraVirtual) ? $projetosAnaliseFinanceiraVirtual : 0,
                'recordsTotal' => $recordsTotal ? $recordsTotal : 0,
                'draw' => $draw,
                'recordsFiltered' => $recordsFiltered ? $recordsFiltered : 0,
            ]
        );
    }

    public function obterHistoricoEncaminhamentoAction(){

        $idPronac = Zend_Registry::get("post")->idPronac;

        if (empty($idPronac)) {
            $this->_helper->json([
                'data' => []
            ]);
        }

        $tblEncaminhamento = new tbEncaminhamentoPrestacaoContas();
        $historicos = $tblEncaminhamento->HistoricoEncaminhamentoPrestacaoContas($idPronac);

        foreach($historicos->toArray() as $index =>$historico){
            foreach($historico as $key => $value){
                $rsHistorico[$index][$key] = utf8_encode($value);
            }
        }

        $this->_helper->json([
            'data' => $rsHistorico
        ]);

    }
}
