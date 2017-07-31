<?php

/**
 * MantertabelaitensController
 * @since 10/12/2010
 * @link http://www.cultura.gov.br
 */
class Proposta_MantertabelaitensController extends Proposta_GenericController
{

    /**
     * Reescreve o metodo init()
     * @access public
     * @param void
     * @return void
     */
    public function init()
    {
        parent::init();

        //recupera ID do pre projeto (proposta)
        if (!empty ($this->idPreProjeto)) {
            $this->view->idPreProjeto = $this->idPreProjeto;
        }
    }

    /**
     * Redireciona para o fluxo inicial
     * @access public
     * @param void
     * @return void
     */
    public function indexAction()
    {
        $this->_forward("consultartabelaitens", "mantertabelaitens");
    }

    /**
     * produtosetapasitensAction
     *
     * @access public
     * @return void
     */
    public function produtosetapasitensAction()
    {


        $tbproduto = MantertabelaitensDAO::buscaproduto();
        $this->view->produto = $tbproduto;

        $tbetapa = MantertabelaitensDAO::buscaetapa();
        $this->view->etapa = $tbetapa;

        $tbitem = MantertabelaitensDAO::buscaitem();
        $this->view->item = $tbitem;
    }

    /**
     * solicitaritensAction
     *
     * @access public
     * @return void
     * @author <wouerner@gmail.com>
     */
    public function solicitaritensAction()
    {
        $tbproduto = new MantertabelaitensDAO();
        $this->view->produto = $tbproduto->listarProduto();

        $tbetapa = new MantertabelaitensDAO();
        $this->view->etapa = $tbetapa->listarEtapa();

        $tbitem = new MantertabelaitensDAO();
        $this->view->item = $tbitem->listarItem();

        $tbsolicitacao = new MantertabelaitensDAO();
        $this->view->solicitacao = $tbsolicitacao->solicitacao($this->idUsuario);

        $buscardados = new MantertabelaitensDAO();
        $this->view->buscardados = $buscardados->produtoEtapaItem();

        if ($this->getRequest()->isPost()) {
            // recebe os dados via post
            $post = Zend_Registry::get('post');
            $justificativa = substr(trim($post->justificativa), 0, 1000);
            $idAgente = $this->getIdUsuario;
            $DtSolicitacao = $post->DtSolicitacao;
            $stEstado = $post->stEstado;
            $solicitacao = $post->solicitacao;
            $idPlanilhaItens = $post->idPlanilhaItens;
            $NomeItem = trim($post->Descricao);
            $etapa = $post->etapa;
            $produto = $post->produto;

            try {

                $nomeItem = new Proposta_Model_DbTable_TbPlanilhaItens();
                $nomeItem = $nomeItem->buscarDescricao($NomeItem);

                xd($nomeItem, $idPlanilhaItens);

                //@todo primeiro pesquisa pelo nome do item

                //@todo retorna


                $dateFunc = MinC_Db_Expr::date();
                $dadosassociar = array(
                    'idplanilhaitens' => $idPlanilhaItens,
                    'nomedoitem' => $nomeItem[0]->NomeDoItem,
                    'descricao' => $justificativa,
                    'idproduto' => $produto,
                    'idetapa' => $etapa,
                    'idagente' => $this->idUsuario,
                    'dtsolicitacao' => new Zend_Db_Expr($dateFunc),
                    'stestado' => '0'
                );

                $dadosincluir = array(
                    'idplanilhaitens' => 0,
                    'nomedoitem' => $NomeItem,
                    'descricao' => $justificativa,
                    'idproduto' => $produto,
                    'idetapa' => $etapa,
                    'idagente' => $this->idUsuario,
                    'dtsolicitacao' => new Zend_Db_Expr($dateFunc),
                    'stestado' => '0'
                );

                if (!empty($idPlanilhaItens) && $idPlanilhaItens != "0") {
                    $itemNome = $nomeItem[0]->NomeDoItem;
                } else {
                    $itemNome = $post->Descricao;
                }


                $arrBusca = array();
                $arrBusca['prod.codigo'] = $produto;
                $arrBusca['et.idplanilhaetapa'] = $etapa;

                //$res = MantertabelaitensDAO::buscarSolicitacoes($arrBusca,$itemNome);
                $res = new MantertabelaitensDAO();
                $res = $res->listarSolicitacoes($arrBusca, $itemNome);
//xd($res);
                if (count($res) > 0) {
                    throw new Exception("Cadastro duplicado de Produto na mesma etapa envolvendo o mesmo Item, transa&ccedil;&atilde;o cancelada!");
                }


                if (empty($justificativa)) {
                    throw new Exception("Por favor, informe a justificativa!");
                } else if (strlen($justificativa) > 1000) {
                    throw new Exception("A justificativa n&atilde;o pode conter mais de 1000 caracteres!");

                } else if ($solicitacao == 'produtoetapa') {
                    //$associaritem = MantertabelaitensDAO::associaritem($dadosassociar);
                    $associaritem = new MantertabelaitensDAO();
                    $associaritem = $associaritem->associarItemObj($dadosassociar);
                    if ($associaritem) {
                        parent::message("A solicita&ccedil;&atilde;o foi encaminhada ao Minc. Aguarde a resposta!", "/proposta/mantertabelaitens/solicitacoes?idPreProjeto=" . $this->idPreProjeto, "CONFIRM");
                    }
                } else if ($solicitacao == 'novoitem') ;
                {
                    $incluiritem = false;
                    if (empty($NomeItem)) {
                        throw new Exception("Por favor, informe o nome do Item!");
                    } else if (strlen($post->Descricao) > 100) {
                        throw new Exception("O nome do Item n&atilde;o pode conter mais de 100 caracteres!");
                    }

                    //codigo antigo
                    //$incluiritem = MantertabelaitensDAO::cadastraritem($Descricao, $this->idUsuario);
                    $incluiritem = new MantertabelaitensDAO();
                    $incluiritem = $incluiritem->cadastrarItemObj($dadosincluir);

                    if ($incluiritem) {
                        //$NovoItem = MantertabelaitensDAO::buscarItem($this->idUsuario);
                        //$dadosassociar['idPlanilhaItens'] = $NovoItem['idPlanilhaItens'];
                        $NovoItem = new MantertabelaitensDAO();
                        $NovoItem = $NovoItem->listarItem($this->idUsuario);
                        $dadosassociar['idPlanilhaItens'] = $NovoItem['idPlanilhaItens'];

                        parent::message("Cadastro realizado com sucesso!", "proposta/mantertabelaitens/solicitacoes?idPreProjeto=" . $this->idPreProjeto, "CONFIRM");
                        return;
                    } else {
                        throw new Exception("Erro ao cadastrar o Item!");
                    }
                }
            } catch (Exception $e) {

                parent::message($e->getMessage(), "proposta/mantertabelaitens/solicitaritens?idPreProjeto=" . $this->idPreProjeto, "ERROR");
                return;
            }
        }
    }

