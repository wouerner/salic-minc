<?php

class Projeto_IndexController extends Projeto_GenericController
{
//    private $getIdUsuario = 0;
//    private $getCNPJCPF = 0;
//    private $idResponsavel = 0;
//    private $idAgente = 0;
//    private $idUsuario = 0;
//    private $cpfLogado = 0;


    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $this->redirect("/projeto/index/listar");
    }

    public function listarAction()
    {
        $dbTableVinculo = new Agente_Model_DbTable_TbVinculo();
        $proponenteVinculados = $dbTableVinculo->buscarProponenteResponsavel($this->idUsuarioExterno);

        $proponentes = [];
        foreach ($proponenteVinculados as $key => $proponenteVinculado) {
            $proponentes[$key]['idAgenteProponente'] = $proponenteVinculado->idAgente;
            $proponentes[$key]['CPF'] = $proponenteVinculado->CNPJCPF;
            $proponentes[$key]['Nome'] = $proponenteVinculado->NomeProponente;
        }

        $this->view->buscaProponente = $proponentes;

        $this->view->proponentes = $proponentes;
        $this->view->idResponsavel = $this->idUsuarioExterno;
        $this->view->idUsuario = $this->idUsuarioExterno;
        $this->view->idAgente = $this->idAgente;

    }

    public function listarax() {
        /*****************************************************************************/

        if (!isset($_POST['idProponente']) || empty($_POST['idProponente'])) {
            $this->view->listarprojetos = 0;
        } else {
            try {
                $post = Zend_Registry::get('post');

                $idProponente = !empty($post->idProponente) ? $post->idProponente : ''; // deleta a m�scara
                $mecanismo = $_POST['mecanismo'];
                $idResponsavel = $this->idResponsavel;

                $a = new Projetos();
                $ProjetosVinculados = $a->listarProjetosConsulta($idResponsavel, $idProponente, $mecanismo)->toArray();

                $tbProjetos = new Projeto_Model_DbTable_Projetos();
                $projetos = [];

                if (count($ProjetosVinculados) > 0) {
                    foreach ($ProjetosVinculados as $projeto) {

                        $idPreProjeto = $tbProjetos->obterIdPreProjetoDoProjeto($projeto['IdPRONAC']);
                        $projeto['podeClonarProjeto'] = !empty($idPreProjeto) ? true : false;
                        $projeto['liberarEdicao'] = $tbProjetos->fnChecarLiberacaoDaAdequacaoDoProjeto($projeto['IdPRONAC']);

                        $projetos[] = $projeto;
                    }
                    $this->view->listarprojetos = $projetos;
                    $this->view->mecanismo = $mecanismo;
                    $this->view->agenteId = $idProponente;
                } else {
                    parent::message("Nenhum projeto encontrado!", "listarprojetos/listarprojetos", "ALERT");
                }
            } catch (Exception $e) {
                parent::message($e->getMessage(), "listarprojetos/listarprojetos", "ERROR");
            }
        }
    }

    public function listarProjetosAjaxAction()
    {
        $idProponente = $this->getRequest()->getParam('id');
        $mecanismo = $this->getRequest()->getParam('mecanismo');
        $start = $this->getRequest()->getParam('start');
        $length = $this->getRequest()->getParam('length');
        $draw = (int)$this->getRequest()->getParam('draw');
        $search = $this->getRequest()->getParam('search');
        $order = $this->getRequest()->getParam('order');
        $columns = $this->getRequest()->getParam('columns');

        $order = ($order[0]['dir'] != 1) ? array($columns[$order[0]['column']]['name'] . ' ' . $order[0]['dir']) : ["idPronac desc"];

        $idProponente = ((int)$idProponente == 0) ? $this->idAgente : (int)$idProponente;

        if (empty($idProponente)) {
            $this->_helper->json(array(
                "data" => 0,
                'recordsTotal' => 0,
                'draw' => 0,
                'recordsFiltered' => 0));
        }
        $tbProjetos = new Projeto_Model_DbTable_Projetos();
        $projetos = $tbProjetos->obterProjetosPorProponente(
            $this->idUsuarioExterno,
            $idProponente,
            $mecanismo,
            [],
            $order,
            $start,
            $length,
            $search
        );

//        $tblPreProjeto = new Proposta_Model_DbTable_PreProjeto();

//        $rsPreProjeto = $tblPreProjeto->propostas($this->idAgente, $this->idResponsavel, $idAgente, array(), $order, $start, $length, $search);

//        $Movimentacao = new Proposta_Model_DbTable_TbMovimentacao();

        $recordsTotal = 0;
        $recordsFiltered = 0;
        $dados = array();
        if (!empty($projetos)) {
            foreach ($projetos as $key => $projeto) {
                $novoProjeto = new stdClass();
                $novoProjeto->pronac = utf8_encode($projeto->Pronac);
                $novoProjeto->idPronac = utf8_encode($projeto->IdPRONAC);
                $novoProjeto->mecanismo = utf8_encode($projeto->Mecanismo);
                $novoProjeto->nomeprojeto = utf8_encode($projeto->NomeProjeto);
                $novoProjeto->periodo = utf8_encode($projeto->DtInicioDeExecucao) . ' - ' . utf8_encode($projeto->DtFinalDeExecucao);
                $novoProjeto->situacao = utf8_encode($projeto->Situacao) . ' ' . utf8_encode($projeto->Descricao);

                $dados[$key] = $novoProjeto;
            }
//            $recordsFiltered = $tblPreProjeto->propostasTotal($this->idAgente, $this->idResponsavel, $idAgente, array(), null, null, null, $search);
//            $recordsTotal = $tblPreProjeto->propostasTotal($this->idAgente, $this->idResponsavel, $idAgente);
        }

        $this->_helper->json(array(
            "data" => !empty($dados) ? $dados : 0,
            'recordsTotal' => $recordsTotal ? $recordsTotal : 0,
            'draw' => $draw,
            'recordsFiltered' => $recordsFiltered ? $recordsFiltered : 0
        ));
    }

    public function buscarProponentesComboAction()
    {
        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout
        $mecanismo = $_POST['mecanismo'];

        $tblVinculo = new Agente_Model_DbTable_TbVinculo();
        $rsVinculo = $tblVinculo->buscarProponenteResponsavel($this->idResponsavel, $mecanismo);
        $agente = array();

        $i = 1;
        if (count($rsVinculo) > 0) {
            foreach ($rsVinculo as $rs) {
                $dadosCombo[$i]['idAgenteProponente'] = $rs->idAgente;
                if (strlen($rs->CNPJCPF) == 11) {
                    $proponente = '[' . Mascara::addMaskCPF($rs->CNPJCPF) . '] - ' . utf8_encode($rs->NomeProponente);
                } else {
                    $proponente = '[' . Mascara::addMaskCNPJ($rs->CNPJCPF) . '] - ' . utf8_encode($rs->NomeProponente);
                }
                $dadosCombo[$i]['proponente'] = $proponente;
                $i++;
            }
            $jsonEncode = json_encode($dadosCombo);
            $this->_helper->json(array('resposta' => true, 'conteudo' => $dadosCombo));
        } else {
            $this->_helper->json(array('resposta' => false));
        }
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function gerarpdfAction()
    {
        $this->_helper->layout->disableLayout();

        $cpf = $_GET['cpf'];
        $listar = ListarprojetosDAO::buscarDadosListarProjetos($cpf);
        $this->view->listarprojetos = $listar;
    }

    public function gerarxlsAction()
    {
        $cpf = $_GET['cpf'];
        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout
        $listar = ListarprojetosDAO::buscarDadosListarProjetos($cpf);
        $this->view->listarprojetos = $listar;
    }

    public function clonarProjetoAjaxAction()
    {
        $params = $this->getRequest()->getParams();

        $return['msg'] = '';
        $return['status'] = false;

        $idPronac = isset($params['idPronac']) ? $params['idPronac'] : '';

        $permissaoProjeto = $this->verificarPermissaoAcesso(false, $idPronac, false, true);

        if (true !== $permissaoProjeto['status']) {
            $this->_helper->json($permissaoProjeto);
            die;
        }

        if (empty($this->idResponsavel)) {
            $return['msg'] = 'Usu&aacute;rio inv&aacute;lido!';
            $return['status'] = false;

            $this->_helper->json($return);
            die;
        }

        $tbProjetos = new Projeto_Model_DbTable_Projetos();

        $idPreProjeto = $tbProjetos->obterIdPreProjetoDoProjeto($idPronac);

        if (empty($idPreProjeto)) {
            $return['msg'] = 'Erro ao Clonar! Este projeto n&atilde;o possui proposta!';
            $return['status'] = false;

            $this->_helper->json($return);
            die;
        }

        $retorno = (array)$tbProjetos->spClonarProjeto($idPronac, $this->idResponsavel);

        $return['msg'] = $retorno['Mensagem'];
        $return['status'] = false;

        if ($retorno['stEstado'] == 'TRUE') {
            $return['idPreProjeto'] = $retorno['Mensagem'];
            $return['msg'] = 'Sucesso! Voc&ecirc; ser&aacute; redirecionado para a proposta!';
            $return['status'] = true;
        }

        $this->_helper->json($return);
        die;
    }
}
