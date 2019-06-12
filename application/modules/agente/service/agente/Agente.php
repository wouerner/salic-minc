<?php

namespace Application\Modules\agente\service\agente;

class Agente
{
    const DIAS_LIMITE_PARA_ATUALIZACAO = 183;

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
        if(empty($dados)){
            return null;
        }

        $dtatual = new \DateTime(); //data atual
        $data = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($dados)));
        return $dtatual->diff($data);
    }

    /**
     * Metodo de Cadastro e Atualização de agentes com consulta ao InfoConv
     * @access public
     * @param $cpf (cpf ou cnpj)
     * @return \ArrayObject
     */
    public function cadastrarAgente($cpfCnpj)
    {
        $agenteRetorno = \Agente_Model_ManterAgentesDAO::buscarAgentes($cpfCnpj);
        $agente = (array)current($agenteRetorno);

        if (empty($agente)) {
            return $this->consultarServicoReceita($cpfCnpj, '');
        }
        $diferencaEntreDatas = $this->obterDiferencaDatas($agente['dtatualizacao'])->days;
        if ($diferencaEntreDatas < self::DIAS_LIMITE_PARA_ATUALIZACAO) {

            $novoAgente = [];
            $novoAgente['msgCPF'] = 'cadastrado';
            $novoAgente['idAgente'] = $agente['idagente'];
            $novoAgente['Nome'] = $agente['nome'];
            $novoAgente['agente'] = $agente;
            return $novoAgente;
        }

        return $this->consultarServicoReceita($cpfCnpj, $agente);
    }

    /**
     * Metodo consulta Agente Fisico/Juridico no Serviço que consulta Receita Federal
     * chamada -> function cadastrarAgente()
     * @param $cpf, $idAgente
     * @return \ArrayObject
     */

    private function consultarServicoReceita($cpfCnpj, $agente = null)
    {
        $idAgente = $agente ? $agente['idagente'] : '';
        $parametrosDoRetorno = strlen($cpfCnpj) == 11 ? 'nmPessoaFisica' : 'nmRazaoSocial';
        $servico = strlen($cpfCnpj) == 11 ? 'consultarPessoaFisicaReceitaFederal' : 'consultarPessoaJuridicaReceitaFederal';

        #Instancia a Classe de Servico do WebService da Receita Federal
        $wsServico = new \ServicosReceitaFederal();

        $arrResultado = $wsServico->{$servico}($cpfCnpj);
        try {

            $novoAgente = [];
            $novoAgente['msgCPF'] = 'novo';

            if (!empty($arrResultado) && !empty($idAgente)) {

                $dtSituacaoCadastral = !empty($arrResultado['situacaoCadastral']) ?
                                              $arrResultado['situacaoCadastral']['dtSituacaoCadastral'] : '';

                $diferencaEntreDatasServico = $this->obterDiferencaDatas($dtSituacaoCadastral)->days;

                if (empty($dtSituacaoCadastral) || $diferencaEntreDatasServico > self::DIAS_LIMITE_PARA_ATUALIZACAO) {
                    $arrResultado = $wsServico->{$servico}($cpfCnpj, true);
                    if (!empty($arrResultado["erro"])) {
                        throw new \Exception("Inválido");
                    }
                    $novoAgente['msgCPF'] = 'atualizado';
                }

                $novoAgente['idAgente'] = $idAgente;
                $agente['nome'] = utf8_encode($arrResultado[$parametrosDoRetorno]);
                $this->salvarNomeRazaoSocial($idAgente, $agente);

            } else {
                $arrResultado = $wsServico->{$servico}($cpfCnpj, true);
                if (!empty($arrResultado["erro"])) {
                    throw new \Exception("Inválido");
                }
            }
            $novoAgente['Nome'] = $arrResultado[$parametrosDoRetorno];
            $novoAgente['Cep'] = isset($arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep']) &&
                                       $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] ?
                                       $arrResultado['pessoa']['enderecos'][0]['logradouro']['nrCep'] : '';
            return $novoAgente;
        } catch (\Exception $exception) {
            return $novoAgente['msgCPF'] = $exception->getMessage();
        }
    }

    /**
     * salvarNomeRazaoSocial
     *
     * @access private
     * @return void
     * @todo refatorar metodo para um generico que possa salvar todas as possibilidades para Agentes
     */
    private function salvarNomeRazaoSocial($idAgente = null, $modelAgente = null)
    {
        try {
            $nome = $modelAgente[0]->nome ? $modelAgente[0]->nome : $modelAgente['nome'];
            $nome = preg_replace('/[\'\"\n\`\´]/', '', $nome);
            $mprNomes = new \Agente_Model_DbTable_Nomes;
            $mprNomes->alterar(['Descricao'=>$nome],['idAgente = ?'=> $idAgente]);
            $mpAgente = new \Agente_Model_DbTable_Agentes;
            $dataAtualizada = new \DateTime();
            $mpAgente->alterar(['DtAtualizacao'=> $dataAtualizada->format('Y-m-d h:i:s') ],['idAgente = ?'=> $idAgente]);

        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar a Raz&atilde;o Social: " . $e->getMessage());
        }
    }

}