    /**
     * salvarAssociacaoItemAction
     *
     * @access public
     * @return void
     */
    public function salvarsolicitacaoitemAction()
    {
//        $tbproduto = new MantertabelaitensDAO();
//        $this->view->produto = $tbproduto->listarProduto();
//
//        $tbetapa = new MantertabelaitensDAO();
//        $this->view->etapa = $tbetapa->listarEtapa();
//
//        $tbitem = new MantertabelaitensDAO();
//        $this->view->item = $tbitem->listarItem();

//        $tbsolicitacao = new MantertabelaitensDAO();
//        $this->view->solicitacao = $tbsolicitacao->solicitacao($this->idUsuario);

//        $buscardados = new MantertabelaitensDAO();
//        $this->view->buscardados = $buscardados->produtoEtapaItem();

        if ($this->getRequest()->isPost()) {

            // recebe os dados via post
//            $post = Zend_Registry::get('post');
            $params = $this->getRequest()->getParams();


            $justificativa = substr(trim($params['justificativa']), 0, 1000);
            $descricaoItem = trim($params['Descricao']);

            $idAgente = $this->getIdUsuario;
            $DtSolicitacao = $params['DtSolicitacao'];
            $stEstado = $params['stEstado'];

            $solicitacao = $params['solicitacao'];

            $tipoSolicitacao = $params['solicitacao'];
            $idPlanilhaItens = $params['idPlanilhaItens'];

            $idProduto = $params['produto'];
            $idEtapa = $params['etapa'];
            $hoje = MinC_Db_Expr::date();

            try {

                if (empty($justificativa))
                    throw new Exception("Informe a justificativa!");


                if (strlen($justificativa) > 1000)
                    throw new Exception("A justificativa n&atilde;o pode conter mais de 1000 caracteres!");


                $dados = array(
                    'idplanilhaitens' => 0,
                    'nomedoitem' => $descricaoItem,
                    'descricao' => $justificativa,
                    'idproduto' => $idProduto,
                    'idetapa' => $idEtapa,
                    'idagente' => $this->idUsuario,
                    'dtsolicitacao' => new Zend_Db_Expr($hoje),
                    'stestado' => '0'
                );

                if ($tipoSolicitacao == "novoitem") {

                    if (empty($params['Descricao']))
                        throw new Exception("Descri&ccedil;&atilde;o do item &eacute; obrigat&oacute;ria!");

                    if (strlen($params['Descricao']) > 100)
                        throw new Exception("O nome do Item n&atilde;o pode conter mais de 100 caracteres!");

                    $tbPlanilhaItens = new Proposta_Model_DbTable_TbPlanilhaItens();
                    $descricao = $tbPlanilhaItens->buscarDescricao($descricaoItem);

                    if (!empty($descricao)) {
                        throw new Exception("Este item j&aacute; existe na base de dados, solicite associa&ccedil;&atilde;o!, a&ccedil;&atilde;o cancelada!");
                    }

                    $dadosincluir = array(
                        'idplanilhaitens' => 0,
                        'nomedoitem' => $descricaoItem,
                        'descricao' => $justificativa,
                        'idproduto' => $idProduto,
                        'idetapa' => $idEtapa,
                        'idagente' => $this->idUsuario,
                        'dtsolicitacao' => new Zend_Db_Expr($hoje),
                        'stestado' => '0'
                    );

                }

                if ($tipoSolicitacao == "associacao") {

                    if (empty($params['idPlanilhaItens'])) {
                        throw new Exception("Item não informado!");
                    }

                    $item = [];
                    $item['idProduto'] = $params['produto'];
                    $item['idPlanilhaEtapa'] = $params['etapa'];
                    $item['idPlanilhaItens'] = $params['idPlanilhaItens'];

                    $tbItensPlanilhaProduto = new tbItensPlanilhaProduto();
                    $itemProduto = $tbItensPlanilhaProduto->findBy($item);

                    if (count($itemProduto) > 0) {
                        throw new Exception("Item j&aacute; associado ao produto e  etapa informados. A&ccedil;&atilde;o cancelada!");
                    }

                    $tbPlanilhaItens = new Proposta_Model_DbTable_TbPlanilhaItens();
                    $planilhaItem = $tbPlanilhaItens->findBy(['idPlanilhaItens' => $params['idPlanilhaItens']]);


                    $dadosassociar = array (
                        'idplanilhaitens' => $params['idPlanilhaItens'],
                        'nomedoitem' => $planilhaItem['Descricao'],
                        'descricao' => $justificativa,
                        'idproduto' => $params['produto'],
                        'idetapa' => $params['etapa'],
                        'idagente' => $this->idUsuario,
                        'dtsolicitacao' => new Zend_Db_Expr($hoje),
                        'stestado' => '0'
                    );

                    $tbSolicitarItem = new Proposta_Model_DbTable_TbSolicitarItem();
                    $resultado = $tbSolicitarItem->insert($dadosassociar);

                    if ($resultado) {
                        parent::message("A solicita&ccedil;&atilde;o foi encaminhada ao Minc. Aguarde a resposta!", "/proposta/mantertabelaitens/solicitacoes/idPreProjeto=" . $this->idPreProjeto, "CONFIRM");
                    }

                }

//
//                if (!empty($idPlanilhaItens) && $idPlanilhaItens != "0") {
//                    $itemNome = $nomeItem[0]->NomeDoItem;
//                } else {
//                    $itemNome = $params['Descricao'];
//                }


//                $arrBusca = array();
//                $arrBusca['prod.codigo'] = $produto;
//                $arrBusca['et.idplanilhaetapa'] = $etapa;
//
//                //$res = MantertabelaitensDAO::buscarSolicitacoes($arrBusca,$itemNome);
//                $res = new MantertabelaitensDAO();
//                $res = $res->listarSolicitacoes($arrBusca, $itemNome);
////xd($res);
//                if (count($res) > 0) {
//                    throw new Exception("Cadastro duplicado de Produto na mesma etapa envolvendo o mesmo Item, transa&ccedil;&atilde;o cancelada!");
//                }


                if (empty($justificativa)) {
                    throw new Exception("Por favor, informe a justificativa!");
                } else if (strlen($justificativa) > 1000) {
                    throw new Exception("A justificativa n&atilde;o pode conter mais de 1000 caracteres!");

                } else if ($solicitacao == 'produtoetapa') {
                    //$associaritem = MantertabelaitensDAO::associaritem($dadosassociar);
                    $associaritem = new MantertabelaitensDAO();
                    $associaritem = $associaritem->associarItemObj($dadosassociar);
                    if ($associaritem) {
                        parent::message("A solicita&ccedil;&atilde;o foi encaminhada ao Minc. Aguarde a resposta!", "/proposta/mantertabelaitens/solicitacoes?idPreProjeto=" . $this->idPreProjeto, "CONFIRM");
                    }
                } else if ($solicitacao == 'novoitem') ;
                {
                    $incluiritem = false;
                    if (empty($NomeItem)) {
                        throw new Exception("Por favor, informe o nome do Item!");
                    } else if (strlen($params['Descricao']) > 100) {
                        throw new Exception("O nome do Item n&atilde;o pode conter mais de 100 caracteres!");
                    }

                    //codigo antigo
                    //$incluiritem = MantertabelaitensDAO::cadastraritem($Descricao, $this->idUsuario);
                    $incluiritem = new MantertabelaitensDAO();
                    $incluiritem = $incluiritem->cadastrarItemObj($dadosincluir);

                    if ($incluiritem) {
                        //$NovoItem = MantertabelaitensDAO::buscarItem($this->idUsuario);
                        //$dadosassociar['idPlanilhaItens'] = $NovoItem['idPlanilhaItens'];
                        $NovoItem = new MantertabelaitensDAO();
                        $NovoItem = $NovoItem->listarItem($this->idUsuario);
                        $dadosassociar['idPlanilhaItens'] = $NovoItem['idPlanilhaItens'];

                        parent::message("Cadastro realizado com sucesso!", "proposta/mantertabelaitens/solicitacoes?idPreProjeto=" . $this->idPreProjeto, "CONFIRM");
                        return;
                    } else {
                        throw new Exception("Erro ao cadastrar o Item!");
                    }
                }
            } catch (Exception $e) {

                parent::message($e->getMessage(), "proposta/mantertabelaitens/solicitaritens?idPreProjeto=" . $this->idPreProjeto, "ERROR");
                return;
            }
        }
    }

