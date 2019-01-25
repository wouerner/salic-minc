<?php

class ComprovarexecucaofinanceiraController extends MinC_Controller_Action_Abstract
{
    private $modalidade    = array(' - Selecione - ','Convite','Tomada de Pre&ccedil;os','Concorr&ecirc;ncia','Concurso','Preg&atilde;o');
    private $tipoLicitacao = array(' - Selecione - ','Eletr&ocirc;nico','Eletr&ocirc;nico para registro de pre&ccedil;o','Eletr&ocirc;nico por desconto','Eletr&ocirc;nico por lote','Presencial','Presencial para registro de pre�o','Presencial para maior desconto');
    private $tipoCompra    = array(' - Selecione - ','Material','Servi&ccedil;o','Marterial/Servi&ccedil;o');
    private $tipoAquisicao = array(' - Selecione - ','Material','Servi&ccedil;o','Material/Servi&ccedil;o');
    private $tipoDocumento = array(' - Selecione - ','Cupom Fiscal','Guia de Recolhimento','Nota Fiscal/Fatura','Recibo de Pagamento','RPA');
    private $_vrSituacao   = false;

    public function init()
    {
        $idusuario = $this->_request->getParam('idusuario');
        $auth = Zend_Auth::getInstance(); // pega a autentica��o

        //script case
        if (!isset($auth->getIdentity()->usu_codigo)) {
            parent::perfil(4);

            $auth         = Zend_Auth::getInstance();

            $idpronac = $this->_request->getParam('idpronac');
            $ProjetosDao = new Projetos();
            $resp = $ProjetosDao->buscar(array('IdPRONAC = ? '=>"{$idpronac}"));
            if (
                $resp->count() && (
                    $resp[0]->Situacao == 'E12'
                    or $resp[0]->Situacao == 'E13'
                    or $resp[0]->Situacao == 'E15'
                    or $resp[0]->Situacao == 'E23'
                    or $resp[0]->Situacao == 'E50'
                    or $resp[0]->Situacao == 'E59'
                    or $resp[0]->Situacao == 'E60'
                    or $resp[0]->Situacao == 'E61'
                    or $resp[0]->Situacao == 'E62'
                    or $resp[0]->Situacao == 'E66'
                    or $resp[0]->Situacao == 'E69'
                    or $resp[0]->Situacao == 'E71'
                    or $resp[0]->Situacao == 'E72'
                    or $resp[0]->Situacao == 'E74'
                    or $resp[0]->Situacao == 'E75'
                    or $resp[0]->Situacao == 'E80'
                    or $resp[0]->Situacao == 'D28'
                    or $resp[0]->Situacao == 'D29'
                    or $resp[0]->Situacao == 'D34'
                    or $resp[0]->Situacao == 'D35'
                )
            ) {
                $this->_vrSituacao     =   false;
            } else {
                $this->_vrSituacao     =   true;
            }
            $this->view->vrSituacao = $this->_vrSituacao;
            $this->view->link_menu_lateral = 'javascript:history.back(-1)';

            parent::init(); // chama o init() do pai GenericControllerNew
        } else {
            $this->view->title = "Salic - Sistema de Apoio &agrave;s Leis de Incentivo &agrave; Cultura"; // t�tulo da p�gina

            $Usuario = new UsuarioDAO(); // objeto usu�rio
            $GrupoAtivo = new Zend_Session_Namespace('GrupoAtivo'); // cria a sess�o com o grupo ativo

            if ($auth->hasIdentity()) { // caso o usu�rio esteja autenticado
                // verifica as permiss�es
                $PermissoesGrupo = array();

                // permiss�es para UC25
                $PermissoesGrupo[] = 122;
                $PermissoesGrupo[] = 121;
                $PermissoesGrupo[] = 129;
                $PermissoesGrupo[] = 135; // tecnico
                $PermissoesGrupo[] = 134; // coordenador
                $PermissoesGrupo[] = 138; // tecnico de avalia��o
                $PermissoesGrupo[] = 139; // coordenador de avalia��o
                $PermissoesGrupo[] = 94; // parecerista
                // permiss�es para UC25

                if (!in_array($GrupoAtivo->codGrupo, $PermissoesGrupo)) { // verifica se o grupo ativo est� no array de permiss�es
                    parent::message("Voc&ecirc; n&atilde;o tem permiss&atilde;o para acessar essa &aacute;rea do sistema!", "principal/index", "ALERT");
                }

                // pega as unidades autorizadas, �rg�os e grupos do usu�rio (pega todos os grupos)
                $grupos = $Usuario->buscarUnidades($auth->getIdentity()->usu_codigo, 21);

                // manda os dados para a vis�o
                $this->view->usuario = $auth->getIdentity(); // manda os dados do usu�rio para a vis�o
                $this->view->arrayGrupos = $grupos; // manda todos os grupos do usu�rio para a vis�o
                $this->view->grupoAtivo = $GrupoAtivo->codGrupo; // manda o grupo ativo do usu�rio para a vis�o
                $this->view->orgaoAtivo = $GrupoAtivo->codOrgao; // manda o �rg�o ativo do usu�rio para a vis�o
            } else {
                return $this->_helper->redirector->goToRoute(array('controller' => 'index', 'action' => 'logout'), null, true);
            }

            $this->_vrSituacao      =   true;
            $this->view->vrSituacao =   $this->_vrSituacao;

            parent::init(); // chama o init() do pai GenericControllerNew
        }
        $this->view->idusuario = $idusuario;
        # context
        $this->_helper->getHelper('contextSwitch')
            ->addActionContext('cadastrarcomprovacaopagamento', 'json')
            ->initContext()
        ;
    } 

    public function indexAction()
    {
        /* =============================================================================== */
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        /* =============================================================================== */
        $this->verificarPermissaoAcesso(false, true, false);

        $idpronac = $this->_request->getParam('idpronac');
        $this->view->idpronac   = $idpronac;

        $dao        = new PlanilhaAprovacao();
        $resp = $dao->agruparPlanilhaAprovacao($this->view->idpronac);
        $DeParaPlanilhaAprovacaodao        = new DeParaPlanilhaAprovacao();
        foreach ($resp as $planilha) {
            $DeParaPlanilhaAprovacaodao->insert(array('idPlanilhaAprovacaoFilho'=>$planilha->idPlanilhaAprovacaoFilho,'idPlanilhaAprovacao'=>$planilha->idPlanilhaAprovacao));
        }
    }

    public function menuAction()
    {
        //verificar data da licita��o se antes de 2009
        $this->_helper->layout->disableLayout();

        $post       = Zend_Registry::get('post');
        $this->view->idpronac   = $post->idpronac;
    }

    public function dadosProjeto()
    {

        /* =============================================================================== */
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        /* =============================================================================== */
        $this->verificarPermissaoAcesso(false, true, false);
        $idpronac   = $this->getRequest()->getParam('idpronac');

        $projetosDAO    = new Projetos();
        $resposta       = $projetosDAO->buscar(array('IdPRONAC = ? '=>"{$idpronac}"));

        $this->view->pronac         = $resposta[0]->AnoProjeto.$resposta[0]->Sequencial;
        $this->view->nomeProjeto    = $resposta[0]->NomeProjeto;
    }

