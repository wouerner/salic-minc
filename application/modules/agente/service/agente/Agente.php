<?php

namespace Application\Modules\agente\service\agente;

class Agente
{

    /**
     * Este metodo é para correcao de erro ao transformar projeto em proposta
     * o erro acontece quando existe agente com usuario invalido
     */
//    public function salvarUsuarioAgenteAction()
//    {
//        $idAgente = (int)$this->_request->getParam("agente");
//        $idResponsavel = (int)$this->_request->getParam("idResponsavel");
//
//        try {
//
//            if ($this->GrupoAtivoSalic == Autenticacao_Model_Grupos::PROPONENTE) {
//                throw new Exception("Voc&ecirc; n&atilde;o tem permiss&atilde;o para esta a&ccedil;&atilde;o");
//            }
//
//            if (empty($idAgente) || empty($idResponsavel)) {
//                throw new Exception("Dados obrigat&oacute;rios n&atilde;o informados");
//            }
//
//            $mprAgentes = new Agente_Model_AgentesMapper();
//            $agente = $mprAgentes->findBy(['idAgente' => $idAgente]);
//
//            if (empty($agente)) {
//                throw new Exception("Agente n&atilde;o existe");
//            }
//
//            $where = [];
//            $dados = [];
//            $dbTableAgentes = new Agente_Model_DbTable_Agentes();
//            $where[] = $dbTableAgentes->getAdapter()->quoteInto('idAgente = ?', $idAgente);
//            $dados['Usuario'] = $idResponsavel;
//            $dbTableAgentes->update($dados, $where);
//
//            parent::message("Agente atualizado com sucesso!", "/agente/agentes/form-usuario-agente/id/" . $idAgente, "CONFIRM");
//        } catch (Exception $e) {
//            parent::message($e->getMessage(), "/agente/agentes/form-usuario-agente/id/" . $idAgente, "ERROR");
//        }
//    }

    /**
     * Metodo para realizar a buscar de agentes por cpf/cnpj ou por nome
     * @access public
     * @param void
     * @return void
     */
//    public function buscaragenteAction($cpf, $nome)
//    {
//            $cpf = Mascara::delMaskCPF(Mascara::delMaskCNPJ($cpf)); // deleta a mascara
//
//            try {
//                // validacao dos campos
//                if (empty($cpf) && empty($nome)) {
//                    throw new Exception("Dados obrigat&oacute;rios n&atilde;o informados:<br /><br />&eacute; necess&aacute;rio informar o CPF/CNPJ ou o Nome!");
//                } elseif (!empty($cpf) && strlen($cpf) != 11 && strlen($cpf) != 14) { // valida cnpj/cpf
//                    throw new Exception("O CPF/CNPJ informado &eacute; inv&aacute;lido!");
//                } elseif (!empty($cpf) && strlen($cpf) == 11 && !Validacao::validarCPF($cpf)) { // valida cpf
//                    throw new Exception("O CPF informado &eacute; inv&aacute;lido!");
//                } elseif (!empty($cpf) && strlen($cpf) == 14 && !Validacao::validarCNPJ($cpf)) { // valida cnpj
//                    throw new Exception("O CNPJ informado &eacute; inv&aacute;lido!");
//                } else {
//                    // redireciona para a pagina com a busca dos dados com paginacao
//                    $this->redirect("agente/agentes/listaragente?cpf=" . $cpf . "&nome=" . $nome);
//                }
//            } catch (Exception $e) {
//                $this->view->message = $e->getMessage();
//                $this->view->message_type = "ERROR";
//                $this->view->cpf = !empty($cpf) ? Validacao::mascaraCPFCNPJ($cpf) : ''; // caso exista, adiciona a mascara
//                $this->view->nome = $nome;
//            }
//        return  $this->view;
//    }