    /**
     * minhasSolicitacoesAction
     *
     * @access public
     * @return void
     */
    public function minhasSolicitacoesAction()
    {
        $mantertbitens = new MantertabelaitensDAO();
        $this->intTamPag = 10;

        //DEFINE PARAMETROS DE ORDENACAO / QTDE. REG POR PAG. / PAGINACAO
        if ($this->_request->getParam("qtde")) {
            $this->intTamPag = $this->_request->getParam("qtde");
        }
        $order = array();

        //==== parametro de ordenacao  ======//
        if ($this->_request->getParam("ordem")) {
            $ordem = $this->_request->getParam("ordem");
            if ($ordem == "ASC") {
                $novaOrdem = "DESC";
            } else {
                $novaOrdem = "ASC";
            }
        } else {
            $ordem = "ASC";
            $novaOrdem = "ASC";
        }

        //==== campo de ordenacao  ======//
        if ($this->_request->getParam("campo")) {
            $campo = $this->_request->getParam("campo");
            $order = array($campo . " " . $ordem);
            $ordenacao = "&campo=" . $campo . "&ordem=" . $ordem;

        } else {
            $campo = null;
            $order = array(2, 4, 6);
            $ordenacao = null;
        }

        $pag = 1;
        $get = Zend_Registry::get('get');
//        $this->view->idPreProjeto = $this->idPreProjeto;

        if (isset($get->pag)) $pag = $get->pag;
        $inicio = ($pag > 1) ? ($pag - 1) * $this->intTamPag : 0;

        /* ================== PAGINACAO ======================*/
        $auth = Zend_Auth::getInstance(); // pega a autenticacao
        $where = array();
        $where['sol.idAgente = ?'] = $auth->getIdentity()->IdUsuario;
        $where['sol.stEstado = ?'] = 1; // Atendido

        if (isset($_POST['tipoFiltro']) || isset($_GET['tipoFiltro'])) {
            $filtro = isset($_POST['tipoFiltro']) ? $_POST['tipoFiltro'] : $_GET['tipoFiltro'];
            $this->view->filtro = $filtro;
            switch ($filtro) {
                case '':
                    $where['sol.stEstado = ?'] = 1; // Atendido
                    $this->view->nmPagina = 'Atendido';
                    break;
                case 'solicitado':
                    $where['sol.stEstado = ?'] = 0; // Solicitado
                    $this->view->nmPagina = 'Solicitado';
                    break;
                case 'negado':
                    $where['sol.stEstado = ?'] = 2; // Negado
                    $this->view->nmPagina = 'Negado';
                    break;
            }
        } else {
            $where['sol.stEstado = ?'] = 1; // Atendido
            $this->view->nmPagina = 'Atendido';
        }

        $tbSolicitarItem = new Proposta_Model_DbTable_TbSolicitarItem();
        $total = $tbSolicitarItem->buscarItens($where, $order, null, null, true);
        $fim = $inicio + $this->intTamPag;

        $totalPag = (int)(($total % $this->intTamPag == 0) ? ($total / $this->intTamPag) : (($total / $this->intTamPag) + 1));
        $tamanho = ($fim > $total) ? $total - $inicio : $this->intTamPag;

        $busca = $tbSolicitarItem->buscarItens($where, $order, $tamanho, $inicio);
        $paginacao = array(
            "pag" => $pag,
            "qtde" => $this->intTamPag,
            "campo" => $campo,
            "ordem" => $ordem,
            "ordenacao" => $ordenacao,
            "novaOrdem" => $novaOrdem,
            "total" => $total,
            "inicio" => ($inicio + 1),
            "fim" => $fim,
            "totalPag" => $totalPag,
            "Itenspag" => $this->intTamPag,
            "tamanho" => $tamanho
        );

        $tbTitulacaoConselheiro = new tbTitulacaoConselheiro();
        $this->view->conselheiros = $tbTitulacaoConselheiro->buscarConselheirosTitulares();

        $this->view->paginacao = $paginacao;
        $this->view->qtdRegistros = $total;
        $this->view->dados = $busca;
        $this->view->intTamPag = $this->intTamPag;

        $tbsolicitacao = $mantertbitens->solicitacoes($this->idUsuario);
        $this->view->solicitacao = $tbsolicitacao;
    }