    public function pagamentoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);
        $this->dadosProjeto();

        $diligencia = new Diligencia();
        $auth = Zend_Auth::getInstance();

        $diligencia = $diligencia->aberta($this->getRequest()->getParam('idpronac'));
        // if ($diligencia->idTipoDiligencia == 174) {
        //     $this->_helper->getHelper('Redirector')
        //         ->setGotoSimple(
        //             'responder',
        //             'gerenciar',
        //             'diligencia',
        //             ['idpronac' => $this->getRequest()->getParam('idpronac')]
        //     );
        //     return;
        // }
        if ($diligencia->idTipoDiligencia == 174) {
            $this->_helper->getHelper('Redirector')
                ->setGotoSimple(
                    'comprovantes-recusados',
                    null,
                    null,
                    array('idpronac' => $this->getRequest()->getParam('idpronac')
                )
            );
            return;
        }

        // se nao estiver no periodo de comprovaco, limitar a comprovantes recusados
        if ($this->view->vrSituacao) {
            $this->_helper->getHelper('Redirector')
                ->setGotoSimple(
                    'comprovantes-recusados',
                    null,
                    null,
                    array('idpronac' => $this->getRequest()->getParam('idpronac')
                )
            );
        }

        $this->view->idpronac   = $this->getRequest()->getParam('idpronac');

        $planilhaAprovacaoModel = new PlanilhaAprovacao();
        $planilhaItemModel = new PlanilhaItem();

        /* $resposta = $planilhaAprovacaoModel->buscarItensPagamento($this->view->idpronac); //Alysson - Altera��o da Query para n�o mostrar os itens excluidos */

        $resposta = $planilhaAprovacaoModel->planilhaAprovada($this->view->idpronac);

        $arrayA =   array();
        $arrayP =   array();

        if (is_object($resposta)) {
            foreach ($resposta as $val) {
                $modalidade = '';

                $itemComprovacao = $planilhaItemModel->pesquisar($val->idPlanilhaAprovacao);

                if ($val->tpCusto == 'A') {
                    $arrayA[$val->descEtapa][$val->uf.' '.$val->cidade][$val->idPlanilhaItens] = array(
                        $val->descItem,
                        (float)$val->vlAprovado,
                        null,
                        (float)$val->vlComprovado,
                        $modalidade,
                        $idmod,
                        $val->idPlanilhaItens,
                        $val->uf,
                        $val->cdProduto,
                        $val->cdCidade,
                        $val->cdEtapa,
                        $val->idPlanilhaAprovacao
                    );
                }

                if ($val->tpCusto == 'P') {
                    $arrayP[$val->Descricao][$val->descEtapa][$val->uf.' '.$val->cidade][$val->idPlanilhaItens] = array(
                        $val->descItem,
                        (float)$val->vlAprovado,
                        null,
                        (float)$val->vlComprovado,
                        $modalidade,
                        $idmod,
                        $val->idPlanilhaItens,
                        $val->uf,
                        $val->cdProduto,
                        $val->cdCidade,
                        $val->cdEtapa,
                        $val->idPlanilhaAprovacao
                    );
                }
            }
        }

        $this->view->incFiscaisA   = array('Administra&ccedil;&atilde;o do Projeto' =>$arrayA);
        $this->view->incFiscaisP   = array('Custo por Produto' =>$arrayP);


        $this->_helper->getHelper('Redirector')
            ->setGotoSimple(
                'index',
                'pagamento',
                'prestacao-contas',
                array('idpronac' => $this->getRequest()->getParam('idpronac')
            )
        );
    }

    public function vincularcomprovacaoAction()
    {}

    public function licitacaoanteriorAction()
    {
        $this->_helper->layout->disableLayout();
        $this->view->etapaconteudo = array(array('id'=>1,'nome'=>'aaaaaaaaa'),array('id'=>2,'nome'=>'bbbbbbb'));
    }

    public function cadastrarlicitacaoAction()
    {
        $valido = true;
        $licitacaoDAO = new Licitacao();
        $post = Zend_Registry::get('post');

        $cadastro['tpCompra']                   =  $post->tipoCompra;
        $cadastro['tpmodalidade']               =  $post->modalidade;
        $cadastro['tpLicitacao']                =  $post->tipoLicitacao;
        $cadastro['nrProcesso']                 =  $post->nrProcesso;
        $cadastro['nrLicitacao']                =  $post->nrLicitacao;
        $cadastro['dsObjeto']                   =  $post->objeto;
        $cadastro['dsFundamentoLegal']          =  $post->fundamentoLegal;
        $cadastro['dtPublicacaoEdital']         =  data::dataAmericana($post->dataPublicacaoEdital);
        $cadastro['dtAberturaLicitacao']        =  data::dataAmericana($post->dataAberturaLicitacao);
        $cadastro['dtEncerramentoLicitacao']    =  data::dataAmericana($post->dataEncerramentoLicitacao);
        $cadastro['vlLicitacao']                =  preg_replace('/\.|\,/', '', $post->valorLicitacao)/100;
        $cadastro['dtHomologacao']              =  data::dataAmericana($post->dataHomologacao);
//        $cadastro['cdMunicipio']                =  $post->codigoMunicipio.' - '.$post->codigoMunicipioAux;
        $cadastro['cdMunicipio']                =  $post->campo_cidade;
        $cadastro['uf']                         =  $post->campo_uf;
        $cadastro['dsJustificativa']            =  $post->justificativa;

        if ($post->idlicitacao == '') {
            $idLicitcao     =   $licitacaoDAO->inserirLicitacao($cadastro);
            //cadastro contrato fim
            //cadastro itens de custo inicio
            foreach ($post->produto as $key=>$idProduto) {
                $dados['idLicitacao']            =   $idLicitcao;
                $dados['idEtapa']                =   $post->etapa[$key];
                $dados['idProduto']              =   $idProduto;
                $dados['idItem']                 =   $post->item[$key];

                $dados['idDispensaLicitacao']    =   '';
                $dados['idContrato']             =   '';
                $dados['idCotacao']              =   '';

                $this->cadastravinculoitemcusto($dados);

                if (!$this->view->resposta['vinculado']) {
                    $valido = false;
                }
            }
            //cadastro itens de custo fim
            if ($valido) {
                parent::message('Cadastro realizado com sucesso.', '/comprovarexecucaofinanceira/alterarlicitacao?idusuario='.$this->view->idusuario.'&idpronac='.$post->idpronac.'&idlicitacao='.$idLicitcao, 'CONFIRM');
            } else {
                parent::message('Falha na recupera��o dos dados', '/comprovarexecucaofinanceira/licitacao?idusuario='.$this->view->idusuario.'&idpronac='.$post->idpronac.'&idlicitacao='.$idLicitcao, 'ERROR');
            }
        } else {
            $licitacaoDAO->alterarLicitacao($cadastro, " idLicitacao = {$post->idlicitacao}");
            if ($valido) {
                parent::message('Altera��o realizada com sucesso.', '/comprovarexecucaofinanceira/licitacao?idusuario='.$this->view->idusuario.'&idpronac='.$post->idpronac, 'CONFIRM');
            } else {
                parent::message('Falha na recupera��o dos dados', '/comprovarexecucaofinanceira/licitacao?idusuario='.$this->view->idusuario.'&idpronac='.$post->idpronac, 'ERROR');
            }
        }
    }

    public function cadastrarcotacaoAction()
    {
        try {
            $this->_helper->layout->disableLayout();
            $post = Zend_Registry::get('post');
            $valido = true;

            // validar item
            if (!$post->produto) {
                throw new Exception('Item n�o selecionado ou inv�lido.');
            }

            //cadastro cotacao inicio
            $cadastro['nrCotacao'] = $post->nrCotacao;
            $cadastro['dsCotacao'] = $post->dsCotacao;
            $cadastro['dtCotacao'] = data::dataAmericana($post->dtCotacao);

            $cotacaoDAO = new Cotacao();
            $cotacaoxAgentesDao = new Cotacaoxagentes();

            if ($post->idcotacao == '') {
                $idCotacao = $cotacaoDAO->inserirCotacao($cadastro);
            } else {
                $idCotacao = $post->idcotacao;
                $cotacaoDAO->alterarCotacao($cadastro, " idCotacao = {$idCotacao} ");
                $cotacaoxAgentesDao->delete(" idCotacao = {$idCotacao} ");
                $CotacaoxPlanilhaAprovacao = new Cotacaoxplanilhaaprovacao();
                $CotacaoxPlanilhaAprovacao->delete(" idCotacao = {$idCotacao} ");
            }

            //cadastro fornecedor inicio
            $dadosFornecedor['idCotacao']           =   $idCotacao;
            $dadosFornecedor['DispensaLicitacao']   =   '';
            $dadosFornecedor['idLicitacao']         =   '';
            $dadosFornecedor['idContrato']          =   '';

            //******** FORNECEDOR 1 ************//
            if ($post->tpFornecedor1 == 'cpf') {
                $dadosFornecedor['TipoPessoa'] = 0;
                $dadosFornecedor['TipoNome'] = 18;
            } else {
                $dadosFornecedor['TipoPessoa'] = 1;
                $dadosFornecedor['TipoNome'] = 19;
            }
            $dadosFornecedor['idAgente'] = $post->idAgente1;
            $dadosFornecedor['CNPJCPF'] = preg_replace('/\.|-|\//', '', $post->CNPJCPF1);
            $dadosFornecedor['Descricao'] = $post->Descricao1;

            $idAgente1 = $this->cadastrarVinculoFornecedor($dadosFornecedor);
            $idCotacaoxAgentes1 = $cotacaoxAgentesDao->insert(array('idCotacao'=>$idCotacao,'idAgente'=>$idAgente1,'vlCotacao'=>Mascara::delMaskMoeda($post->vlCotacao1)));

            //******** FORNECEDOR 2 ************//
            if ($post->tpFornecedor2 == 'cpf') {
                $dadosFornecedor['TipoPessoa'] = 0;
                $dadosFornecedor['TipoNome'] = 18;
            } else {
                $dadosFornecedor['TipoPessoa'] = 1;
                $dadosFornecedor['TipoNome'] = 19;
            }
            $dadosFornecedor['idAgente'] = $post->idAgente2;
            $dadosFornecedor['CNPJCPF'] = preg_replace('/\.|-|\//', '', $post->CNPJCPF2);
            $dadosFornecedor['Descricao'] = $post->Descricao2;

            $idAgente2 = $this->cadastrarVinculoFornecedor($dadosFornecedor);
            $idCotacaoxAgentes2 = $cotacaoxAgentesDao->insert(array('idCotacao'=>$idCotacao,'idAgente'=>$idAgente2,'vlCotacao'=>Mascara::delMaskMoeda($post->vlCotacao2)));

            //******** FORNECEDOR 3 ************//
            if ($post->tpFornecedor3 == 'cpf') {
                $dadosFornecedor['TipoPessoa'] = 0;
                $dadosFornecedor['TipoNome'] = 18;
            } else {
                $dadosFornecedor['TipoPessoa'] = 1;
                $dadosFornecedor['TipoNome'] = 19;
            }
            $dadosFornecedor['idAgente'] = $post->idAgente3;
            $dadosFornecedor['CNPJCPF'] = preg_replace('/\.|-|\//', '', $post->CNPJCPF3);
            $dadosFornecedor['Descricao'] = $post->Descricao3;

            $idAgente3 = $this->cadastrarVinculoFornecedor($dadosFornecedor);
            $idCotacaoxAgentes3 = $cotacaoxAgentesDao->insert(array('idCotacao'=>$idCotacao,'idAgente'=>$idAgente3,'vlCotacao'=>Mascara::delMaskMoeda($post->vlCotacao3)));
            //cadastro fornecedor fim

            //cadastro itens de custo inicio
            $dados['idCotacao'] = $idCotacao;
            $dados['idEtapa'] = $post->etapaSelect;
            $dados['idProduto'] = $post->produtoSelect;
            $dados['idItem'] = $post->itensSelect;
            $dados['idFornecedor'] = $post->fornecedorSelect;
            $dados['idDispensaLicitacao'] = '';
            $dados['idLicitacao'] = '';
            $dados['idContrato'] = '';
            foreach ($post->produto as $key=>$idProduto) {
                $idCotacaoxAgente =  'idCotacaoxAgentes' . ($key + 1);
                $dados['idCotacao']              =   $idCotacao;
                $dados['idEtapa']                =   $post->etapa[$key];
                $dados['idProduto']              =   $idProduto;
                $dados['idItem']                 =   $post->item[$key];
                $dados['idCotacaoxAgente']       =   $$idCotacaoxAgente;
                $dados['idDispensaLicitacao']    =   '';
                $dados['idLicitacao']            =   '';
                $dados['idContrato']             =   '';
                $this->cadastravinculoitemcusto($dados);
                if (!$this->view->resposta['vinculado']) {
                    $valido = false;
                }
            }
            //cadastro itens de custo fim
            parent::message(
                'Salvo com sucesso.',
                "comprovarexecucaofinanceira/incluircotacao/idusuario/{$this->view->idusuario}/idpronac/{$post->idpronac}/idcotacao/{$idCotacao}",
                'CONFIRM'
            );
        } catch (Exception $e) {
            $this->view->message = $e->getMessage();
            $this->view->message_type = 'ERROR';
            $this->forward('incluircotacao');
        }
    }

    public function inserirfornecedorAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->ViewRenderer->setNoRender(true);
        $post = Zend_Registry::get('post');

        if (Validacao::validarCPF(preg_replace('/\.|-|\//', '', $post->CNPJCPF))) {
            $valido = true;
            //cadastro fornecedor inicio
            $dadosFornecedor['idLicitacao']     =   $post->idlicitacao;
            $dadosFornecedor['idAgente']        =   $post->idAgente;
            if ($post->tpFornecedor == 'cpf') {
                $dadosFornecedor['TipoPessoa']  =   0;
                $dadosFornecedor['TipoNome']    =   18;
            } else {
                $dadosFornecedor['TipoPessoa']  =   1;
                $dadosFornecedor['TipoNome']    =   19;
            }
            $dadosFornecedor['CNPJCPF']         =   preg_replace('/\.|-|\//', '', $post->CNPJCPF);
            $dadosFornecedor['Descricao']       =   $post->Descricao;

            $dadosFornecedor['DispensaLicitacao']   =   '';
            $dadosFornecedor['idContrato']          =   '';
            $dadosFornecedor['idCotacao']           =   '';

            $idAgente = $this->cadastrarVinculoFornecedor($dadosFornecedor);
            //cadastro fornecedor fim
            if ($idAgente == 'cadastrado') {
                $this->_helper->json(array('result'=>false,'mensagem'=>'Agente ja cadastrado!', 'fechar'=>'ok'));
            } elseif ($idAgente) {
                $this->_helper->json(array('result'=>true,'idAgente'=>$idAgente,'mensagem'=>'Adicionado com sucesso!', 'fechar'=>'ok'));
            } else {
                $this->_helper->json(array('result'=>false,'mensagem'=>'Erro ao adicionar agente!'));
            }
        } else {
            $this->_helper->json(array('result'=>false,'mensagem'=>'Erro ao adicionar agente. CPF/CNPJ inv&aacute;lido!', 'fechar'=>'ok'));
        }
    }

    public function cadastrarcontratoAction()
    {
        $this->_helper->layout->disableLayout();
        $post = Zend_Registry::get('post');

        /* =============================================================================== */
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        /* =============================================================================== */
        $this->verificarPermissaoAcesso(false, true, false);

        $idpronac = $post->idpronac;
        $valido = true;
        //cadastro contrato inicio
        $cadastro['nrContratoSequencial']   =  $post->numeroDoContratoSequencial;
        $cadastro['nrContratoAno']          =  isset($post->numeroDoContratoAno) ? $post->numeroDoContratoAno : date(Y);
        $cadastro['tpAquisicao']            =  $post->tipoAquisicao;
        $cadastro['dsObjetoContrato']       =  $post->objetoDoContrato;
        $cadastro['vlGlobal']               =  preg_replace('/\.|\,/', '', $post->valorGlobal)/100;
        $cadastro['dtInicioVigencia']       =  data::dataAmericana($post->dataVingenciaInicial);
        $cadastro['dtFimVigencia']          =  data::dataAmericana($post->dataVingenciaFinal);
        $cadastro['dtAssinatura']           =  data::dataAmericana($post->dataAssinatura);
        $contratoDAO    =   new Contrato();
        if ($post->idcontrato == '') {
            $cadastro['dtPublicacao']           =  date('Y-m-d');//'GETDATE()';
            $idContrato     =   $contratoDAO->inserirContrato($cadastro);
            //cadastro contrato fim
            //cadastro fornecedor inicio
            $dadosFornecedor['idContrato']  =   $idContrato;
            $dadosFornecedor['idAgente']    =   $post->idAgente;
            if ($post->tpFornecedor == 'cpf') {
                $dadosFornecedor['TipoPessoa']  =   0;
                $dadosFornecedor['TipoNome']    =   18;
            } else {
                $dadosFornecedor['TipoPessoa']  =   1;
                $dadosFornecedor['TipoNome']    =   19;
            }
            $dadosFornecedor['CNPJCPF']         =   preg_replace('/\.|-|\//', '', $post->CNPJCPF);
            $dadosFornecedor['Descricao']       =   $post->Descricao;

            $dadosFornecedor['DispensaLicitacao']   =   '';
            $dadosFornecedor['idLicitacao']         =   '';
            $dadosFornecedor['idCotacao']           =   '';

            if ($this->cadastrarVinculoFornecedor($dadosFornecedor)) {
                $valido = false;
            }
            //cadastro fornecedor fim
            //cadastro itens de custo inicio
            foreach ($post->produto as $key=>$idProduto) {
                $dados['idContrato']             =   $idContrato;
                $dados['idEtapa']                =   $post->etapa[$key];
                $dados['idProduto']              =   $idProduto;
                $dados['idItem']                 =   $post->item[$key];

                $dados['idDispensaLicitacao']    =   '';
                $dados['idLicitacao']            =   '';
                $dados['idCotacao']              =   '';

                $this->cadastravinculoitemcusto($dados);

                if (!$this->view->resposta['vinculado']) {
                    $valido = false;
                }
            }
            //cadastro itens de custo fim
            if ($valido) {
                //$this->view->report = array('result'=>true,'mensagem'=>'Cadastro realizado com sucesso.','idcontrato'=>$idContrato, 'fechar'=>'ok');
                parent::message('Cadastro realizado com sucesso.', '/comprovarexecucaofinanceira/contrato'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac, 'CONFIRM');
            } else {
                parent::message('Falha na recupera��o dos dados', '/comprovarexecucaofinanceira/contrato'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac, 'ERROR');
            }
        } else {
            $contratoDAO->alterarContrato($cadastro, " idContrato = {$post->idcontrato}");

            //cadastro fornecedor inicio
            $dadosFornecedor['idContrato']  =   $post->idcontrato;
            $dadosFornecedor['idAgente']    =   $post->idAgente;
            if ($post->tpFornecedor == 'cpf') {
                $dadosFornecedor['TipoPessoa']  =   0;
                $dadosFornecedor['TipoNome']    =   18;
            } else {
                $dadosFornecedor['TipoPessoa']  =   1;
                $dadosFornecedor['TipoNome']    =   19;
            }
            $dadosFornecedor['CNPJCPF']         =   preg_replace('/\.|-|\//', '', $post->CNPJCPF);
            $dadosFornecedor['Descricao']       =   $post->Descricao;

            $dadosFornecedor['DispensaLicitacao']   =   '';
            $dadosFornecedor['idLicitacao']         =   '';
            $dadosFornecedor['idCotacao']           =   '';


            if ($this->cadastrarVinculoFornecedor($dadosFornecedor)) {
                $valido = false;
            }
            //cadastro fornecedor fim
            if ($valido) {
                // $this->view->report = array('result'=>true,'mensagem'=>utf8_encode('Altera��o realizada com sucesso.'),'idcontrato'=>$post->idcontrato, 'fechar'=>'ok');
                parent::message('Altera��o realizada com sucesso.', '/comprovarexecucaofinanceira/contrato'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac, 'CONFIRM');
            } else {
                // $this->view->report = array('result'=>false,'mensagem'=>utf8_encode('Falha na recupera��o dos dados'));
                parent::message('Falha na recupera��o dos dados', '/comprovarexecucaofinanceira/contrato'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac, 'ERROR');
            }
        }
    }

    private function cadastrarVinculoFornecedor($dados)
    {
        if ($dados['idAgente'] == '') {
            $agentesDao =   new Agente_Model_DbTable_Agentes();
            $nomeDao    =   new Nomes();
            $auth = Zend_Auth::getInstance(); // instancia da autentica��o
            $idusuario  = $auth->getIdentity()->usu_codigo;
            $agentesDao->inserirAgentes(array('CNPJCPF'=>$dados['CNPJCPF'],'TipoPessoa'=>$dados['TipoPessoa'],'DtCadastro'=>date('Y-m-d'),'Status'=>'0','Usuario'=>$idusuario));
            $agentes = $agentesDao->buscar(array('CNPJCPF = ?'=>$dados['CNPJCPF']));

            $dados['idAgente'] = $agentes[0]->idAgente;
            $nomeDao->insert(array('idAgente'=>$dados['idAgente'],'Descricao'=>utf8_decode($dados['Descricao']),'TipoNome'=>$dados['TipoNome'],'Status'=>0,'Usuario'=>$idusuario));
        }
        if ($dados['idContrato']!='') {
            $contratoxAgentesDao = new Contratoxagentes();
            $resultado = $contratoxAgentesDao->buscar(array('idContrato = ? '=>$dados['idContrato']));
            if (count($resultado)==0) {
                $contratoxAgentesDao->insert(array('idContrato'=>$dados['idContrato'],'idAgente'=>$dados['idAgente']));
            } else {
                $idAgenteAntigo = $resultado[0]->idAgente;
                if ($idAgenteAntigo!=$dados['idAgente']) {
                    $contratoxAgentesDao->alterarContratoxAgentes(array('idAgente'=>$dados['idAgente']), " idContrato = {$dados['idContrato']} and idAgente = {$idAgenteAntigo}");
                }
            }
            return false;
        }
        if ($dados['DispensaLicitacao']) {
            return $dados['idAgente'];
        }
        if ($dados['idLicitacao']!='') {
            $licitacaoxAgentesDao = new Licitacaoxagentes();

            //verifica se o agente nao esta cadastrado.
            $cadastrado = false;
            $licitacaoAgentes = $licitacaoxAgentesDao->buscarFornecedoresLicitacao($dados['idLicitacao'])->toArray();

            foreach ($licitacaoAgentes as $la) {
                if (in_array($dados['idAgente'], $la)) {
                    $cadastrado = true;
                }
            }


            if ($cadastrado) {
                $dados['idAgente'] = 'cadastrado';
            } else {
                $licitacaoxAgentesDao->insert(array('idLicitacao'=>$dados['idLicitacao'],'idAgente'=>$dados['idAgente']));
            }

            return $dados['idAgente'];
        }

        if ($dados['idCotacao']!='') {
            return $dados['idAgente'];
        }

        return true;
    }

    public function cadastrarcomprovacaopagamentoAction()
    {
        $dtPagamento = $this->getRequest()->getParam('dtPagamento') ? new DateTime(data::dataAmericana($this->getRequest()->getParam('dtPagamento'))) : null;
        /* xd(empty($dtPagamento->__toString())); */
        $this->verificarPermissaoAcesso(false, true, false);

        try {
            $request = $this->getRequest();

            $pais = $this->getRequest()->getParam('pais');

            if (empty($pais)) {
                throw new Exception('Pa&iacute;s &eacute; obrigat&oacute;rio."');
            }

            $arquivoModel = new ArquivoModel();
            if ($pais == 'Brasil') {

                if (empty($dtPagamento)) {
                    throw new Exception('A data do pagamento � obrigat�ria.');
                }

                $arquivoModel->cadastrar('arquivo');
                $idArquivo = $arquivoModel->getId();
                if (empty($idArquivo)) {
                    throw new Exception('O arquivo deve ser PDF.');
                }

                $comprovantePagamentoModel = new ComprovantePagamento(
                    null,
                    $request->getParam('idAgente'),
                    $request->getParam('itemId'),
                    $request->getParam('tpDocumento'),
                    $request->getParam('nrComprovante'),
                    $request->getParam('nrSerie'),
                    $request->getParam('dtEmissao') ? new DateTime(data::dataAmericana($request->getParam('dtEmissao'))) : null,
                    $arquivoModel->getId(),
                    $request->getParam('tpFormaDePagamento'),
                    $dtPagamento,
                    str_replace(',', '.', str_replace('.', '', $request->getParam('vlComprovado'))),
                    $request->getParam('nrDocumentoDePagamento'),
                    $request->getParam('dsJustificativa')
                );

            } else {
                $arquivoModel->cadastrar('arquivoInternacional');
                $idArquivo = $arquivoModel->getId();
                if (empty($idArquivo)) {
                    throw new Exception('O arquivo deve ser PDF.');
                }
                $comprovantePagamentoModel = new ComprovantePagamentoInvoice(
                    null,
                    new FornecedorInvoice(
                        null,
                        $pais,
                        $request->getParam('nomeRazaoSocialInternacional'),
                        $request->getParam('enderecoInternacional')
                        ),
                    $request->getParam('itemId'),
                    $request->getParam('nif'),
                    $request->getParam('nrSerieInternacional'),
                    $request->getParam('dtEmissaoInternacional') ? new DateTime(data::dataAmericana($request->getParam('dtEmissaoInternacional'))) : null,
                    $arquivoModel->getId(),
                    new DateTime(),
                    str_replace(',', '.', str_replace('.', '', $request->getParam('vlComprovadoInternacional'))),
                    $request->getParam('dsJustificativaInternacional')
                );
            }

            $comprovantePagamentoModel->cadastrar();

            $this->_helper->flashMessenger('Comprovante cadastrado com sucesso.');
            $this->_helper->flashMessengerType('CONFIRM');
            $this->redirect(
                str_replace(
                    $this->view->baseUrl(),
                    '',
                    $this->view->url(
                        array(
                            'controller' => 'comprovarexecucaofinanceira',
                            'action' => 'comprovacaopagamento',
                            'idusuario' => $this->view->idusuario,
                            'idpronac' => $request->getParam('idpronac'),
                           )
                    )
                )
            );
        } catch (Exception $e) {
            $this->view->message = $e->getMessage();
            $this->view->message_type = 'ERROR';
            $this->forward('comprovacaopagamento');
        }
    }

    public function atualizarcomprovacaopagamentoAction()
    {
        $request = $this->getRequest();
        $idComprovantePagamento = $request->getParam('idComprovantePagamento');
        $idPronac = $request->getParam('idpronac');

        /*todos*/
        $planilhaAprovacao = new PlanilhaAprovacao();
        $planilhaAprovacaoItem = $planilhaAprovacao->vwComprovacaoFinanceiraProjetoPorItemOrcamentario(
            $idPronac,
            null,
            null,
            null,
            $idComprovantePagamento
        );

        $valorComprovadoAntigo = $planilhaAprovacaoItem->current()->vlComprovacao;
        $valoresItem = $planilhaAprovacao->vwComprovacaoFinanceiraProjeto(
            $idPronac,
            null,
            $planilhaAprovacaoItem->current()->cdEtapa,
            $planilhaAprovacaoItem->current()->cdProduto,
            $planilhaAprovacaoItem->current()->cdCidade,
            null,
            $planilhaAprovacaoItem->current()->idPlanilhaItem
        );
        $this->view->valores = $valoresItem->current();

        $valorAprovadoAtual = $valoresItem->current()->vlAprovado;
        $valorComprovadoAtual = $valoresItem->current()->vlComprovado;

        $valorComprovadoNovo = ($valorComprovadoAtual - $valorComprovadoAntigo) + $vlComprovadoNovo;
        /* var_dump($valorComprovadoNovo); */

        if ($valorComprovadoNovo > $valorAprovadoAtual) {
            throw new Exception('Valor comprovado acima do permitido!');
            return;
        }
        /*todo*/

        try {
            //$this->verificarPermissaoAcesso(false, true, false);
            $request = $this->getRequest();
            $pais = $request->getParam('pais');

            $paginaRedirecionar = $request->getParam('paginaRedirecionar');
            $redirectsValidos = array('comprovacaopagamento');
            if (!in_array($paginaRedirecionar, $redirectsValidos)) {
                $paginaRedirecionar = 'comprovantes-recusados';
            }

            if ($pais == 'Brasil') {
                $comprovantePagamentoModel = new ComprovantePagamento();
                $comprovantePagamento = $comprovantePagamentoModel->find($idComprovantePagamento)->current();

                $comprovantePagamentoModel = new ComprovantePagamento(
                    $idComprovantePagamento,
                    $request->getParam('idAgente'),
                    $request->getParam('itemId'),
                    $request->getParam('tpDocumento'),
                    $request->getParam('nrComprovante'),
                    $request->getParam('nrSerie'),
                    $request->getParam('dtEmissao') ? new DateTime(data::dataAmericana($request->getParam('dtEmissao'))) : null,
                    $comprovantePagamento->idArquivo,
                    $request->getParam('tpFormaDePagamento'),
                    $request->getParam('dtPagamento') ? new DateTime(data::dataAmericana($request->getParam('dtPagamento'))) : null,
                    str_replace(',', '.', str_replace('.', '', $request->getParam('vlComprovado'))),
                    $request->getParam('nrDocumentoDePagamento'),
                    $request->getParam('dsJustificativa')
                );
                if ($_FILES['arquivo']['name'] != '') {
                    $comprovantePagamentoModel->atualizar(4, true);
                } else {
                    // nao atualiza arquivo se n�o houver novo upload
                    $comprovantePagamentoModel->atualizar(4);
                }

                // internacional
            } else {

                // verificar se alterou alguma coisa do idAgente
                $fornecedorInternacional = new FornecedorInvoice();

                $dadosFornecedor = array();
                $dadosFornecedor['dsNome'] = $pais;
                $dadosFornecedor['dsEndereco'] = $request->getParam('nomeRazaoSocialInternacional');
                $dadosFornecedor['dsPais'] = $request->getParam('enderecoInternacional');

                $fornecedorInternacional->update(
                    $dadosFornecedor,
                    sprintf('idFornecedorExterior = %d', $request->getParam('idAgente'))
                );

                $comprovantePagamentoModel = new ComprovantePagamentoInvoice(
                    $idComprovantePagamento,
                    $request->getParam('idAgente'),
                    $request->getParam('itemId'),
                    $request->getParam('nif'),
                    $request->getParam('nrSerieInternacional'),
                    $request->getParam('dtEmissaoInternacional') ? new DateTime(data::dataAmericana($request->getParam('dtEmissaoInternacional'))) : null,
                    $request->getParam('arquivo_edit'),
                    new DateTime(),
                    str_replace(',', '.', str_replace('.', '', $request->getParam('vlComprovadoInternacional'))),
                    $request->getParam('dsJustificativaInternacional')
                );

                if ($_FILES['arquivoInternacional']['name'] != '') {
                    $comprovantePagamentoModel->atualizar(4, true);
                } else {
                    // nao atualiza arquivo se n�o houver novo upload
                    $comprovantePagamentoModel->atualizar(4);
                }
            }

            # View Parameters
            $this->view->comprovantePagamento = $comprovantePagamentoModel->toStdclass();

            $this->_helper->flashMessenger('Comprovante enviado com sucesso.');
            $this->_helper->flashMessengerType('CONFIRM');
            $this->redirect(
                str_replace(
                    $this->view->baseUrl(),
                    '',
                    $this->view->url(
                        array(
                            'controller' => 'comprovarexecucaofinanceira',
                            'action' => $paginaRedirecionar,
                            'idusuario' => $this->view->idusuario,
                            'idpronac' => $request->getParam('idpronac'),
                            'idPlanilhaAprovacao' => $request->getParam('idPlanilhaAprovacao'),
                        ),
                        null,
                        true
                    )
                )
            );
        } catch (Exception $e) {
            $message = $e->getMessage();
            if (strpos($e->getMessage(), 'DateTime::__construct()') !== false) {
                $message = 'Data de emissao inv�lida!';
            }
            $this->view->message = $message;
            $this->view->message_type = 'ERROR';
            $this->forward('comprovacaopagamento-recusado');
        }
    }

    public function excluircomprovacaopagamentoAction()
    {
        $this->_helper->layout->disableLayout();
        $post = Zend_Registry::get('post');

        $comprovantePagamentoDao = new ComprovantePagamento();
        $dadosComprovantePagamento = $comprovantePagamentoDao->buscar(
            array('idComprovantePagamento = ?' => $post->idComprovantePagamento,)
        );

        if (count($dadosComprovantePagamento)>0) {
            $tbComprovantePagamentoxPlanilhaAprovacao = new ComprovantePagamentoxPlanilhaAprovacao();
            $tbComprovantePagamentoxPlanilhaAprovacao->delete(
                array(
                    'idComprovantePagamento = ?' => $post->idComprovantePagamento,
                    'idPlanilhaAprovacao = ?' => $post->idPlanilhaAprovacao,
                )
            );

            # confere se ainda possui iten na planilha, caso nao, deleta a mesma
            $dados = $tbComprovantePagamentoxPlanilhaAprovacao->buscar(
                array('idComprovantePagamento = ?' => $post->idComprovantePagamento,)
            );
            if (!count($dados)) {
                # exclui arquivo
                $vwAnexarComprovantes = new vwAnexarComprovantes();
                $vwAnexarComprovantes->excluirArquivo($dadosComprovantePagamento[0]->idArquivo);
                # exclui comprovante
                $tbComprovantePagamento = new ComprovantePagamento();
                $tbComprovantePagamento->delete(
                    array(
                        'idComprovantePagamento = ?' => $post->idComprovantePagamento,
                        'idArquivo = ?' => $dadosComprovantePagamento[0]->idArquivo,
                    )
                );
            }
            $this->_helper->json(array('resposta'=>true));
        } else {
            $this->_helper->json(array('resposta'=>false));
        }
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function cadastrardispensaAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->_helper->layout->disableLayout();
        $post = Zend_Registry::get('post');
        $valido = true;
        //cadastro fornecedor inicio
        $idpronac = $post->idpronac;
        $dadosFornecedor['DispensaLicitacao']   =   true;
        $dadosFornecedor['idAgente']            =   $post->idAgente;
        if ($post->tpFornecedor == 'cpf') {
            $dadosFornecedor['TipoPessoa']      =   0;
            $dadosFornecedor['TipoNome']        =   18;
        } else {
            $dadosFornecedor['TipoPessoa']      =   1;
            $dadosFornecedor['TipoNome']        =   19;
        }
        $dadosFornecedor['CNPJCPF']             =   preg_replace('/\.|-|\//', '', $post->CNPJCPF);
        $dadosFornecedor['Descricao']           =   $post->Descricao;

        $dadosFornecedor['idLicitacao']         =   '';
        $dadosFornecedor['idCotacao']           =   '';
        $dadosFornecedor['idContrato']          =   '';

        $idAgente = $this->cadastrarVinculoFornecedor($dadosFornecedor);
        //cadastro fornecedor fim

        //cadastro contrato inicio
        $cadastro['nrDispensaLicitacao']    =  $post->nrDispensaLicitacao;
        $cadastro['idAgente']               =  $idAgente;
        $cadastro['dsDispensaLicitacao']    =  $post->motivoDispensa;
        $cadastro['vlContratado']           =  preg_replace('/\.|\,/', '', $post->valorContratado)/100;
        $cadastro['dtContrato']             =  data::dataAmericana($post->dataContrato);
        $dispensaLicitacaoDAO    =   new Dispensalicitacao();
        if ($post->iddispensa == '') {
            $idDispensaLicitacao     =   $dispensaLicitacaoDAO->inserirDispensaLicitacao($cadastro);
            //cadastro contrato fim

            //cadastro itens de custo inicio
            foreach ($post->produto as $key=>$idProduto) {
                $dados['idDispensaLicitacao']   =   $idDispensaLicitacao;
                $dados['idEtapa']               =   $post->etapa[$key];
                $dados['idProduto']             =   $idProduto;
                $dados['idItem']                =   $post->item[$key];

                $dados['idContrato']            =   '';
                $dados['idLicitacao']           =   '';
                $dados['idCotacao']             =   '';

                $this->cadastravinculoitemcusto($dados);

                if (!$this->view->resposta['vinculado']) {
                    $valido = false;
                }
            }
            //cadastro itens de custo fim
            if ($valido) {
                parent::message('Cadastro realizado com sucesso.', '/comprovarexecucaofinanceira/dispensa'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac, 'CONFIRM');
            } else {
                parent::message($this->view->resposta['mensagem'], '/comprovarexecucaofinanceira/dispensa'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac, 'ERROR');
            }
        } else {
            $dispensaLicitacaoDAO->alterarDispensaLicitacao($cadastro, " idDispensaLicitacao = {$post->iddispensa}");
            if ($valido) {
                parent::message('Altera��o realizada com sucesso.', '/comprovarexecucaofinanceira/dispensa'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac, 'CONFIRM');
            } else {
                parent::message($this->view->resposta['mensagem'], '/comprovarexecucaofinanceira/dispensa'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac, 'ERROR');
            }
        }
    }

    public function vincularitemcustoAction()
    {
        $this->_helper->layout->disableLayout();
        $post = Zend_Registry::get('post');
        if ($post->idcotacao == '' and $post->iddispensa == '' and $post->idlicitacao == '' and $post->idcontrato == '') {
            $this->view->resposta = array('vinculado' => true);
            // Validando se o item ja se encontra vinculado a planilha
            $planilhaAprovacaoDao = new PlanilhaAprovacao();
            $vinculo = $planilhaAprovacaoDao->buscarVinculo($this->getRequest()->getParam('idItem'));
            if ($vinculo->count()) {
                $this->view->resposta = array('vinculado' => false, 'mensagem' => utf8_encode('Este Item j� est� vinculado em outra Modalidade!'));
            }
        } else {
            $this->cadastravinculoitemcusto();
        }
    }

    private function cadastravinculoitemcusto($dados = array())
    {
        $post = Zend_Registry::get('post');
        if (count($dados)==0) {
            $dados['idDispensaLicitacao']    =   $post->iddispensa;
            $dados['idLicitacao']            =   $post->idlicitacao;
            $dados['idContrato']             =   $post->idcontrato;
            $dados['idCotacao']              =   $post->idcotacao;
            $dados['idFornecedor']           =   $post->idFornecedor;

            $dados['idEtapa']                =   $post->idEtapa;
            $dados['idProduto']              =   $post->idProduto;
            $dados['idItem']                 =   $post->idItem;
            $dados['idItem']                 =   $post->idItem;
        }
        $planilhaAprovacaoDao = new PlanilhaAprovacao();
        $idPlanilhaAprovacao = $dados['idItem'];
        if ($dados['idCotacao'] != '' or $dados['idDispensaLicitacao'] != '' or $dados['idLicitacao'] != '') {
            $continuar = true;
            $vinculo = $planilhaAprovacaoDao->buscarVinculo($idPlanilhaAprovacao);
            if (count($vinculo)>0) {
                $this->view->resposta = array('vinculado' => false, 'mensagem' => utf8_encode('Este Item j� est� vinculado em outra Modalidade!'));
                $continuar = false;
            }
            if ($continuar) {
                if ($dados['idCotacao'] != '') {
                    $CotacaoxAgentes = new Cotacaoxagentes();
                    $CotacaoxPlanilhaAprovacao = new Cotacaoxplanilhaaprovacao();
                    $insert = $CotacaoxPlanilhaAprovacao->insert(array('idCotacaoxAgentes' => $dados['idCotacaoxAgente'],'idCotacao'=>$dados['idCotacao'],'idPlanilhaAprovacao'=>$idPlanilhaAprovacao));
                }
                if ($dados['idDispensaLicitacao'] != '') {
                    $DispensaLicitacaoxPlanilhaAprovacao = new Dispensalicitacaoxplanilhaaprovacao();
                    $insert = $DispensaLicitacaoxPlanilhaAprovacao->insert(array('idDispensaLicitacao'=>$dados['idDispensaLicitacao'],'idPlanilhaAprovacao'=>$idPlanilhaAprovacao));
                }
                if ($dados['idLicitacao'] != '') {
                    $LicitacaoxPlanilhaAprovacao = new Licitacaoxplanilhaaprovacao();
                    $insert = $LicitacaoxPlanilhaAprovacao->insert(array('idLicitacao'=>$dados['idLicitacao'],'idPlanilhaAprovacao'=>$idPlanilhaAprovacao));
                }
            }
        }
        if ($dados['idContrato'] != '') {
            $continuar = true;
            $vinculo = $planilhaAprovacaoDao->buscarVinculoContrato($idPlanilhaAprovacao);

            if (count($vinculo)>0) {
                $this->view->resposta = array('vinculado' => false, 'mensagem' => utf8_encode('Este Item j� est� vinculado a um contrato!'));
                $continuar = false;
            }
            if ($continuar) {
                $ContratoxPlanilhaAprovacao = new Contratoxplanilhaaprovacao();
                $insert = $ContratoxPlanilhaAprovacao->insert(array('idContrato'=>$dados['idContrato'],'idPlanilhaAprovacao'=>$idPlanilhaAprovacao));
            }
        }
        if ($continuar) {
            if ($insert) {
                $this->view->resposta = array('vinculado'=>true);
            } else {
                $this->view->resposta = array('vinculado'=>false,'mensagem'=>'Problema ao vincular BD!');
            }
        }
    }

    public function incluircotacaoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->view->idcotacao = $this->getRequest()->getParam('idcotacao');
        $this->view->idpronac  = $this->getRequest()->getParam('idpronac');
        $this->view->idAgente1 = null;
        $this->view->idAgente2 = null;
        $this->view->idAgente3 = null;
        $this->view->itensVinculados = array();

        if ($this->view->idcotacao != '') {
            $cotacaoDao = new Cotacao();
            $resposta = $cotacaoDao->buscarCotacao($this->view->idcotacao);

            $this->view->nrCotacao = $resposta[0]->nrCotacao;
            $this->view->dsCotacao = $resposta[0]->dsCotacao;
            $this->view->dtCotacao = date('d/m/Y', strtotime($resposta[0]->dtCotacao));

            $tbCotacaoxplanilhaaprovacao = new Cotacaoxplanilhaaprovacao();
            $this->view->itensVinculados = $tbCotacaoxplanilhaaprovacao->itensVinculados($this->view->idcotacao);

            $ArquivoCotacaoDao = new Arquivocotacao();
            $this->view->documentosAnexados = $ArquivoCotacaoDao->buscarArquivos($this->view->idcotacao);

            $cotacaoxAgentesDao = new Cotacaoxagentes();
            $resposta = $cotacaoxAgentesDao->buscarAgentes(array('cxa.idCotacao = ?'=>$this->view->idcotacao));
        } elseif ($this->getRequest()->isPost()) {
            $resposta = array((object)$this->getRequest()->getPost());
            $resposta[0]->agentes = array();
            $resposta[0]->agentes[0] = new stdClass();
            $resposta[0]->agentes[0]->idAgente = $resposta[0]->idAgente1;
            $resposta[0]->agentes[0]->TipoPessoa = $resposta[0]->tpFornecedor1;
            $resposta[0]->agentes[0]->CNPJCPF = $resposta[0]->CNPJCPF1;
            $resposta[0]->agentes[0]->Descricao = $resposta[0]->Descricao1;
            $resposta[0]->agentes[0]->vlCotacao = str_replace(array('.', ','), array('', '.'), $resposta[0]->vlCotacao1);
            #
            $resposta[0]->agentes[1] = new stdClass();
            $resposta[0]->agentes[1]->idAgente = $resposta[0]->idAgente2;
            $resposta[0]->agentes[1]->TipoPessoa = $resposta[0]->tpFornecedor2;
            $resposta[0]->agentes[1]->CNPJCPF = $resposta[0]->CNPJCPF2;
            $resposta[0]->agentes[1]->Descricao = $resposta[0]->Descricao2;
            $resposta[0]->agentes[1]->vlCotacao = str_replace(array('.', ','), array('', '.'), $resposta[0]->vlCotacao2);
            #
            $resposta[0]->agentes[2] = new stdClass();
            $resposta[0]->agentes[2]->idAgente = $resposta[0]->idAgente3;
            $resposta[0]->agentes[2]->TipoPessoa = $resposta[0]->tpFornecedor3;
            $resposta[0]->agentes[2]->CNPJCPF = $resposta[0]->CNPJCPF3;
            $resposta[0]->agentes[2]->Descricao = $resposta[0]->Descricao3;
            $resposta[0]->agentes[2]->vlCotacao = str_replace(array('.', ','), array('', '.'), $resposta[0]->vlCotacao3);
            $resposta = $resposta[0]->agentes;
        }

        if (isset($resposta)) {
            $this->view->idAgente1      = $resposta[0]->idAgente;
            $this->view->TipoPessoa1    = $resposta[0]->TipoPessoa;
            $this->view->CNPJCPF1       = Validacao::mascaraCPFCNPJ($resposta[0]->CNPJCPF);
            $this->view->Descricao1     = $resposta[0]->Descricao;
            $this->view->vlCotacao1     = number_format($resposta[0]->vlCotacao, 2, ',', '.');
            $this->view->idAgente2      = $resposta[1]->idAgente;
            $this->view->TipoPessoa2    = $resposta[1]->TipoPessoa;
            $this->view->CNPJCPF2       = Validacao::mascaraCPFCNPJ($resposta[1]->CNPJCPF);
            $this->view->Descricao2     = $resposta[1]->Descricao;
            $this->view->vlCotacao2     = number_format($resposta[1]->vlCotacao, 2, ',', '.');
            $this->view->idAgente3      = $resposta[2]->idAgente;
            $this->view->TipoPessoa3    = $resposta[2]->TipoPessoa;
            $this->view->CNPJCPF3       = Validacao::mascaraCPFCNPJ($resposta[2]->CNPJCPF);
            $this->view->Descricao3     = $resposta[2]->Descricao;
            $this->view->vlCotacao3     = number_format($resposta[2]->vlCotacao, 2, ',', '.');
        }
    }

    public function incluirdispensaAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $get = Zend_Registry::get('get');
        $this->view->iddispensa = $get->iddispensa;
        $this->view->idpronac   =  $get->idpronac;
        $this->view->itensVinculados = array();

        if ($this->view->iddispensa != '') {
            $dispensaLicitacaoDao = new Dispensalicitacao();
            $resposta = $dispensaLicitacaoDao->buscarDispensaLicitacao(array(' dis.idDispensaLicitacao = ? '=>$this->view->iddispensa));

            $this->view->nrDispensaLicitacao        = $resposta[0]->nrDispensaLicitacao;
            $this->view->motivoDispensa             = $resposta[0]->dsDispensaLicitacao;
            $this->view->valorContratado            = number_format($resposta[0]->vlContratado, 2, ',', '.');
            $this->view->dataContrato               = date('d/m/Y', strtotime($resposta[0]->dtContrato));
            $this->view->TipoPessoa                 = $resposta[0]->TipoPessoa;
            $this->view->idAgente                   = $resposta[0]->idAgente;
            $this->view->CNPJCPF                    = Validacao::mascaraCPFCNPJ($resposta[0]->CNPJCPF);
            $this->view->Descricao                  = $resposta[0]->Descricao;

            $ArquivoDispensaLicitacaoDao = new Arquivodispensalicitacao();
            $this->view->documentosAnexados = $ArquivoDispensaLicitacaoDao->buscarArquivos($this->view->iddispensa);

            $tbDispensalicitacaoxplanilhaaprovacao = new Dispensalicitacaoxplanilhaaprovacao();
            $this->view->itensVinculados = $tbDispensalicitacaoxplanilhaaprovacao->itensVinculados($this->view->iddispensa);
        }
    }

    public function incluircontratoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->view->tipoAquisicaoConteudo = $this->tipoAquisicao;

        $post = Zend_Registry::get('get');
        $this->view->idcontrato = $post->idcontrato;
        $this->view->idpronac = $post->idpronac;
        $this->view->itensVinculados = array();

        if ($this->view->idcontrato != '') {
            $contratoDao = new Contrato();
            $resposta = $contratoDao->buscarContrato($this->view->idcontrato);

            $this->view->numeroDoContratoSequencial = $resposta[0]->nrContratoSequencial;
            $this->view->numeroDoContratoAno        = $resposta[0]->nrContratoAno;
            $this->view->tipoAquisicao              = $resposta[0]->tpAquisicao;
            $this->view->objetoDoContrato           = $resposta[0]->dsObjetoContrato;
            $this->view->valorGlobal                = number_format($resposta[0]->vlGlobal, 2, ',', '.');
            $this->view->dataVingenciaInicial       = date('d/m/Y', strtotime($resposta[0]->dtInicioVigencia));
            $this->view->dataVingenciaFinal         = date('d/m/Y', strtotime($resposta[0]->dtFimVigencia));
            $this->view->dataAssinatura             = date('d/m/Y', strtotime($resposta[0]->dtAssinatura));

            $contratoxAgentesDao    = new Contratoxagentes();
            $resposta               = $contratoxAgentesDao->buscarAgentes(array(' cxa.idContrato = ? '=>$this->view->idcontrato));

            $this->view->idAgente   =  $resposta[0]->idAgente;
            $this->view->TipoPessoa = $resposta[0]->TipoPessoa;
            $this->view->CNPJCPF    = Validacao::mascaraCPFCNPJ($resposta[0]->CNPJCPF);
            $this->view->Descricao  = $resposta[0]->Descricao;

            //$this->view->identificacaoContratante   = '111.111.222.58';

            $ArquivoContrataoDao = new Arquivocontrato();
            $this->view->documentosAnexados = $ArquivoContrataoDao->buscarArquivos($this->view->idcontrato);

            $tbContratoxplanilhaaprovacao = new Contratoxplanilhaaprovacao();
            $this->view->itensVinculados = $tbContratoxplanilhaaprovacao->itensVinculados($this->view->idcontrato);
        }
    }

    public function incluiritenscustoAction()
    {
        $this->_helper->layout->disableLayout();

        $this->view->identificacaoConteudo      = array(array('id'=>1,'nome'=>'dasdsasdsad'),array('id'=>2,'nome'=>'dsadsadasdasdsadsa'));
        $this->view->tipoAquisicaoConteudo      = array(array('id'=>1,'nome'=>'sfdsfdsfsdfsdf'),array('id'=>2,'nome'=>'sdfsdfsdgfgdgfdwerwer'));

        $this->view->etapa                      = 1;
        $this->view->itens                      = 1;
        $this->view->numeroDoContratoSequencial = '123121321';
        $this->view->numeroDoContratoAno        = '2010';
        $this->view->identificacao              = 1;
        $this->view->identificacaoContratante   = '111.111.222.58';
        $this->view->tipoAquisicao              = 2;
        $this->view->objetoDoContrato           = 'asdasdajshdjkas dkajs djashd jas hdhajks dhjakshd jash dkajshd jakshd jkashd jkash ds';
        $this->view->valorGlobal                = '12.323,12';
        $this->view->dataVingenciaInicial       = '03/09/2010';
        $this->view->dataVingenciaFinal         = '12/12/2010';
        $this->view->dataAssinatura             = '01/01/2011';
    }

    public function detalharlicitacaoAction()
    {
        //$this->_helper->layout->disableLayout();
        $this->view->modalidadeConteudo         = $this->modalidade;
        $this->view->tipoLicitacaoConteudo      = $this->tipoLicitacao;
        $this->view->tipoCompraConteudo         = $this->tipoCompra;
        $uf                                     = new Uf();
        $this->view->ufConteudo                 = $uf->buscar(array(), array('Sigla'));
        $get                                    = Zend_Registry::get('get');
        $this->view->idlicitacao                = $get->idlicitacao;
        $this->view->idpronac                   = $get->idpronac;

        $licitacaoDao   = new Licitacao();
        $resposta       = $licitacaoDao->buscarLicitacao($this->view->idlicitacao);

        $this->view->tipoCompra                 = $resposta[0]->tpCompra;
        $this->view->modalidade                 = $resposta[0]->tpModalidade;
        $this->view->tipoLicitacao              = $resposta[0]->tpLicitacao;
        $this->view->nrProcesso                 = $resposta[0]->nrProcesso;
        $this->view->nrLicitacao                = $resposta[0]->nrLicitacao;
        $this->view->objeto                     = $resposta[0]->dsObjeto;
        $this->view->fundamentoLegal            = $resposta[0]->dsFundamentoLegal;
        $this->view->dataPublicacaoEdital       = date('d/m/Y', strtotime($resposta[0]->dtPublicacaoEdital));
        $this->view->dataAberturaLicitacao      = date('d/m/Y', strtotime($resposta[0]->dtAberturaLicitacao));
        $this->view->dataEncerramentoLicitacao  = date('d/m/Y', strtotime($resposta[0]->dtEncerramentoLicitacao));
        $this->view->valorLicitacao             = $resposta[0]->vlLicitacao;
        $this->view->dataHomologacao            = date('d/m/Y', strtotime($resposta[0]->dtHomologacao));
        $this->view->dsMunicipio                = $resposta[0]->dsMunicipio;
        $this->view->dsEstado                   = $resposta[0]->dsEstado;
        $this->view->justificativa              = $resposta[0]->dsJustificativa;

        $licitacaoxagentesDao = new Licitacaoxagentes();
        $this->view->fornecedores = $licitacaoxagentesDao->buscarFornecedoresLicitacao($this->view->idlicitacao);

        $tbLicitacaoPlanilhaAprovacao = new Licitacaoxplanilhaaprovacao();
        $this->view->itensVinculados = $tbLicitacaoPlanilhaAprovacao->itensVinculados($this->view->idlicitacao);

        $ArquivoLicitacaoDao = new Arquivolicitacao();
        $this->view->documentosAnexados = $ArquivoLicitacaoDao->buscarArquivos($this->view->idlicitacao);
    }

    public function detalharcotacaoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $get = Zend_Registry::get('get');
        $this->view->idcotacao = $get->idcotacao;
        $this->view->idpronac = $get->idpronac;

        $cotacaoDao = new Cotacao();
        $resposta = $cotacaoDao->buscarCotacao($this->view->idcotacao);

        $this->view->nrCotacao  =  $resposta[0]->nrCotacao;
        $this->view->dsCotacao  =  $resposta[0]->dsCotacao;
        $this->view->dtCotacao  =  date('d/m/Y', strtotime($resposta[0]->dtCotacao));

        $cotacaoxAgentesDao = new Cotacaoxagentes();
        $resposta = $cotacaoxAgentesDao->buscarAgentes(array('cxa.idCotacao = ?'=>$this->view->idcotacao));

        $this->view->idAgente1      =   $resposta[0]->idAgente;
        $this->view->TipoPessoa1    =   $resposta[0]->TipoPessoa;
        $this->view->CNPJCPF1       =   Validacao::mascaraCPFCNPJ($resposta[0]->CNPJCPF);
        $this->view->Descricao1     =   $resposta[0]->Descricao;
        $this->view->vlCotacao1     =   number_format($resposta[0]->vlCotacao, 2, ',', '.');
        $this->view->idAgente2      =   $resposta[1]->idAgente;
        $this->view->TipoPessoa2    =   $resposta[1]->TipoPessoa;
        $this->view->CNPJCPF2       =   Validacao::mascaraCPFCNPJ($resposta[1]->CNPJCPF);
        $this->view->Descricao2     =   $resposta[1]->Descricao;
        $this->view->vlCotacao2     =   number_format($resposta[1]->vlCotacao, 2, ',', '.');
        $this->view->idAgente3      =   $resposta[2]->idAgente;
        $this->view->TipoPessoa3    =   $resposta[2]->TipoPessoa;
        $this->view->CNPJCPF3       =   Validacao::mascaraCPFCNPJ($resposta[2]->CNPJCPF);
        $this->view->Descricao3     =   $resposta[2]->Descricao;
        $this->view->vlCotacao3     =   number_format($resposta[2]->vlCotacao, 2, ',', '.');

        $this->view->documentosAnexados = array(array('id'=>1,'nome'=>utf8_encode('Documento de comprova��o'),'descricao'=>utf8_encode('Documento de comprova��o')));

        $tbCotacaoxplanilhaaprovacao = new Cotacaoxplanilhaaprovacao();
        $this->view->itensVinculados = $tbCotacaoxplanilhaaprovacao->itensVinculados($this->view->idcotacao);

        $ArquivoCotacaoDao = new Arquivocotacao();
        $this->view->documentosAnexados = $ArquivoCotacaoDao->buscarArquivos($this->view->idcotacao);
    }

    public function detalharcontratoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->view->tipoAquisicaoConteudo = $this->tipoAquisicao;

        $get = Zend_Registry::get('get');
        $this->view->idcontrato = $get->idcontrato;
        $this->view->idpronac = $get->idpronac;

        $contratoDao = new Contrato();
        $resposta = $contratoDao->buscarContrato($this->view->idcontrato);

        $this->view->numeroDoContratoSequencial = $resposta[0]->nrContratoSequencial;
        $this->view->numeroDoContratoAno        = $resposta[0]->nrContratoAno;
        $this->view->tipoAquisicao              = $resposta[0]->tpAquisicao;
        $this->view->objetoDoContrato           = $resposta[0]->dsObjetoContrato;
        $this->view->valorGlobal                = number_format($resposta[0]->vlGlobal, 2, ',', '.');
        $this->view->dataVingenciaInicial       = date('d/m/Y', strtotime($resposta[0]->dtInicioVigencia));
        $this->view->dataVingenciaFinal         = date('d/m/Y', strtotime($resposta[0]->dtFimVigencia));
        $this->view->dataAssinatura             = date('d/m/Y', strtotime($resposta[0]->dtAssinatura));

        $contratoxAgentesDao = new Contratoxagentes();
        $resposta = $contratoxAgentesDao->buscarAgentes(array(' cxa.idContrato = ? '=>$this->view->idcontrato));

        $tbContratoxplanilhaaprovacao = new Contratoxplanilhaaprovacao();
        $this->view->itensVinculados = $tbContratoxplanilhaaprovacao->itensVinculados($this->view->idcontrato);

        $this->view->idAgente   = $resposta[0]->idAgente;
        $this->view->TipoPessoa = $resposta[0]->TipoPessoa;
        $this->view->CNPJCPF    = Validacao::mascaraCPFCNPJ($resposta[0]->CNPJCPF);
        $this->view->Descricao  = $resposta[0]->Descricao;

        //$this->view->identificacaoContratante   = '111.111.222.58';

        $ArquivoContrataoDao = new Arquivocontrato();
        $this->view->documentosAnexados = $ArquivoContrataoDao->buscarArquivos($this->view->idcontrato);
    }

    public function detalhardispensaAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $post = Zend_Registry::get('get');
        $this->view->iddispensa = $post->iddispensa;
        $this->view->idpronac   =  $post->idpronac;

        $dispensaLicitacaoDao = new Dispensalicitacao();
        $resposta   = $dispensaLicitacaoDao->buscarDispensaLicitacao(array(' dis.idDispensaLicitacao = ? '=>$this->view->iddispensa));

        $this->view->nrDispensaLicitacao        =   $resposta[0]->nrDispensaLicitacao;
        $this->view->motivoDispensa             =   $resposta[0]->dsDispensaLicitacao;
        $this->view->valorContratado            =   number_format($resposta[0]->vlContratado, 2, ',', '.');
        $this->view->dataContrato               =   date('d/m/Y', strtotime($resposta[0]->dtContrato));
        $this->view->TipoPessoa                 =   $resposta[0]->TipoPessoa;
        $this->view->idAgente                   =   $resposta[0]->idAgente;
        $this->view->CNPJCPF                    =   Validacao::mascaraCPFCNPJ($resposta[0]->CNPJCPF);
        $this->view->Descricao                  =   $resposta[0]->Descricao;

        $tbDispensalicitacaoxplanilhaaprovacao = new Dispensalicitacaoxplanilhaaprovacao();
        $this->view->itensVinculados = $tbDispensalicitacaoxplanilhaaprovacao->itensVinculados($this->view->iddispensa);

        $ArquivoDispensaLicitacaoDao = new Arquivodispensalicitacao();
        $this->view->documentosAnexados = $ArquivoDispensaLicitacaoDao->buscarArquivos($this->view->iddispensa);
    }

    public function alterarlicitacaoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->view->modalidadeConteudo         = $this->modalidade;
        $this->view->tipoLicitacaoConteudo      = $this->tipoLicitacao;
        $this->view->tipoCompraConteudo         = $this->tipoCompra;
        $uf                                     = new Uf();
        $this->view->ufConteudo                 = $uf->buscar(array(), array('Sigla'));
        $get                                   = Zend_Registry::get('get');
        $this->view->idlicitacao                = $get->idlicitacao;
        $this->view->idpronac                   = $get->idpronac;
        $this->view->itensVinculados = array();
        $this->view->fornecedores = array();

        if ($this->view->idlicitacao != '') {
            $licitacaoDao   = new Licitacao();
            $resposta       = $licitacaoDao->buscarLicitacao($this->view->idlicitacao);

            $this->view->tipoCompra                 = $resposta[0]->tpCompra;
            $this->view->modalidade                 = $resposta[0]->tpModalidade;
            $this->view->tipoLicitacao              = $resposta[0]->tpLicitacao;
            $this->view->nrProcesso                 = $resposta[0]->nrProcesso;
            $this->view->nrLicitacao                = $resposta[0]->nrLicitacao;
            $this->view->objeto                     = $resposta[0]->dsObjeto;
            $this->view->fundamentoLegal            = $resposta[0]->dsFundamentoLegal;
            $this->view->dataPublicacaoEdital       = date('d/m/Y', strtotime($resposta[0]->dtPublicacaoEdital));
            $this->view->dataAberturaLicitacao      = date('d/m/Y', strtotime($resposta[0]->dtAberturaLicitacao));
            $this->view->dataEncerramentoLicitacao  = date('d/m/Y', strtotime($resposta[0]->dtEncerramentoLicitacao));
            $this->view->valorLicitacao             = $resposta[0]->vlLicitacao;
            $this->view->dataHomologacao            = date('d/m/Y', strtotime($resposta[0]->dtHomologacao));
            $this->view->codigoMunicipio            = $resposta[0]->cdMunicipio;
            $this->view->dsMunicipio                = $resposta[0]->dsMunicipio;
            $this->view->uf                         = $resposta[0]->UF;
            $this->view->justificativa              = $resposta[0]->dsJustificativa;

            $licitacaoxagentesDao = new Licitacaoxagentes();
            $this->view->fornecedores = $licitacaoxagentesDao->buscarFornecedoresLicitacao($this->view->idlicitacao);

            $tbLicitacaoPlanilhaAprovacao = new Licitacaoxplanilhaaprovacao();
            $this->view->itensVinculados = $tbLicitacaoPlanilhaAprovacao->itensVinculados($this->view->idlicitacao);

            $Municipios = new Municipios();
            $this->view->combocidades = $Municipios->combo(array('idUFIBGE = ?' => $resposta[0]->UF));
        }
    }

    public function excluiritenscustoAction()
    {
        $this->_helper->layout->disableLayout();
        $post = Zend_Registry::get('post');

        $idPlanilhaAprovacao = $post->idItem;

        $delete = false;
        if ($post->idcotacao) {
            $cotacaoxplanilhaaprovacaoDao = new Cotacaoxplanilhaaprovacao();
            if ($cotacaoxplanilhaaprovacaoDao->deletarCotacaoxPlanilhaAprovacao(" idPlanilhaAprovacao = {$idPlanilhaAprovacao} and idCotacao = {$post->idcotacao}")) {
                $delete = true;
            }
        }

        if ($post->iddispensa) {
            $dispensalicitacaoxplanilhaaprovacaoDao = new Dispensalicitacaoxplanilhaaprovacao();
            if ($dispensalicitacaoxplanilhaaprovacaoDao->deletarDispensaLicitacaoxPlanilhaAprovacao(" idPlanilhaAprovacao = {$idPlanilhaAprovacao} and idDispensaLicitacao = {$post->iddispensa}")) {
                $delete = true;
            }
        }
        if ($post->idlicitacao) {
            $licitacaoxplanilhaaprovacaoDao = new Licitacaoxplanilhaaprovacao();
            if ($licitacaoxplanilhaaprovacaoDao->deletarLicitacaoxPlanilhaAprovacao(" idPlanilhaAprovacao = {$idPlanilhaAprovacao} and idLicitacao = {$post->idlicitacao}")) {
                $delete = true;
            }
        }
        if ($post->idcontrato) {
            $contratoxplanilhaaprovacaoDao = new Contratoxplanilhaaprovacao();
            if ($contratoxplanilhaaprovacaoDao->deletarContratoxPlanilhaAprovacao(" idPlanilhaAprovacao = {$idPlanilhaAprovacao} and idContrato = {$post->idcontrato}")) {
                $delete = true;
            }
        }
        if ($delete) {
            $this->_helper->json(array('resp'=>true,'mensagem'=>utf8_encode('Exclu�do com sucesso!'), 'fechar'=>'ok'));
        } else {
            $this->_helper->json(array('resp'=>false,'mensagem'=>utf8_encode('N&atilde;o foi poss�vel!')));
        }
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function excluirdocumentoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->ViewRenderer->setNoRender(true);
        $post = Zend_Registry::get('post');

        $idlicitacao    =   $post->idlicitacao;
        $iddispensa     =   $post->iddispensa;
        $idcontrato     =   $post->idcontrato;
        $idcotacao      =   $post->idcotacao;
        $idArquivo      =   $post->id;

        $delete = false;
        if ($idlicitacao) {
            $ArquivoLicitacaoDao = new Arquivolicitacao();
            $delete = $ArquivoLicitacaoDao->delete("idLicitacao = {$idlicitacao} and idArquivo = {$idArquivo}");
        }
        if ($iddispensa) {
            $ArquivoDispensaLicitacaoDao = new Arquivodispensalicitacao();
            $delete = $ArquivoDispensaLicitacaoDao->delete("idDispensaLicitacao = {$iddispensa} and idArquivo = $idArquivo");
        }
        if ($idcontrato) {
            $ArquivoContratoDao = new Arquivocontrato();
            $delete = $ArquivoContratoDao->delete("idContrato = {$idcontrato} and idArquivo = {$idArquivo}");
        }
        if ($idcotacao) {
            $ArquivoCotacaoDao = new Arquivocotacao();
            $delete = $ArquivoCotacaoDao->delete("idCotacao = {$idcotacao} and idArquivo = {$idArquivo}");
        }

        if ($delete) {
            $this->_helper->json(array('retorno'=>true,'mensagem'=>'Excluido com sucesso', 'fechar'=>'ok'));
        } else {
            $this->_helper->json(array('retorno'=>false,'mensagem'=>'Erro ao excluir'.$iddispensa.' | '.$idArquivo));
        }
    }

    public function cotacaoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);
        $this->dadosProjeto();
        $this->view->idpronac   = $this->getRequest()->getParam('idpronac');

        $cotacaoDao = new Cotacao();
        $resposta = $cotacaoDao->buscarCotacaoProjeto($this->view->idpronac);

        $array = array();
        if ($resposta) {
            foreach ($resposta as $key=>$cotacao) {
                $array[$key] = array('idcotacao'   => $cotacao->idCotacao,
                                     'nrcotacao'   => $cotacao->nrCotacao,
                                     'descricao'   => $cotacao->dsCotacao,
                                     'datacotacao' => date('d/m/Y', strtotime($cotacao->dtCotacao)),
                                     'finalizado'  => false);
            }
        }
        $this->view->listacotacao = $array;
    }

    public function licitacaoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->dadosProjeto();
        $this->view->idpronac   = $this->getRequest()->getParam('idpronac');

        $licitacaoDao = new Licitacao();
        $resposta = $licitacaoDao->buscarLicitacaoProjeto($this->view->idpronac);

        $array = array();
        if ($resposta) {
            foreach ($resposta as $key=>$licitacao) {
                $array[$key] = array('idlicitacao'    => $licitacao->idLicitacao,
                                     'nrLicitacao'    => $licitacao->nrLicitacao,
                                     'Modalidade'     => $this->modalidade[$licitacao->tpModalidade],
                                     'dataPublicacao' => date('d/m/Y', strtotime($licitacao->dtAberturaLicitacao)),
                                     'finalizado'     => false);
            }
        }
        $this->view->listaLicitacao = $array;
    }

    public function dispensaAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->dadosProjeto();
        $this->view->idpronac = $this->getRequest()->getParam('idpronac');

        $dispensaDao = new Dispensalicitacao();
        $resposta = $dispensaDao->buscarDispensaProjeto($this->view->idpronac);

        $array = array();
        if ($resposta) {
            foreach ($resposta as $key=>$dispensalicitacao) {
                $array[$key] = array('idDispensa' => $dispensalicitacao->idDispensaLicitacao,
                                     'nrDispensa' => $dispensalicitacao->nrDispensaLicitacao,
                                     'dsDispensa' => $dispensalicitacao->dsDispensaLicitacao,
                                     'dtContrato' => date('d/m/Y', strtotime($dispensalicitacao->dtContrato)),
                                     'finalizado' => false);
            }
        }
        $this->view->listadispensa = $array;
    }

    public function contratoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);
        $this->dadosProjeto();
        $this->view->idpronac   = $this->getRequest()->getParam('idpronac');

        $contratoDao = new Contrato();
        $resposta = $contratoDao->buscarContratoProjeto($this->view->idpronac);

        $array = array();
        if ($resposta) {
            foreach ($resposta as $key=>$licitacao) {
                $array[$key] = array('idcontrato'     => $licitacao->idContrato,
                                     'nrcontrato'     => $licitacao->nrContratoSequencial . '/' . $licitacao->nrContratoAno,
                                     'datapublicacao' => date('d/m/Y', strtotime($licitacao->dtPublicacao)),
                                     'finalizado'     => false);
            }
        }
        $this->view->listacontrato = $array;
    }

    public function comprovacaopagamentoAction()
    {
        $this->verificarPermissaoAcesso(false, true, false);

        $idPronac = $this->getRequest()->getParam('idpronac');
        $idPlanilhaAprovacao = $this->getRequest()->getParam('idPlanilhaAprovacao');
        $idPlanilhaItens = $this->getRequest()->getParam('idPlanilhaItens');
        $idComprovantePagamento = $this->getRequest()->getParam('idComprovantePagamento');
        $uf = $this->getRequest()->getParam('uf');
        $cdproduto = $this->getRequest()->getParam('produto');
        $cdcidade = $this->getRequest()->getParam('cidade');
        $cdetapa = $this->getRequest()->getParam('etapa');

        $tblProjetos = new Projetos();
        $projeto = $tblProjetos->buscarTodosDadosProjeto($idPronac);

        $planilhaItemModel = new PlanilhaItem();
        $produtoModel = new Produto();
        $etapaModel = new PlanilhaEtapa();
        $itemModel = new PlanilhaItem();

        $itemPlanilhaAprovacao = $planilhaItemModel->buscarItemDaAprovacao($idPlanilhaAprovacao);

        $produto = $produtoModel->find($itemPlanilhaAprovacao->idProduto)->current();
        $etapa = $etapaModel->find($itemPlanilhaAprovacao->idEtapa)->current();
        $item = $itemModel->find($idPlanilhaItens)->current();

        /*todo*/
        $planilhaAprovacao = new PlanilhaAprovacao();
        $valoresItem = $planilhaAprovacao->planilhaAprovada(
            $idPronac,
            $uf,
            $cdetapa,
            $cdproduto,
            $cdcidade,
            null,
            $idPlanilhaItens
        );

        $this->view->valores = $valoresItem->current();

        $fornecedorModel = new FornecedorModel();
        $fornecedor = $fornecedorModel->pesquisarFornecedorItem($idPlanilhaAprovacao);

        if ($fornecedor) {
            $fornecedor = (object) array_map('utf8_encode', $fornecedor);

            $cpfCnpj = $fornecedor->CNPJCPF;
            $fornecedorUsaCnpj = 14 == strlen($cpfCnpj);
            $fornecedor->CNPJCPF = $fornecedorUsaCnpj ? Mascara::addMaskCNPJ($cpfCnpj) : Mascara::addMaskCPF($cpfCnpj);
            $fornecedor->usaCnpj = $fornecedorUsaCnpj;
            $this->view->fornecedor = $fornecedor;
        }

        $comprovantePagamentoModel = new ComprovantePagamento();
        /* $comprovantesDePagamento = $comprovantePagamentoModel */
        /*     ->pesquisarComprovantePorItem( */
        /*         $item->idPlanilhaItens, */
        /*         $idPronac, */
        /*         $etapa->idPlanilhaEtapa, */
        /*         $itemPlanilhaAprovacao->idProduto, */
        /*         $itemPlanilhaAprovacao->idUFDespesa, */
        /*         $itemPlanilhaAprovacao->idMunicipioDespesa); //ID Recuperado */

        $comprovantesDePagamento = $planilhaAprovacao->vwComprovacaoFinanceiraProjetoPorItemOrcamentario(
                $idPronac,
                $idPlanilhaItens,
                null,
                $cdproduto,
                null,
                $cdcidade
            )->toArray();

        array_walk($comprovantesDePagamento, function (&$comprovanteDePagamento) use ($fornecedorModel) {
            $comprovanteDePagamento = (object) $comprovanteDePagamento;

            if ($comprovanteDePagamento->idFornecedor) {
                $fornecedor = $fornecedorModel
                    ->find($comprovanteDePagamento->idFornecedor)
                    ->current();
                if ($fornecedor) {
                    $cpfCnpj = $fornecedor->CNPJCPF;
                    $fornecedorUsaCnpj = 14 == strlen($cpfCnpj);
                    $fornecedor->CNPJCPF = $fornecedorUsaCnpj ? Mascara::addMaskCNPJ($cpfCnpj) : Mascara::addMaskCPF($cpfCnpj);
                }
            } elseif ($comprovanteDePagamento->idFornecedorExterior) {
                $fornecedor = new stdClass();
                $fornecedor->CNPJCPF = '<em>Fornecedor estrangeiro</em>';
            }

            $comprovanteDePagamento->fornecedor = $fornecedor;
            unset($comprovanteDePagamento->idFornecedor);
        });

        $pais = new Pais();
        $paises = $pais->buscar(array(), 'Descricao');

        $this->view->produto = $produto;
        $this->view->etapa = $etapa;
        $this->view->item = $item;
        $this->view->itemPlanilhaAprovacao = $itemPlanilhaAprovacao;
        $this->view->comprovantes = $comprovantesDePagamento;
        $this->view->paises = $paises;

        if ($this->getRequest()->isPost()) {
            $this->view->vlComprovado = filter_input(INPUT_POST, 'vlComprovado');
            $this->view->idAgente = filter_input(INPUT_POST, 'idAgente');
            $this->view->CNPJCPF = filter_input(INPUT_POST, 'CNPJCPF');
            $this->view->Descricao = filter_input(INPUT_POST, 'Descricao');
            $this->view->tpDocumento = filter_input(INPUT_POST, 'tpDocumento');
            $this->view->nrComprovante = filter_input(INPUT_POST, 'nrComprovante');
            $this->view->nrSerie = filter_input(INPUT_POST, 'nrSerie');
            $this->view->dtEmissao = filter_input(INPUT_POST, 'dtEmissao');
            $this->view->tpFormaDePagamento = filter_input(INPUT_POST, 'tpFormaDePagamento');
            $this->view->nrDocumentoDePagamento = filter_input(INPUT_POST, 'nrDocumentoDePagamento');
            $this->view->dsJustificativa = filter_input(INPUT_POST, 'dsJustificativa');
        } elseif ($idComprovantePagamento) {
            $comprovanteAtualizar = current($comprovantePagamentoModel->pesquisarComprovante($idComprovantePagamento));

            $this->view->idComprovantePagamento = $idComprovantePagamento;
            $this->view->vlComprovacao = $comprovanteAtualizar['vlComprovacao'];

            if ($comprovanteAtualizar['idFornecedor']) {
                $fornecedorModel = new FornecedorModel();
                $fornecedor = $fornecedorModel->pesquisarFornecedor($comprovanteAtualizar['idFornecedor']);
                $this->view->paisFornecedor = 'Brasil';
                $this->view->exterior = false;

                $this->view->idAgente = $comprovanteAtualizar['idFornecedor'];
                $fornecedor->usaCnpj = 14 == strlen($fornecedor->CNPJCPF);
                $this->view->idPlanilhaAprovacao = $idPlanilhaAprovacao;
                $this->view->CNPJCPF = $fornecedor->CNPJCPF;
                $this->view->fornecedor = $fornecedor;
                $this->view->Descricao = $fornecedor->Descricao;
                $this->view->tpDocumento = $comprovanteAtualizar['tpDocumento'];
                $this->view->idArquivo = $comprovanteAtualizar['idArquivo'];
                $this->view->nomeArquivo = $comprovanteAtualizar['nmArquivo'];
                $this->view->nrComprovante = $comprovanteAtualizar['nrComprovante'];
                $this->view->nrSerie = $comprovanteAtualizar['nrSerie'];
                $this->view->dtEmissao = $comprovanteAtualizar['dtEmissao'];
                $this->view->tpFormaDePagamento = $comprovanteAtualizar['tpFormaDePagamento'];
                $this->view->nrDocumentoDePagamento = $comprovanteAtualizar['nrDocumentoDePagamento'];
                $this->view->JustificativaTecnico = $comprovanteAtualizar['JustificativaTecnico'];
                $this->view->dsJustificativa = $comprovanteAtualizar['dsJustificativa'];
                $this->view->dtPagamento = $comprovanteAtualizar['dtPagamento'];
            } elseif ($comprovanteAtualizar['idFornecedorExterior']) {
                $fornecedorInvoice = new FornecedorInvoice();

                $where = array();
                $where['idFornecedorExterior = ? '] = $comprovanteAtualizar['idFornecedorExterior'];
                $fornecedor = $fornecedorInvoice->buscar($where);
                $this->view->paisFornecedor = $fornecedor[0]->dsNome;
                $this->view->exterior = true;

                $this->view->idAgente = $comprovanteAtualizar['idFornecedorExterior'];
                $this->view->idPlanilhaAprovacao = $idPlanilhaAprovacao;
                $this->view->fornecedor = $fornecedor;
                $this->view->tpDocumento = $comprovanteAtualizar['tpDocumento'];
                $this->view->idArquivo = $comprovanteAtualizar['idArquivo'];
                $this->view->nomeArquivo = $comprovanteAtualizar['nmArquivo'];
                $this->view->nrComprovante = $comprovanteAtualizar['nrComprovante'];
                $this->view->nrSerie = $comprovanteAtualizar['nrSerie'];
                $this->view->dtEmissao = $comprovanteAtualizar['dtEmissao'];
                $this->view->tpFormaDePagamento = $comprovanteAtualizar['tpFormaDePagamento'];
                $this->view->nrDocumentoDePagamento = $comprovanteAtualizar['nrDocumentoDePagamento'];
                $this->view->JustificativaTecnico = $comprovanteAtualizar['JustificativaTecnico'];
                $this->view->dsJustificativa = $comprovanteAtualizar['dsJustificativa'];
                $this->view->dtPagamento = $comprovanteAtualizar['dtPagamento'];
            }
        }

        $this->view->situacao = $projeto->current()->Situacao;
        $this->view->idpronac = $this->getRequest()->getParam('idpronac');
        $this->view->tipoDocumentoConteudo = $this->tipoDocumento;
    }

    public function comprovacaopagamentoRecusadoAction()
    {
        $idPlanilhaAprovacao = $this->getRequest()->getParam('idPlanilhaAprovacao');
        $idComprovantePagamento = $this->getRequest()->getParam('idComprovantePagamento');
        $idpronac = $this->getRequest()->getParam('idpronac');

        try {
            $planilhaItemModel = new PlanilhaItem();

            $itemPlanilhaAprovacao = $planilhaItemModel->buscarItemDaAprovacao($idPlanilhaAprovacao);

            $planilhaAprovacao = new PlanilhaAprovacao();
            $planilhaAprovacaoItem = $planilhaAprovacao->vwComprovacaoFinanceiraProjetoPorItemOrcamentario(
                $idpronac,
                null,
                null,
                null,
                $idComprovantePagamento
            );

            $valoresItem = $planilhaAprovacao->vwComprovacaoFinanceiraProjeto(
                $idpronac,
                null,
                $planilhaAprovacaoItem->current()->cdEtapa,
                $planilhaAprovacaoItem->current()->cdProduto,
                $planilhaAprovacaoItem->current()->cdCidade,
                null,
                $planilhaAprovacaoItem->current()->idPlanilhaItem
            );

            $this->view->valores = $valoresItem->current();

            if (empty($itemPlanilhaAprovacao)) {
                throw new Exception("Erro! O item para comprova&ccedil;&atilde;o n&atilde;o foi encontrado!");
            }

            $produtoModel = new Produto();
            $produto = $produtoModel->find($itemPlanilhaAprovacao->idProduto)->current();
            $etapaModel = new PlanilhaEtapa();
            $etapa = $etapaModel->find($itemPlanilhaAprovacao->idEtapa)->current();
            $itemModel = new PlanilhaItem();
            $item = $itemModel->find($itemPlanilhaAprovacao->idPlanilhaItem)->current();

            $this->view->idpronac = $itemPlanilhaAprovacao->IdPRONAC;

            $pais = new Pais();
            $paises = $pais->buscar(array(), 'Descricao');
            $this->view->paises = $paises;

            $this->view->produto = $produto;
            $this->view->etapa = $etapa;
            $this->view->item = $item;
            $this->view->itemPlanilhaAprovacao = $itemPlanilhaAprovacao;
            # compatibilidade com o template da outra action
            $this->view->ckItens = array();
            $this->view->tipoDocumentoConteudo = $this->tipoDocumento;

            $comprovantePagamentoModel = new ComprovantePagamento();
            $comprovantesDePagamento = $comprovantePagamentoModel->pesquisarComprovante($idComprovantePagamento, Zend_DB::FETCH_OBJ);

            $comprovantePagamento = (object) $comprovantesDePagamento[0];

            $this->view->idComprovantePagamento = $idComprovantePagamento;
            $this->view->vlComprovacao = $comprovantePagamento->vlComprovacao;

            $fornecedorModel = new FornecedorModel();
            $this->view->idAgente = $comprovantePagamento->idFornecedor;
            $fornecedor = $fornecedorModel->pesquisarFornecedor($comprovantePagamento->idFornecedor);

            if ($fornecedor) {
                $cpfCnpj = $fornecedor->CNPJCPF;
                $fornecedorUsaCnpj = 14 == strlen($cpfCnpj);
                $fornecedor->CNPJCPF = $fornecedorUsaCnpj ? Mascara::addMaskCNPJ($cpfCnpj) : Mascara::addMaskCPF($cpfCnpj);
                $fornecedor->usaCnpj = $fornecedorUsaCnpj;
                $this->view->fornecedor = $fornecedor;
                $this->view->Descricao = $fornecedor->Descricao;
                $this->view->CNPJCPF = $fornecedor->CNPJCPF;
            }

            $dataEmissao = $comprovantePagamento->dtEmissao ? new DateTime(data::dataAmericana($comprovantePagamento->dtEmissao)) : new DateTime();
            $dataPagamento = $comprovantePagamento->dtPagamento ? DateTime::createFromFormat('d/m/Y', $comprovantePagamento->dtPagamento) : new DateTime();

            $this->view->tpDocumento = $comprovantePagamento->tpDocumento;
            $this->view->nrComprovante = $comprovantePagamento->nrComprovante;
            $this->view->nrSerie = $comprovantePagamento->nrSerie;
            $this->view->dtEmissao = $dataEmissao->format('d/m/Y');
            $this->view->dtPagamento = $dataPagamento->format('d/m/Y');
            $this->view->tpFormaDePagamento = $comprovantePagamento->tpFormaDePagamento;
            $this->view->nrDocumentoDePagamento = $comprovantePagamento->nrDocumentoDePagamento;
            $this->view->dsJustificativa = $comprovantePagamento->dsJustificativa;
            $this->view->idArquivo = $comprovantePagamento->idArquivo;
            $this->view->nomeArquivo = $comprovantePagamento->nmArquivo;
            $this->view->JustificativaTecnico = $comprovantePagamento->JustificativaTecnico;
            $this->view->pagCompRecusado = true;

            $tblProjetos = new Projetos();
            $projeto = $tblProjetos->buscarTodosDadosProjeto($idpronac);
            $this->view->projeto = $projeto->current();

            $diligencia = new Diligencia();
            $diligencia = $diligencia->aberta($idpronac);
            $this->view->idTipoDiligencia = $diligencia->idTipoDiligencia;

            $this->render('comprovacaopagamento');
        } catch(Exception $e) {
            parent::message($e->getMessage(), '/comprovarexecucaofinanceira/comprovantes-recusados/idpronac/' . $idpronac, 'ERROR');
        }
    }

    public function descreveritemAction()
    {
        $this->_helper->layout->disableLayout();
        $post       = Zend_Registry::get('post');
        $this->view->ckItens                = $post->ckItens;
        $this->view->idpronac               = $post->idpronac;
    }

    public function descricaoitemAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->_helper->layout->disableLayout();
        $this->_helper->ViewRenderer->setNoRender(true);
        $post       = Zend_Registry::get('post');
        $planilhaaprovacaoDao = new PlanilhaAprovacao();
        if ($post->idPlanilhaItem != '') {
            $resposta = $planilhaaprovacaoDao->descricaoitem($post->idpronac, $post->idProduto, $post->idEtapa, $post->idPlanilhaItem);
            $this->_helper->json(array('idPlanilhaAprovacao'=>$resposta[0]->idPlanilhaAprovacao,'qtItem'=>$resposta[0]->qtTotal,'vlUnitarioItem'=>number_format($resposta[0]->vlUnitario, 2, ',', '.'),'vlTotalItem'=>number_format(($resposta[0]->Total), 2, ',', '.'),'dsFabricante'=>utf8_encode($resposta[0]->dsFabricante),'dsItemDeCusto'=>utf8_encode($resposta[0]->dsItemDeCusto),'dsMarca'=>utf8_encode($resposta[0]->dsMarca),'dsObservacao'=>utf8_encode($resposta[0]->dsObservacao),'idItemCusto'=>$resposta[0]->idItemCusto));
        } else {
            $this->_helper->json(array('resp'=>false));
        }
    }

    public function cadastrardescricaoitemAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->ViewRenderer->setNoRender(true);
        $post       = Zend_Registry::get('post');

        $idPlanilhaAprovacao    =   $post->idPlanilhaAprovacao;
        $dsItemDeCusto          =   utf8_decode($post->dsItemDeCusto);
        $dsMarca                =   utf8_decode($post->dsMarca);
        $dsFabricante           =   utf8_decode($post->dsFabricante);
        $dsObservacao           =   utf8_decode($post->dsObservacao);
        $idItemCusto            =   $post->idItemCusto;

        $tbitemCusto = new ItemCusto();
        $valido = false;
        if (empty($idItemCusto) || $idItemCusto=='null' || $idItemCusto=='NULL') {
            $dadosCadastro = array('idPlanilhaAprovacao'=>$idPlanilhaAprovacao,'dsItemDeCusto'=>$dsItemDeCusto,'dsMarca'=>$dsMarca,'dsFabricante'=>$dsFabricante,'dsObservacao'=>$dsObservacao);
            $resp = $tbitemCusto->inserirItemCusto($dadosCadastro);
            if ($resp) {
                $valido = true;
                $idItemCusto = $resp['idItemCusto'];
            }
        } else {
            $resp = $tbitemCusto->alterarItemCusto(array('dsItemDeCusto'=>$dsItemDeCusto,'dsMarca'=>$dsMarca,'dsFabricante'=>$dsFabricante,'dsObservacao'=>$dsObservacao), "idItemCusto = {$idItemCusto}");
            if ($resp) {
                $valido = true;
            }
        }
        if ($valido) {
            $report = array('result'=>true,'mensagem'=>'Cadastro realizado com sucesso.','idItemCusto'=>$idItemCusto);
        } else {
            $report = array('result'=>false,'mensagem'=>utf8_encode('Falha na recupera��o dos dados |'.$idItemCusto.'|'));
        }
        $this->_helper->json($report);
    }

    public function anexarAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->_helper->layout->disableLayout();
        $post   = Zend_Registry::get('post');
        $this->view->idlicitacao    = $post->idlicitacao;
        $this->view->iddispensa     = $post->iddispensa;
        $this->view->idcontrato     = $post->idcontrato;
        $this->view->idcotacao      = $post->idcotacao;
        $this->view->idpronac       = $post->idpronac;
    }

    public function cadastraranexoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->_helper->layout->disableLayout();
        $post   = Zend_Registry::get('post');

        $idlicitacao    = $post->idlicitacao;
        $iddispensa     = $post->iddispensa;
        $idcontrato     = $post->idcontrato;
        $idcotacao      = $post->idcotacao;
        $idpronac       = $post->idpronac;

        // pega as informa��es do arquivo
        $arquivoNome     = $_FILES['arquivo']['name']; // nome
        $arquivoTemp     = $_FILES['arquivo']['tmp_name']; // nome tempor�rio
        $arquivoTipo     = $_FILES['arquivo']['type']; // tipo
        $arquivoTamanho  = $_FILES['arquivo']['size']; // tamanho
        if (!empty($arquivoNome) && !empty($arquivoTemp)) {
            $arquivoExtensao = Upload::getExtensao($arquivoNome); // extens�o
                $arquivoBinario  = Upload::setBinario($arquivoTemp); // bin�rio
                $arquivoHash     = Upload::setHash($arquivoTemp); // hash


            // cadastra dados do arquivo
            if ($arquivoExtensao != 'doc' and $arquivoExtensao != 'docx' and $arquivoExtensao != '') {
                // cadastra dados do arquivo
                $dadosArquivo = array(
                        'nmArquivo'         => $arquivoNome,
                        'sgExtensao'        => $arquivoExtensao,
                        'dsTipoPadronizado' => $arquivoTipo,
                        'nrTamanho'         => $arquivoTamanho,
                        'dtEnvio'           => new Zend_Db_Expr('GETDATE()'),
                        'dsHash'            => $arquivoHash,
                        'stAtivo'           => 'A');
                $cadastrarArquivo = ArquivoDAO::cadastrar($dadosArquivo);

                // pega o id do �ltimo arquivo cadastrado
                $idUltimoArquivo = ArquivoDAO::buscarIdArquivo();
                $idUltimoArquivo = (int) $idUltimoArquivo[0]->id;

                // cadastra o bin�rio do arquivo
                $dadosBinario = array(
                        'idArquivo' => $idUltimoArquivo,
                        'biArquivo' => $arquivoBinario);
                $cadastrarBinario = ArquivoImagemDAO::cadastrar($dadosBinario);

                if ($idlicitacao) {
                    $ArquivoLicitacaoDao = new Arquivolicitacao();
                    $ArquivoLicitacaoDao->insert(array('idLicitacao'=>$idlicitacao,'idArquivo'=>$idUltimoArquivo));

                    parent::message('Anexado com sucesso!', '/comprovarexecucaofinanceira/alterarlicitacao'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac.'&idlicitacao='.$idlicitacao, 'CONFIRM');
                }
                if ($iddispensa) {
                    $ArquivoDispensaLicitacaoDao = new Arquivodispensalicitacao();
                    $ArquivoDispensaLicitacaoDao->insert(array('idDispensaLicitacao'=>$iddispensa,'idArquivo'=>$idUltimoArquivo));

                    parent::message('Anexado com sucesso!', '/comprovarexecucaofinanceira/incluirdispensa'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac.'&iddispensa='.$iddispensa, 'CONFIRM');
                }
                if ($idcontrato) {
                    $ArquivoContratoDao = new Arquivocontrato();
                    $ArquivoContratoDao->insert(array('idContrato'=>$idcontrato,'idArquivo'=>$idUltimoArquivo));

                    parent::message('Anexado com sucesso!', '/comprovarexecucaofinanceira/incluircontrato'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac.'&idcontrato='.$idcontrato, 'CONFIRM');
                }
                if ($idcotacao) {
                    $ArquivoCotacaoDao = new Arquivocotacao();
                    $ArquivoCotacaoDao->insert(array('idCotacao'=>$idcotacao,'idArquivo'=>$idUltimoArquivo));

                    parent::message('Anexado com sucesso!', '/comprovarexecucaofinanceira/incluircotacao'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac.'&idcotacao='.$idcotacao, 'CONFIRM');
                }
            } else {
                if ($idlicitacao) {
                    parent::message('Arquivo com extens&atilde;o inv�lida!', '/comprovarexecucaofinanceira/alterarlicitacao'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac.'&idlicitacao='.$idlicitacao, 'ERROR');
                }
                if ($iddispensa) {
                    parent::message('Arquivo com extens&atilde;o inv�lida!', '/comprovarexecucaofinanceira/incluirdispensa'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac.'&iddispensa='.$iddispensa, 'ERROR');
                }
                if ($idcontrato) {
                    parent::message('Arquivo com extens&atilde;o inv�lida!', '/comprovarexecucaofinanceira/incluircontrato'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac.'&idcontrato='.$idcontrato, 'ERROR');
                }
                if ($idcotacao) {
                    parent::message('Arquivo com extens&atilde;o inv�lida!', '/comprovarexecucaofinanceira/incluircotacao'.'?idusuario='.$this->view->idusuario.'&idpronac='.$idpronac.'&idcotacao='.$idcotacao, 'ERROR');
                }
            }
        } else {
            $this->view->erro = true;
            $this->view->mensagemErro = 'Selecione um arquivo para anexar!';
        }
    }

    public function descreveritenscustoAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->_helper->layout->disableLayout();

        $post = Zend_Registry::get('post');
        $this->view->idlicitacao = $post->idlicitacao;
        $this->view->iditemcusto = $post->id;
        $this->view->idpronac    = $post->idpronac;

        if ($this->view->iditemcusto != '') {
            $this->view->numLicitacao               = 123456;
            $this->view->modalidade                 = utf8_encode('Preg�o');
            $this->view->numProcesso                = 123456;
            $this->view->dataPubliEdital            = '44/44/1988';
            $this->view->objeto                     = utf8_encode('Aquisi��o de material de informatica');
            $this->view->fundamentoLegal            = utf8_encode('Lei 11123');

            $this->view->etapa                      = utf8_encode('aaaaa');
            $this->view->item                       = utf8_encode('Gr�fica');

            $this->view->descricao                  = null;
            $this->view->marca                      = null;
            $this->view->fabricante                 = null;
            $this->view->uniFornecimento            = null;
            $this->view->quantidade                 = null;
            $this->view->precoUni                   = null;
            $this->view->valorTotal                 = null;
            $this->view->abservacao                 = null;
        }
    }

    public function verificarvaloresajaxAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->_helper->layout->disableLayout();
        $this->_helper->ViewRenderer->setNoRender(true);

        $post = Zend_Registry::get('post');
        $idPlanilhaAprovacao    = $post->idPlanilhaAprovacao;
        $valor                  = $post->valor;
        $idpronac               = $post->idpronac;
        if (!empty($idPlanilhaAprovacao)) {
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '', $valor);
            $valor = $valor/100;

            $cppaDao = new ComprovantePagamentoxPlanilhaAprovacao();
            $total = $cppaDao->valorTotalPorItem($idPlanilhaAprovacao);

            $PlanilhaAprovacaoDAO   = new PlanilhaAprovacao();
            $resposta   = $PlanilhaAprovacaoDAO->valoresAgrupados($idpronac, false);
            $resp = true;
            $valorAprovado = 0;
            foreach ($resposta as $value) {
                if ($value->idPlanilhaAprovacao ==  $idPlanilhaAprovacao) {
                    if ($value->Total < ($valor+$total[0]->Total)) {
                        $valorAprovado = $value->Total;
                        $resp = false;
                    }
                }
            }

            if ($resp) {
                $this->_helper->json(array('retorno'=>true));
            } else {
                $this->_helper->json(array('retorno'=>false,'mensagem'=>utf8_encode('Nao � possivel registrar a comprovo��o do valor R$'.number_format(($valor+$total[0]->Total), 2, ',', '.').', tendo em vista que o valor aprovado � de R$'.number_format($valorAprovado, 2, ',', '.').'.')));
            }
        } else {
            //$this->_helper->json(array('retorno'=>false,'mensagem'=>utf8_encode('Selecione um item de custo!')));
            $this->_helper->json(array('retorno'=>true));
        }
    }

    public function carregaselectajaxAction()
    {
        $this->_helper->layout->disableLayout();
        $post = Zend_Registry::get('post');

        $this->view->idpronac   = $post->idpronac;
        $this->view->tpSelect   = $post->tpSelect;
        $this->view->idProduto  = $post->idProduto;

        switch ($this->view->tpSelect) {
            case 'produto':
                $produtoDao = new Produto();
                $planilhaAprovacaoDao = new PlanilhaAprovacao();
                if ($post->contrato) {
                    $retorno = $planilhaAprovacaoDao->buscarProdutosContrato($this->view->idpronac);
                } else {
                    if (is_array($post->ckItens) or $post->ckItensVal) {
                        $retorno = $planilhaAprovacaoDao->buscarProdutosComprovacao($this->view->idpronac, $post->ckItens);
                    } else {
                        $retorno = $planilhaAprovacaoDao->buscarProdutos($this->view->idpronac);
                    }
                }
                $this->view->retorno = array();
                foreach ($retorno as $produto) {
                    $this->view->retorno[] = array('id' => $produto->id, 'nome' => utf8_encode($produto->nome));
                }
                break;
            case 'produtoCarga':
                $planilhaAprovacaoDao = new PlanilhaAprovacao();
                $this->view->retorno = $planilhaAprovacaoDao->carregarProdutos(
                    $this->view->idpronac,
                    $post->idCotacao,
                    $post->idDispensaLicitacao,
                    $post->idLicitacao,
                    $post->idContrato
                );
                break;
            case 'etapa':
                $etapaDao = new PlanilhaEtapa();
                if ($post->contrato) {
                    $retorno = $etapaDao->buscarEtapaContrato($this->view->idpronac, $post->idProduto);
                } else {
                    if (is_array($post->ckItens) or $post->ckItensVal) {
                        $retorno =  $etapaDao->buscarEtapaComprovacao($this->view->idpronac, $post->idProduto, $post->ckItens);
                    } else {
                        $retorno = $etapaDao->buscarEtapa($this->view->idpronac, $post->idProduto);
                    }
                }
                $this->view->retorno = array();
                foreach ($retorno as $etapa) {
                    $this->view->retorno[] = array('id' => $etapa->id, 'nome' => utf8_encode($etapa->nome));
                }
                break;
            case 'etapaCarga':
                $etapaDao = new PlanilhaEtapa();
                $this->view->retorno = array_merge(
                    array(),
                    $etapaDao->carregarEtapa(
                        $this->view->idpronac,
                        $post->idProduto,
                        $post->idCotacao,
                        $post->idDispensaLicitacao,
                        $post->idLicitacao,
                        $post->idContrato
                    )
                );
                break;
            case 'itens':
                $itemDao = new PlanilhaItens();

                if ($post->contrato) {
                    $this->view->retorno = $itemDao->buscarItemContrato($this->view->idpronac, $post->idProduto, $post->idEtapa);
                } else {
                    if (is_array($post->ckItens) or $post->ckItensVal) {
                        $retorno = $itemDao->buscarItemComprovacao($this->view->idpronac, $post->idProduto, $post->idEtapa, $post->ckItens);
                    } else {
                        $retorno = $itemDao->buscarItem($this->view->idpronac, $post->idProduto, $post->idEtapa);
                    }
                }
                $this->view->retorno = array();
                foreach ($retorno as $item) {
                    $this->view->retorno[] = array('id' => $item->id, 'nome' => utf8_encode($item->nome));
                }
                break;
            case 'itensCarga':
                $itemDao = new PlanilhaItens();
                $this->view->idCotacao  = $post->idCotacao;
                $this->view->retorno    = $itemDao->carregarItem($this->view->idpronac, $post->idProduto, $post->idEtapa, $post->idCotacao, $post->idDispensaLicitacao, $post->idLicitacao, $post->idContrato);
                break;
        }
    }

    public function carregacontratoajaxAction()
    {
        /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
        $this->verificarPermissaoAcesso(false, true, false);

        $this->_helper->layout->disableLayout();
        $post = Zend_Registry::get('post');
        $contratoDao = new Contrato();
        $contrato = $contratoDao->buscarContratoItem($post->idpronac, $post->idProduto, $post->idEtapa, $post->idItens);
        if ($contrato) {
            $this->view->contrato = array('retorno'=>true,'idContrato'=>$contrato->idContrato,'nrContrato'=>$contrato->nrContratoSequencial.'/'.$contrato->nrContratoAno);
        } else {
            $this->view->contrato = array('retorno'=>false);
        }
    }

    /**
    * deprecated*/
    public function buscarfornecedorAction()
    {
        $this->_helper->layout->disableLayout();

        $post = Zend_Registry::get('post');
        $agentesDao = new Agente_Model_DbTable_Agentes();

        $cnpjcpf = preg_replace('/\.|-|\/|\?/', '', utf8_decode($post->cnpjcpf));

        $fornecedor = $agentesDao->buscarFornecedor(array(' A.CNPJCPF = ? '=>$cnpjcpf))->current();
        if ($fornecedor) {
            $this->view->fornecedor = array('retorno'=>true,'idAgente'=>$fornecedor->idAgente,'descricao'=>utf8_encode($fornecedor->nome));
        } else {
            $this->view->fornecedor = array('retorno'=>false, 'CNPJCPF'=>$cnpjcpf);
        }
    }

    public function buscarfornecedorDaReceitaAction()
    {
        $this->_helper->layout->disableLayout();

        $post = Zend_Registry::get('post');
        $cnpjcpf = preg_replace('/\.|-|\//', '', $post->cnpjcpf);

        #Instancia a Classe de Servi�o do WebService da Receita Federal
        $wsServico = new ServicosReceitaFederal();
        $retorno        = array();
        $erro           = 0;
        if (11 == strlen($cnpjcpf)) {
            if (!validaCPF($cnpjcpf)) {
                $retorno['error'] = utf8_encode('CPF inv�lido');
                $erro = 1;
            } else {
                $arrResultado = $wsServico->consultarPessoaFisicaReceitaFederal($cnpjcpf);

                if (empty($arrResultado)) {
                    $retorno['error'] = utf8_encode('Pessoa n�o encontrada!');
                    $erro = 1;
                    $this->view->fornecedor = array('retorno'=>false, 'CNPJCPF'=>$cnpjcpf);
                }

                if ($erro == 0 && count($arrResultado) > 0) {
                    $retorno['error'] = '';
                    $this->view->fornecedor = array('retorno'=>true,'idAgente'=>$arrResultado['idPessoaFisica'],'descricao'=>utf8_encode($arrResultado['nmPessoaFisica']));
                } else {
                    $retorno['error'] = utf8_encode('Pessoa n�o encontrada!!');
                    $this->view->fornecedor = array('retorno'=>false, 'CNPJCPF'=>$cnpjcpf);
                }
            }
        } elseif (15 == strlen($cnpjcpf)) {
            if (!isCnpjValid($cnpjcpf)) {
                $retorno['error'] = utf8_encode('CNPJ inv�lido');
                $erro = 1;
            } else {
                $arrResultado = $wsServico->consultarPessoaJuridicaReceitaFederal($cnpjcpf);
                if (empty($arrResultado)) {
                    $retorno['error'] = utf8_encode('Pessoa n�o encontrada!!');
                    $erro = 1;
                    $this->view->fornecedor = array('retorno'=>false, 'CNPJCPF'=>$cnpjcpf);
                }

                if ($erro == 0 && count($arrResultado) > 0) {
                    $retorno['error'] = '';
                    $this->view->fornecedor = array('retorno'=>true,'idAgente'=>$arrResultado['idPessoaJuridica'],'descricao'=>utf8_encode($arrResultado['nmRazaoSocial']));
                } else {
                    $retorno['error'] = utf8_encode('Pessoa n�o encontrada!');
                    $this->view->fornecedor = array('retorno'=>false, 'CNPJCPF'=>$cnpjcpf);
                }
            }
        }
    }

    public function removerfornecedorAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->ViewRenderer->setNoRender(true);

        $post = Zend_Registry::get('post');
        $licitacaoxAgentesDao = new Licitacaoxagentes();

        $result = $licitacaoxAgentesDao->deletarLicitacaoxAgentes(" idAgente = {$post->idAgente} and idLicitacao = {$post->idlicitacao} ");

        if ($result) {
            $resposta = array('retorno'=>true,'mensagem'=>'Reomovido com sucesso!', 'fechar'=>'ok');
        } else {
            $resposta = array('retorno'=>false,'mensagem'=>'N&atilde;o foi possivel remover!');
        }
        $this->_helper->json($resposta);
    }

    public function fornecedorvencedorAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->ViewRenderer->setNoRender(true);

        $post = Zend_Registry::get('post');
        $licitacaoxAgentesDao = new Licitacaoxagentes();

        $result = $licitacaoxAgentesDao->alterarLicitacaoxAgentes(array("stVencedor"=>'false'), "idLicitacao = {$post->idlicitacao} ");

        $result = $licitacaoxAgentesDao->alterarLicitacaoxAgentes(array("stVencedor"=>'true'), " idAgente = {$post->idAgente} and idLicitacao = {$post->idlicitacao} ");

        if ($result) {
            $resposta = array('retorno'=>true,'mensagem'=>'Vencedor escolhido com sucesso!', 'fechar'=>'ok');
        } else {
            $resposta = array('retorno'=>false,'mensagem'=>'N&atilde;o foi possivel!');
        }
        $this->_helper->json($resposta);
    }

    public function finalizarAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->ViewRenderer->setNoRender(true);

        $tblPlanilhaAprovacao = new PlanilhaAprovacao();
        $rsPA = $tblPlanilhaAprovacao->verificarComprovacao($this->getRequest()->getParam('idpronac'));

        if (count($rsPA)) {
            $this->_helper->flashMessenger->addMessage('N&atilde;o &eacute; poss&iacute;vel finalizar pois o valor comprovado &eacute; maior que o valor aprovado!');
            $this->_helper->flashMessengerType->addMessage('ERROR');
        } else {
            $ProjetosDao = new Projetos();
            $ProjetosDao->update(
                array('Situacao'=>"E24", 'dtSituacao' => new Zend_Db_Expr('GETDATE()')),
                "IdPRONAC = {$this->getRequest()->getParam('idpronac')}"
            );
            $this->_helper->flashMessenger->addMessage('Finalizado com sucesso!');
            $this->_helper->flashMessengerType->addMessage('CONFIRM');
        }
        $url = $this->view->url(array(
            'controller' => 'comprovarexecucaofinanceira',
            'action' => 'pagamento',
            'idusuario' => $this->getRequest()->getParam('idusuario'),
            'idpronac' => $this->getRequest()->getParam('idpronac'),
        ), null, true);
        $this->redirect(str_replace($this->view->baseUrl(), '', $url));
    }

    public function finalizadoAction()
    {
        $get = Zend_Registry::get('get');
        if ($get->cadastro == 1) {
            $this->view->mensagem = 'Comprova&ccedil;&atilde;o finalizada com sucesso!';
        } else {
            $this->view->mensagem = 'A comprova&ccedil;&atilde;o j&aacute; foi finalizada!';
        }
        $this->redirect("comprovarexecucaofinanceira/pagamento?idusuario=".$_GET['idusuario']."&idpronac=".$_GET['idpronac']);
    }

    public function deletarLicitacaoAction()
    {
        try {
            $licitacao = new Licitacao();
            $licitacao->deletarLicitacao($this->getRequest()->getParam('idlicitacao'));
            # dispatch
            $this->_helper->flashMessenger->addMessage('Licita��o excluida com sucesso.');
            $this->_helper->flashMessengerType->addMessage('CONFIRM');
        } catch (Zend_Db_Statement_Exception $e) {
            $this->_helper->flashMessenger->addMessage('Licita��o em uso, n�o ser� poss�vel excluir.');
            $this->_helper->flashMessengerType->addMessage('ERROR');
        }
        $url = $this->view->url(array(
            'controller' => 'comprovarexecucaofinanceira',
            'action' => 'licitacao',
            'idusuario' => $this->getRequest()->getParam('idusuario'),
            'idpronac' => $this->getRequest()->getParam('idpronac'),
        ), null, true);
        $this->redirect(str_replace($this->view->baseUrl(), '', $url));
    }

    public function comprovantesRecusadosAction()
    {
        $this->verificarPermissaoAcesso(false, true, false);
        $this->dadosProjeto();
        # comprovantes recusados
        $comprovantePagamentoModel = new ComprovantePagamento();
        $this->view->comprovantesDePagamento = $comprovantePagamentoModel->pesquisarComprovanteRecusado(
            $this->getRequest()->getParam('idpronac')
        );
        $this->view->idpronac = $this->getRequest()->getParam('idpronac');
        $this->view->idusuario = Zend_Auth::getInstance()->getIdentity()->IdUsuario;
    }

    public function enviarcomprovacaopagamentoAction()
    {
        $idPronac = $this->getRequest()->getParam('idPronac');

        try {
            $comprovantePagamentoModel = new ComprovantePagamentoxPlanilhaAprovacao();
            $comprovantePagamento = $comprovantePagamentoModel->atualizarComprovanteRecusado($idPronac);

            $this->_helper->flashMessenger('Comprovantes enviados com sucesso!');
            $this->redirect(
                str_replace(
                    $this->view->baseUrl(),
                    '',
                    $this->view->url(
                        array(
                            'controller' => 'comprovarexecucaofinanceira',
                            'action' => 'comprovantes-recusados',
                            'idusuario' => $this->view->idusuario,
                            'idpronac' => $idPronac,
                        )
                    )
                )
            );
        } catch (Exception $e) {
            $message = $e->getMessage();
            if (strpos($e->getMessage(), 'DateTime::__construct()') !== false) {
                $message = 'N�o foi poss�vel enviar os comprovantes de pagamento!';
            }
            $this->view->message = $message;
            $this->view->message_type = 'ERROR';
            $this->forward('comprovacaopagamento-recusado');
        }
    }
}