    /**
     * Metodo listaragente()
     * @access public
     * @param void
     * @return List
     */
//    public function listaragenteAction()
//    {
//        $this->autenticacao();
//        // recebe os dados via get
//        $get = Zend_Registry::get('get');
//        $cpf = $get->cpf;
//        $nome = $get->nome;
//
//        // realiza a busca por cpf e/ou nome
//        $buscar = Agente_Model_ManterAgentesDAO::buscarAgentes($cpf, $nome);
//
//        if (!$buscar) {
//            // redireciona para a pagina de cadastro de agentes, e, exibe uma notificacao relativa ao cadastro
//            parent::message("Agente n&atilde;o cadastrado!<br /><br />Por favor, cadastre o mesmo no formulário abaixo!", "/agente/manteragentes/agentes?acao=cc&cpf=" . $cpf . "&nome=" . $nome, "ALERT");
//        } else {
//            // ========== INICIO PAGINACAO ==========
//            // criando a paginacao
//            Zend_Paginator::setDefaultScrollingStyle('Sliding');
//            $this->view->addScriptPath(APPLICATION_PATH.'/modules/default/views/scripts/paginacao');
//            Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginacao.phtml');
//            $paginator = Zend_Paginator::factory($buscar); // dados a serem paginados
//            // pagina atual e quantidade de itens por pagina
//            $currentPage = $this->_getParam('page', 1);
//            $paginator->setCurrentPageNumber($currentPage)->setItemCountPerPage(10); // 10 por pagina
//            // ========== FIM PAGINACAO ==========
//
//            $this->view->buscar = $paginator;
//            $this->view->qtdAgentes = count($buscar); // quantidade de agentes
//        }
//    }