    /**
     * imprimirMinhasSolicitacoesAction
     *
     * @access public
     * @return void
     */
    public function imprimirMinhasSolicitacoesAction()
    {
        $this->intTamPag = 10;

        //DEFINE PARAMETROS DE ORDENACAO / QTDE. REG POR PAG. / PAGINACAO
        if ($this->_request->getParam("qtde")) {
            $this->intTamPag = $this->_request->getParam("qtde");
        }
        $order = array();

        //==== parametro de ordenacao  ======//
        if ($this->_request->getParam("ordem")) {
            $ordem = $this->_request->getParam("ordem");
            if ($ordem == "ASC") {
                $novaOrdem = "DESC";
            } else {
                $novaOrdem = "ASC";
            }
        } else {
            $ordem = "ASC";
            $novaOrdem = "ASC";
        }

        //==== campo de ordenacao  ======//
        if ($this->_request->getParam("campo")) {
            $campo = $this->_request->getParam("campo");
            $order = array($campo . " " . $ordem);
            $ordenacao = "&campo=" . $campo . "&ordem=" . $ordem;

        } else {
            $campo = null;
            $order = array(2, 4, 6);
            $ordenacao = null;
        }

        $pag = 1;
        $get = Zend_Registry::get('get');
//        $this->view->idPreProjeto = $get->idPreProjeto;

        if (isset($get->pag)) $pag = $get->pag;
        $inicio = ($pag > 1) ? ($pag - 1) * $this->intTamPag : 0;

        /* ================== PAGINACAO ======================*/
        $auth = Zend_Auth::getInstance(); // pega a autenticacao
        $where = array();
        $where['sol.idAgente = ?'] = $auth->getIdentity()->IdUsuario;
        $where['sol.stEstado = ?'] = 1; // Atendido

        if (isset($_POST['tipoFiltro']) || isset($_GET['tipoFiltro'])) {
            $filtro = isset($_POST['tipoFiltro']) ? $_POST['tipoFiltro'] : $_GET['tipoFiltro'];
            $this->view->filtro = $filtro;
            switch ($filtro) {
                case '':
                    $where['sol.stEstado = ?'] = 1; // Atendido
                    $this->view->nmPagina = 'Atendido';
                    break;
                case 'solicitado':
                    $where['sol.stEstado = ?'] = 0; // Solicitado
                    $this->view->nmPagina = 'Solicitado';
                    break;
                case 'negado':
                    $where['sol.stEstado = ?'] = 2; // Negado
                    $this->view->nmPagina = 'Negado';
                    break;
            }
        } else {
            $where['sol.stEstado = ?'] = 1; // Atendido
            $this->view->nmPagina = 'Atendido';
        }

        $tbSolicitarItem = new Proposta_Model_DbTable_TbSolicitarItem();
        $total = $tbSolicitarItem->buscarItens($where, $order, null, null, true);
        $fim = $inicio + $this->intTamPag;

        $totalPag = (int)(($total % $this->intTamPag == 0) ? ($total / $this->intTamPag) : (($total / $this->intTamPag) + 1));
        $tamanho = ($fim > $total) ? $total - $inicio : $this->intTamPag;

        $busca = $tbSolicitarItem->buscarItens($where, $order, $tamanho, $inicio);

        $this->view->qtdRegistros = $total;
        $this->view->dados = $busca;
        $this->_helper->layout->disableLayout(); // Desabilita o Zend Layout

    }

    /**
     * associaritemAction
     *
     * @access public
     * @return void
     */
    public function associaritemAction()
    {

    }

    /**
     * cadastraritemAction
     *
     * @access public
     * @return void
     */
    public function cadastraritemAction()
    {

    }

    /**
     * solicitacoesAction
     *
     * @access public
     * @return void
     */
    public function solicitacoesAction()
    {
        $tbsolicitacao = new MantertabelaitensDAO();
        $tbsolicitacao = $tbsolicitacao->solicitacao($this->idUsuario);

        $this->view->solicitacao = $tbsolicitacao;

        if ($_POST) {
            $tbsolicitacaos = MantertabelaitensDAO::solicitacoes($this->idUsuario);

            $html = '<table class="tabela">
			            <tr>
			                <th colspan="6" >Minhas Solicita&ccedil;&otilde;es</th>
			            </tr>
			            <tr>
			                <td><b>Produto</b></td>
			                <td><b>Etapa</b></td>
			                <td><b>Item Solicitado</b></td>
			                <td><b>Justificativa</b></td>
			                <td><b>Estado</b></td>
			                <td><b>Resposta</b></td>
			            </tr>';

            foreach ($tbsolicitacaos as $tbsolicitacao):
                $html .= '<tr>
			                <td>' . $tbsolicitacao->produto . '</td>
			                <td>' . $tbsolicitacao->etapa . '</td>
			                <td>' . $tbsolicitacao->itemsolicitado . '</td>
			                <td>' . $tbsolicitacao->justificativa . ' </td>
			                <td>' . $tbsolicitacao->estado . '</td>
			                <td>' . $tbsolicitacao->resposta . '</td>
			            </tr>';
            endforeach;
            $html .= '</table>';

            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();

            $pdf = new PDF($html, 'pdf');
            $pdf->gerarRelatorio();
        }
    }