    /**
     * Metodo para retorno de intervalo de tempo
     * @param $dados
     * @return bool|\DateInterval
     */
    private function obterDiferencaDatas($dados)
    {
        $dtatual = new \DateTime(); //data atual
        $data = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($dados)));
        return $dtatual->diff($data);
    }

    /**
     * Metodo consulta pessoa fisica no Serviço que consulta Receita Federal
     * chamada -> function agentecadastrado()
     * @param $cpf, $idAgente
     * @return \ArrayObject
     */
    private function fisicaReceita($cpf, $idAgente) {

        #Instancia a Classe de Servico do WebService da Receita Federal
        $wsServico = new \ServicosReceitaFederal();
        $novos_valores = [];

        $arrResultado = $wsServico->consultarPessoaFisicaReceitaFederal($cpf);

        if ( !empty($arrResultado) && !empty($arrResultado['situacaoCadastral']) && !empty($idAgente)) {

            $data = $this->obterDiferencaDatas($arrResultado['situacaoCadastral']['dtSituacaoCadastral'])->days;

            $novos_valores['msgCPF'] = utf8_encode('novo');

            if( $data > 183 ) {

                $arrResultado = $wsServico->consultarPessoaFisicaReceitaFederal($cpf, true);

                if(!empty($arrResultado["erro"]))
                {
                    $novos_valores['msgCPF'] = utf8_encode('invalido');
                    return $novos_valores;
                }

                $novos_valores['msgCPF'] = utf8_encode('atualizado');
            }
            $novos_valores['idAgente'] = $idAgente;
            $novos_valores['Nome'] = utf8_encode($arrResultado['nmPessoaFisica']);
            $novos_valores['Cep'] = isset($arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep']) && $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] ? $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] : '';

        }
        elseif(!empty($arrResultado) && empty($arrResultado['situacaoCadastral']) && !empty($idAgente))
        {

            $arrResultado = $wsServico->consultarPessoaFisicaReceitaFederal($cpf, true);
            if(!empty($arrResultado["erro"]))
            {
                $novos_valores['msgCPF'] = utf8_encode('invalido');
                return $novos_valores;
            }
            $novos_valores['msgCPF'] = utf8_encode('atualizado');
            $novos_valores['idAgente'] = $idAgente;
            $novos_valores['Nome'] = utf8_encode($arrResultado['nmPessoaFisica']);
            $novos_valores['Cep'] = isset($arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep']) && $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] ? $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] : '';
        }else {
            $arrResultado = $wsServico->consultarPessoaFisicaReceitaFederal($cpf, true);
            if(!empty($arrResultado["erro"]))
            {
                $novos_valores['msgCPF'] = utf8_encode('invalido');
                return $novos_valores;
            }
            $novos_valores['msgCPF'] = utf8_encode('novo');
            $novos_valores['Nome'] = utf8_encode($arrResultado['nmPessoaFisica']);
            $novos_valores['Cep'] = isset($arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep']) && $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] ? $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] : '';
        }

        return $novos_valores;
    }

    /**
     * Metodo consulta pessoa juridica no Serviço que consulta Receita Federal
     * chamada -> function agentecadastrado()
     * @param $cpf, $idAgente
     * @return \ArrayObject
     */
    private function juridicaReceita($cpf, $idAgente) {

        #Instancia a Classe de Servico do WebService da Receita Federal
        $wsServico = new \ServicosReceitaFederal();
        $novos_valores = [];

        $arrResultado = $wsServico->consultarPessoaJuridicaReceitaFederal($cpf);

        if ( !empty($arrResultado) && !empty($arrResultado['situacaoCadastral']) && !empty($idAgente)) {

            $data = $this->obterDiferencaDatas($arrResultado['situacaoCadastral']['dtSituacaoCadastral'])->days;

            $novos_valores['msgCPF'] = utf8_encode('novo');

            if( $data > 183 ) {

                $arrResultado = $wsServico->consultarPessoaJuridicaReceitaFederal($cpf, true);
                if(!empty($arrResultado["erro"]))
                {
                    $novos_valores['msgCPF'] = utf8_encode('invalido');
                    return $novos_valores;
                }
                $novos_valores['msgCPF'] = utf8_encode('atualizado');
            }

            $novos_valores[0]['idAgente'] = $idAgente;
            $novos_valores[0]['Nome'] = utf8_encode($arrResultado['nmRazaoSocial']);
            $novos_valores[0]['Cep'] = isset($arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep']) && $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] ? $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] : '';
        }
        elseif(!empty($arrResultado) && empty($arrResultado['situacaoCadastral']) && !empty($idAgente))
        {
            $arrResultado = $wsServico->consultarPessoaJuridicaReceitaFederal($cpf, true);
            if(!empty($arrResultado["erro"]))
            {
                $novos_valores['msgCPF'] = utf8_encode('invalido');
                return $novos_valores;
            }
            $novos_valores['msgCPF'] = utf8_encode('atualizado');
            $novos_valores[0]['idAgente'] = $idAgente;
            $novos_valores[0]['Nome'] = utf8_encode($arrResultado['nmRazaoSocial']);
            $novos_valores[0]['Cep'] = isset($arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep']) && $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] ? $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] : '';
        }else {
            $arrResultado = $wsServico->consultarPessoaJuridicaReceitaFederal($cpf, true);
            if(!empty($arrResultado["erro"]))
            {
                $novos_valores['msgCPF'] = utf8_encode('invalido');
                return $novos_valores;
            }
            $novos_valores['msgCPF'] = utf8_encode('novo');
            $novos_valores[0]['Nome'] = utf8_encode($arrResultado['nmRazaoSocial']);
            $novos_valores[0]['Cep'] = isset($arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep']) && $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] ? $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] : '';
        }
        return $novos_valores;
    }

    /**
     * Metodo de Cadastro e Atualização de agentes com consulta ao InfoConv
     * @access public
     * @param $cpf (cpf ou cnpj)
     * @return \ArrayObject
     */
    public function agentecadastrado($cpf)
    {
        $novos_valores = [];
        $dados = \Agente_Model_ManterAgentesDAO::buscarAgentes($cpf);

        switch (strlen($cpf)) {

            case 11:
                $servico = 'fisicaReceita';
                break;
            case 14:
                $servico = 'juridicaReceita';
                break;
        }

        if(!empty($dados)) {
            $data = $this->obterDiferencaDatas($dados[0]->dtatualizacao)->days;

            if (count($dados) != 0 &&  $data < 183) {
                foreach ($dados as $dado) {
                    $dado = ((array) $dado);
                    array_walk($dado, function ($value, $key) use (&$dado) {
                        $dado[$key] = utf8_encode($value);
                    });
                    $novos_valores['msgCPF'] = utf8_encode('cadastrado');
                    $novos_valores['idAgente'] = utf8_encode($dado['idagente']);
                    $novos_valores['Nome'] = utf8_encode($dado['nome']);
                    $novos_valores['agente'] = $dado;
                }
            } else {
                $novos_valores = $this->{$servico}($cpf,$dados[0]->idagente);
                xd($dados);
                    die;
            }
        }else {
            $novos_valores = $this->{$servico}($cpf,'');
        }
        return $novos_valores;
    }


    /**
     * salvaragente
     *
     * @access private
     * @return void
     * @author wouerner <wouerner@gmail.com>
     * @todo refatorar metodo para um generico que possa salvar todas as
     * possibilidades
     */
    public function salvaragente($idAgente = null, $modelAgente = null)
    {
        $arrAuth = (array)\Zend_Auth::getInstance()->getIdentity();
        $usuario = isset($arrAuth['IdUsuario']) ? $arrAuth['IdUsuario'] : $arrAuth['usu_codigo'];
        $arrayAgente = array(
            'cnpjcpf' => $this->_request->getParam("cpf"),
            'tipopessoa' => $this->_request->getParam("Tipo"),
            'status' => 0,
            'usuario' => $usuario
        );

        try {
            $mprAgentes = new \Agente_Model_AgentesMapper();
            $mprNomes = new \Agente_Model_NomesMapper();
            $mdlAgente = new \Agente_Model_Agentes($arrayAgente);
            $mprAgentes->save($mdlAgente);

            $agente = $mprAgentes->findBy(array('cnpjcpf' => $mdlAgente->getCnpjcpf()));
            $cpf = preg_replace('/\.|-|\//', '', $this->_request->getParam("cpf"));
            $idAgente = $agente['idAgente'];
            $nome = $this->_request->getParam("nome");
            $TipoNome = (strlen($mdlAgente->getCnpjcpf()) == 11 ? 18 : 19); // 18 = pessoa fisica e 19 = pessoa juridica

            if ($this->modal == "s") {
                $nome = \Seguranca::tratarVarAjaxUFT8($nome);
            }
//            $nome = preg_replace('/[^A-Za-zZ0-9\ ]/', '', $nome);
            $nome = preg_replace('/[\'\"\n\`\´]/', '', $nome);

            try {
                $arrNome = array(
                    'idagente' => $idAgente,
                    'tiponome' => $TipoNome,
                    'descricao' => $nome,
                    'status' => 0,
                    'usuario' => $usuario
                );

                $mprNomes->save(new \Agente_Model_Nomes($arrNome));
            } catch (Exception $e) {
                throw new Exception("Erro ao salvar o nome: " . $e->getMessage());
            }

            // ================================================ INICIO VISAO ======================================================
            $Visao = $this->_request->getParam("visao");
            $grupologado = $this->_request->getParam("grupologado");
            /*
             * Validacao - Se for componente da comissao ele nao salva a visao
             * Regra o componente da comissao nao pode alterar sua visao.
             */
            if ($grupologado != \Autenticacao_Model_Grupos::COMPONENTE_COMISSAO) :

                $GravarVisao = array(
                    'idagente' => $idAgente,
                    'visao' => $Visao,
                    'usuario' => $usuario,
                    'stativo' => 'A');

                try {
                    $visaoTable = new \Agente_Model_DbTable_Visao();
                    $busca = $visaoTable->buscarVisao($idAgente, $Visao);
                    if (!$busca) {
                        $i = $visaoTable->cadastrarVisao($GravarVisao);
                    }
                } catch (Exception $e) {
                    throw new Exception("Erro ao salvar a vis&atilde;o: " . $e->getMessage());
                }
                // ================================================ FIM VISAO ======================================================

                // ===================== INICIO SALVAR TITULACAO (AREA/SEGMENTO DO COMPONENTE DA COMISSAO) ================================
                $titular = $this->_request->getParam("titular");
                $areaCultural = $this->_request->getParam("areaCultural");
                $segmentoCultural = $this->_request->getParam("segmentoCultural");

                // só salva area e segmento para a visao de Componente da Comissao e se os campos titular e areaCultural forem informados
                if ((int)$Visao == \VisaoModel::COMPONENTE_DA_COMISSAO && ((int)$titular == 0 || (int)$titular == 1) && !empty($areaCultural)) {
                    $GravarComponente = array(// insert
                        'idAgente' => $idAgente,
                        'cdArea' => $areaCultural,
                        'cdSegmento' => $segmentoCultural,
                        'stTitular' => $titular,
                        'stConselheiro' => 'A');

                    $AtualizarComponente = array(// update
                        'cdArea' => $areaCultural,
                        'cdSegmento' => $segmentoCultural,
                        'stTitular' => $titular
                    );

                    try {
                        // busca a titulacao do agente (titular/suplente de area cultural)
                        $busca = \TitulacaoConselheiroDAO::buscarComponente($idAgente, $Visao);

                        if (!$busca) {
                            $i = \TitulacaoConselheiroDAO::gravarComponente($GravarComponente);
                        } else {
                            $i = \TitulacaoConselheiroDAO::atualizaComponente($idAgente, $AtualizarComponente);
                        }
                    } catch (Exception $e) {
                        throw new Exception("Erro ao salvar a &aacute;rea e segmento: " . $e->getMessage());
                    }
                }

                // ============================= FIM SALVAR TITULACAO (area/SEGMENTO DO COMPONENTE DA COMISSAO) ===========================

            endif;

            // =========================================== INICIO SALVAR ENDERECOS ====================================================
            $cepEndereco = $this->_request->getParam("cep");
            $tipoEndereco = $this->_request->getParam("tipoEndereco");
            $ufEndereco = $this->_request->getParam("uf");
            $CidadeEndereco = $this->_request->getParam("cidade");
            $Endereco = $this->_request->getParam("logradouro");
            $divulgarEndereco = $this->_request->getParam("divulgarEndereco");
            $tipoLogradouro = $this->_request->getParam("tipoLogradouro");
            $numero = $this->_request->getParam("numero");
            $complemento = $this->_request->getParam("complemento");
            $bairro = $this->_request->getParam("bairro");
            $enderecoCorrespodencia = 1;

            try {
                $arrayEnderecos = array(
                    'idagente' => $idAgente,
                    'cep' => str_replace(".", "", str_replace("-", "", $cepEndereco)),
                    'tipoendereco' => $tipoEndereco,
                    'uf' => $ufEndereco,
                    'cidade' => $CidadeEndereco,
                    'logradouro' => $Endereco,
                    'divulgar' => $divulgarEndereco,
                    'tipologradouro' => $tipoLogradouro,
                    'numero' => $numero,
                    'complemento' => $complemento,
                    'bairro' => $bairro,
                    'status' => $enderecoCorrespodencia,
                    'usuario' => $usuario
                );

                $enderecoDAO = new \Agente_Model_EnderecoNacionalDAO();
                $insere = $enderecoDAO->inserir($arrayEnderecos);
            } catch (Exception $e) {
                throw new Exception("Erro ao salvar o endere&ccedil;o: " . $e->getMessage());
            }
            // ============================================= FIM SALVAR ENDERECOS ====================================================

            // =========================================== INICIO SALVAR TELEFONES ====================================================
            $exibirTelefone = $this->_request->getParam("exibirTelefone");
            if ($exibirTelefone == 's') {
                $tipoFone = $this->_request->getParam("tipoFone");
                $ufFone = $this->_request->getParam("ufFone");
                $dddFone = $this->_request->getParam("dddFone");
                $Fone = $this->_request->getParam("fone");
                $divulgarFone = $this->_request->getParam("divulgarFone");

                try {
                    $arrayTelefones = array(
                        'idagente' => $idAgente,
                        'tipotelefone' => $tipoFone,
                        'uf' => $ufFone,
                        'ddd' => $dddFone,
                        'numero' => $Fone,
                        'divulgar' => $divulgarFone,
                        'usuario' => $usuario
                    );

                    $insereTelefone = new \Agente_Model_DbTable_Telefones();
                    $insere = $insereTelefone->insert($arrayTelefones);
                } catch (Exception $e) {
                    throw new Exception("Erro ao salvar o telefone: " . $e->getMessage());
                }
            }
            // =========================================== FIM SALVAR TELEFONES ====================================================

            // =========================================== INICIO SALVAR EMAILS ====================================================
            $exibirEmail = $this->_request->getParam("exibirEmail");
            if ($exibirEmail == 's') {
                $tipoEmail = $this->_request->getParam("tipoEmail");
                $Email = $this->_request->getParam("email");
                $divulgarEmail = $this->_request->getParam("divulgarEmail");
                $enviarEmail = 1;

                try {
                    $arrayEmail = array(
                        'idagente' => $idAgente,
                        'tipointernet' => $tipoEmail,
                        'descricao' => $Email,
                        'status' => $enviarEmail,
                        'divulgar' => $divulgarEmail,
                        'usuario' => $usuario
                    );

                    $insere = new \Agente_Model_Email();
                    $insere = $insere->inserir($arrayEmail);
                } catch (Exception $e) {
                    throw new Exception("Erro ao salvar o e-mail: " . $e->getMessage());
                }
            }
            // =========================================== FIM SALVAR EMAILS ====================================================

            // ================ INICIO SALVAR VINCULO DO RESPONSAVEL COM ELE MESMO (PROPONENTE) ================
            $movimentacacaobancaria = $this->_request->getParam('movimentacaobancaria');
            $acao = null;
            if (empty($movimentacacaobancaria)) {
                try {
                    $this->vincular($cpf, $idAgente);
                } catch (Exception $e) {
                    throw new Exception("Erro ao vincular agente: " . $e->getMessage());
                }
                // ================ FIM SALVAR VINCULO DO RESPONSAVEL COM ELE MESMO (PROPONENTE) ================

                // Caso venha do UC 89 Solicitar Vinculo
                $acao = $this->_request->getParam('acao');
                #$idResponsavel = $this->idResponsavel;
                $idResponsavel = 0;

                // ============== VINCULA O RESPONSAVEL COM O PROPONENTE CADASTRADO =============================
                if ((!empty($acao)) && (!empty($idResponsavel))):
                    $tbVinculo = new \Agente_Model_DbTable_TbVinculo();
                    $dadosVinculo = array(
                        'idAgenteProponente' => $idAgente,
                        'dtVinculo' => new \Zend_Db_Expr('GETDATE()'),
                        'siVinculo' => 0,
                        'idUsuarioResponsavel' => $idResponsavel
                    );
                    $tbVinculo->inserir($dadosVinculo);
                endif;
            }

            //================ FIM VINCULA O RESPONSAVEL COM O PROPONENTE CADASTRADO ========================
            if (isset($acao) && $acao != '') {
                // Retorna para o listar propostas
                $tbVinculo = new \Agente_Model_DbTable_TbVinculo();
                $dadosVinculo = array(
                    'idAgenteProponente' => $idAgente,
                    'dtVinculo' => new \Zend_Db_Expr('GETDATE()'),
                    'siVinculo' => 0,
                    'idUsuarioResponsavel' => $arrAuth['IdUsuario']
                );
                $tbVinculo->inserir($dadosVinculo);
            }

            // Se vim do UC 10 - solicitar alteracao no Projeto
            // Chega aqui com o idpronac
            $idpronac = $this->_request->getParam('idpronac');
            // Se vim do UC38 - Movimentacao bancaria - Captacao
            $projetofnc = $this->_request->getParam('cadastrarprojeto');

            # tratamento para disparar "js custom event" no dispatch
            $agente = \Agente_Model_ManterAgentesDAO::buscarAgentes($cpf);
            $agente = $agente[0];
            $agente->id = $agente->idagente;
            $agente->cpfCnpj = $agente->cnpjcpf;

            $agenteArray = (array)$agente;
            array_walk($agenteArray, function ($value, $key) use ($agente) {
                $agente->$key = utf8_encode($value);
            });

            $this->salvarAgenteRedirect($agente, $idpronac, $projetofnc, $movimentacacaobancaria, $acao);
        } catch (Exception $e) {
            if ($this->modal == 's') {
                $this->_helper->json(['status' => 'error', 'msg' => $e->getMessage()]);
            } else {
                parent::message($e->getMessage(), "agente/agentes/incluiragente", "ERROR");
            }
        }
    }

    /**
     * Metodo salvaagentegeral()
     * Salva os dados do agente
     * @access public
     * @param void
     * @return void
     */
    public function salvaagentegeralAction()
    {
        $this->autenticacao();
        $this->salvaragente();
    }

}