    /**
     * exibirdadosAction
     *
     * @access public
     * @return void
     */
    public function exibirdadosAction()
    {

        if ($this->getRequest()->isPost()) {
            // recebe os dados via post
            $post = Zend_Registry::get('post');
            $tipoPesquisa = $post->TipoPesquisa;
            $item = $post->NomeDoItem;
            $etapa = $post->etapa;
            $produto = $post->produto;

            $this->view->tipopesquisa = $post->TipoPesquisa;
            $this->view->produto = $post->produto;
            $this->view->etapa = $post->etapa;
            $this->view->item = $post->NomeDoItem;

            //CODIGO ANTIGO
            //$tbpretitem = MantertabelaitensDAO::exibirprodutoetapaitem($item);
            $where = null;
            if ($item) {
                if ($tipoPesquisa == 1) {
                    $where["i.descricao LIKE (?)"] = "%" . $item . "%";
                } elseif ($tipoPesquisa == 2) {
                    $where["i.descricao LIKE (?)"] = "%" . $item;
                } elseif ($tipoPesquisa == 3) {
                    $where["i.descricao = ?"] = $item;
                } elseif ($tipoPesquisa == 4) {
                    $where["i.descricao <> ?"] = "%" . $item;
                }
            }

            $tbpretitem = new MantertabelaitensDAO();
            $tbpretitem = $tbpretitem->listarProdutoEtapaItem($item = null, $nomeitem = null, $etapa, $produto, $where);

            $this->view->pretitem = $tbpretitem;

            try {
                if ($tbpretitem) {
                } else {
                    throw new Exception("Dados n&atilde;o localizados");
                }

            } catch (Exception $e) {
                parent::message($e->getMessage(), "proposta/mantertabelaitens/exibirdados?idPreProjeto=" . $this->idPreProjeto, "ERROR");
            }
        }
    }

    /**
     * buscaetapasAction
     *
     * @access public
     * @return void
     */
    public function buscaetapasAction()
    {
        $this->_helper->layout->disableLayout();

        $idProduto = $_POST['idProduto'];

        $tbItens = new MantertabelaitensDAO();
        $this->view->etapas = $tbItens->exibirEtapa($idProduto);

        $this->view->idProduto = $idProduto;
    }

    /**
     * buscaitensAction
     *
     * @access public
     * @return void
     * @author wouerner <wouerner@gmail.com>
     */
    public function buscaitensAction()
    {
        $this->_helper->layout->disableLayout();

        $idProduto = $_POST['idProduto'];
        $idEtapa = $_POST['idEtapa'];

        $tbitens = new MantertabelaitensDAO();
        $this->view->itens = $tbitens->exibirItem($idProduto, $idEtapa);

        $this->view->idProduto = $idProduto;
        $this->view->idEtapa = $idEtapa;
    }

    /**
     * consultartabelaitensAction
     *
     * @access public
     * @return void
     */
    public function consultartabelaitensAction()
    {
        $post = Zend_Registry::get('post');

        $item = $post->NomeDoItem;

        $tbpretitem = new MantertabelaitensDAO();
        $this->view->pretitem = $tbpretitem->listarProdutoEtapaItem($item);;

        $tbproduto = new MantertabelaitensDAO();
        $this->view->produto = $tbproduto->listarProduto();

        $tbetapa = new MantertabelaitensDAO();
        $this->view->etapa = $tbetapa->listarEtapa();

        $tbitem = new MantertabelaitensDAO();
        $this->view->ites = $tbitem->listarItem();

        $buscardados = new MantertabelaitensDAO();
        $this->view->buscardados = $buscardados->produtoEtapaItem();
    }

    /**
     * imprimirAction
     *
     * @access public
     * @return void
     */
    public function imprimirAction()
    {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $post = Zend_Registry::get('post');

        if (empty($post->tipoPesquisa) && empty($post->item) && empty($post->etapa) && empty($post->produto)) {
            $this->_redirect("mantertabelaitens/exibirdados?idPreProjeto=" . $this->idPreProjeto);
        }
        $tipoPesquisa = $post->tipoPesquisa;
        $item = $post->item;
        $etapa = $post->etapa;
        $produto = $post->produto;

        $where = null;
        if ($tipoPesquisa == 1) {
            $where["i.descricao LIKE (?)"] = "%" . $item . "%";
        } elseif ($tipoPesquisa == 2) {
            $where["i.descricao LIKE (?)"] = "%" . $item;
        } elseif ($tipoPesquisa == 3) {
            $where["i.descricao = ?"] = $item;
        } elseif ($tipoPesquisa == 4) {
            $where["i.descricao <> ?"] = "%" . $item;
        }

        $tbpretitem = new MantertabelaitensDAO();
        $tbpretitem = $tbpretitem->listarProdutoEtapaItem($item = null, $nomeitem = null, $etapa, $produto, $where);

        $arr = array();
        $arrNomeProduto = array();
        foreach ($tbpretitem as $item) {
            $arr[$item->idProduto][$item->idEtapa][] = $item;
            $arrNomeProduto[$item->idProduto] = $item->Produto;

        }

        $html = '
                <table width="100%" style="font-family:Arial">
                    <tr>
                        <th style="font-size:20px;" colspan="3">
                            Relatório Produto/Etapa/Item
                        </th>
                    </tr>
                ';

        if (!empty($arr)) {
            $ct = 0;
            foreach ($arr as $chaveProduto => $Produto) {

                $html .= '
                            <tr>
                                <td colspan="3" align="left" style="background-color: #cccccc; font-size:14px; font-weight:bold;">
                                    Produto : ' . $arrNomeProduto[$chaveProduto] . '
                                </td>
                            </tr>';
                foreach ($Produto as $chaveEtapa => $Etapa) {
                    $html .= '
                                <tr>
                                    <td width="25px">  </td>
                                    <td colspan="2" align="left" style="background-color: #EFEFEF; font-size:14px; font-weight:bold;">
                                        Etapa: ' . $arr[$chaveProduto][$chaveEtapa][0]->Etapa . '
                                    </td>
                                </tr>';

                    foreach ($Etapa as $Item) {
                        $html .= '
                                        <tr>
                                        <td width="25px">  </td>
                                        <td width="25px">  </td>
                                        <td align="left">
                                                Item: ' . $Item->NomeDoItem . '
                                            </td>
                                        </tr>';
                    }
                }
            }
            $html .= '</table>';
            $ct++;
        }


        try {
            //echo $html; die;
            $pdf = new PDF($html, 'pdf');
            $pdf->gerarRelatorio();
        } catch (Exception $e) {
            xd($e->getMessage());
        }
    }

    /**
     * gerarpdfAction
     *
     * @access public
     * @return void
     * @todo retirar html
     */
    public function gerarpdfAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $output = '
			<style>
				th{
                                background:#ABDA5D;
                                color:#3A7300;
                                text-transform:uppercase;
                                font-size:14px;
        			font-weight: bold;
        			font-family: sans-serif;
        			height: 16px;
        			line-height: 16px;
                                border:1px #ccc solid;
        		}
        		td{
        			color:#000;
        			font-size:14px;
        			font-family: sans-serif;
        			height: 14px;
        			line-height: 14px;
                                border:1px #ccc solid;
        		}
        		.blue{
        			color: blue;
        		}
        		.red{
        			color: red;
        		}
        		.orange{
        			color: orange;
        		}
        		.green{
        			color: green;
        		}

        		.direita{
        			text-align: right;
        		}

        		.centro{
        			text-align: center;
        		}

			</style>';

        $output .= $_POST['html'];

        $patterns = array();
        $patterns[] = '/<table.*?>/is';
        $patterns[] = '/<thead>/is';
        $patterns[] = '/<\/thead>/is';
        $patterns[] = '/<tbody>/is';
        $patterns[] = '/<\/tbody>/is';
        $patterns[] = '/<col.*?>/is';
        $patterns[] = '/<a.*?>/is';

        $replaces = array();
        $replaces[] = '<table cellpadding="0" cellspacing="1" border="1" width="97%" align="center">';
        $replaces[] = '';
        $replaces[] = '';
        $replaces[] = '';
        $replaces[] = '';
        $replaces[] = '';
        $replaces[] = '';

        $output = preg_replace($patterns, $replaces, $output);

        $pdf = new PDF($output, 'pdf');
        $pdf->gerarRelatorio('h');
    }
}
