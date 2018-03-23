<?php

class Readequacao_RemanejamentoMenorController extends MinC_Controller_Action_Abstract
{
    private $blnProponente  = false;
    
    /**
     * init()
     * @access public
     * @param void
     * @return void
     */
    public function init()
    {
        $PermissoesGrupo = [];
        
        $auth = Zend_Auth::getInstance();
        $this->view->usuarioInterno = false;

        if (isset($auth->getIdentity()->usu_codigo)) {
            $this->view->usuarioInterno = true;
            
            $Usuario = new Autenticacao_Model_Usuario();
            $grupos = $Usuario->buscarUnidades($auth->getIdentity()->usu_codigo, 21);
            foreach ($grupos as $grupo) {
                $PermissoesGrupo[] = $grupo->gru_codigo;
            }
        }
        
        if (isset($auth->getIdentity()->usu_codigo)) {
            parent::perfil(1, $PermissoesGrupo);
            $this->getIdUsuario = UsuarioDAO::getIdUsuario($auth->getIdentity()->usu_codigo);
            $this->getIdUsuario = ($this->getIdUsuario) ? $this->getIdUsuario["idAgente"] : 0;
        } else { // autenticacao scriptcase
            $this->blnProponente = true;
            parent::perfil(4, $PermissoesGrupo);
            $this->getIdUsuario = (isset($_GET["idusuario"])) ? $_GET["idusuario"] : 0;

            /* =============================================================================== */
            /* ==== VERIFICA PERMISSAO DE ACESSO DO PROPONENTE A PROPOSTA OU AO PROJETO ====== */
            /* =============================================================================== */
            $this->verificarPermissaoAcesso(false, true, false);
        }
        
        parent::init();
        
        if (!$auth->hasIdentity()) {
            $url = Zend_Controller_Front::getInstance()->getBaseUrl();
            JS::redirecionarURL($url);
        }
        
        $idPronac = $this->_request->getParam("idPronac");
        $this->view->idPronac = $idPronac;
        
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
            $this->view->idPronac = $idPronac;
        }
        
        if (empty($idPronac)) {
            $url = Zend_Controller_Front::getInstance()->getBaseUrl()."/listarprojetos/listarprojetos";
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->flashMessenger->addMessage("Nenhum projeto encontrado com o n&uacute;mero de Pronac informado");
            $this->_helper->flashMessengerType->addMessage("ERROR");
            JS::redirecionarURL($url);
            $this->_helper->viewRenderer->setNoRender(true);
        }

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
                'ReadequacaoPlanilha' => $linksGeral[14]
            );
            $this->view->fnLiberarLinks = $arrayLinks;
        }
    }

    public function indexAction()
    {
        if (!$this->blnProponente) {
            parent::message("Sem permiss&atilde;o para remanejar o projeto!", "listarprojetos/listarprojetos", "ERROR");
        }
        
        //REMANEJAMENTO MENOR OU IGUAL A 50%
        $idPronac = $this->_request->getParam("idPronac");
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }
        
        $projetos = new Projetos();
        $DadosProjeto = $projetos->buscarProjetoXProponente(array('idPronac = ?' => $idPronac))->current();
        $this->view->DadosProjeto = $DadosProjeto;
        
        $readequacao = new Readequacao_Model_tbReadequacao();
        $existeRemanejamento50EmAndamento = $readequacao->existeRemanejamento50EmAndamento($idPronac);
        
        if ($existeRemanejamento50EmAndamento) {
            $tbPlanilhaAprovacao = new PlanilhaAprovacao();
            $planilhaOrcamentaria = $tbPlanilhaAprovacao->visualizarPlanilhaEmRemanejamento($idPronac);
            
            $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
            $this->view->readequacao = $Readequacao_Model_tbReadequacao->buscar(
                array(
                    'idPronac = ?' => $idPronac,
                    'stEstado =?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO,
                    'idTipoReadequacao=?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL
                )
            )->current();
        } elseif (!$existeRemanejamento50EmAndamento) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB :: FETCH_OBJ);
            $countTpPlanilhaRemanej = $db->fetchOne($sql);
            
            $spVisualizarPlanilhaOrcamentaria = new spVisualizarPlanilhaOrcamentaria();
            $planilhaOrcamentaria = $spVisualizarPlanilhaOrcamentaria->exec($idPronac);
        }
        
        $planilha = $this->montarPlanilhaOrcamentaria($planilhaOrcamentaria, PlanilhaAprovacao::TIPO_PLANILHA_REMANEJADA);
        
        $this->view->planilha = $planilha;
        $this->view->tipoPlanilha = PlanilhaAprovacao::TIPO_PLANILHA_REMANEJADA;
    }

    public function finalizarAction()
    {
        //REMANEJAMENTO MENOR OU IGUAL A 50%
        $idPronac = $this->_request->getParam("idPronac");
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();

        //ARRAY PARA BUSCAR VALOR TOTAL DA PLANILHA ATIVA
        $where = array();
        $where['a.IdPRONAC = ?'] = $idPronac;
        $where['a.stAtivo = ?'] = 'S';

        //PLANILHA ATIVA - GRUPO A
        $where['a.idEtapa in (?)'] = array(1,2);
        $PlanilhaAtivaGrupoA = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        //PLANILHA ATIVA - GRUPO B
        $where['a.idEtapa in (?)'] = array(3);
        $PlanilhaAtivaGrupoB = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        //PLANILHA ATIVA - GRUPO C
        $where['a.idEtapa in (?)'] = array(4);
        $PlanilhaAtivaGrupoC = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        //PLANILHA ATIVA - GRUPO D
        $where['a.idEtapa in (?)'] = array(5);
        $PlanilhaAtivaGrupoD = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $readequacaoAtiva = $Readequacao_Model_tbReadequacao->buscar(
            array(
                'idPronac = ?' => $idPronac,
                'stEstado = ?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO,
                'idTipoReadequacao = ?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL
            )
        );
        $idReadequacao = $readequacaoAtiva[0]['idReadequacao'];

        //ARRAY PARA BUSCAR VALOR TOTAL DA PLANILHA REMANEJADA
        $where = array();
        $where['a.IdPRONAC = ?'] = $idPronac;
        $where['a.tpPlanilha = ?'] = 'RP';
        $where['a.stAtivo = ?'] = 'N';
        $where['a.idReadequacao = ?'] = $idReadequacao;
        
        //PLANILHA ATIVA - GRUPO A
        $where['a.idEtapa in (?)'] = array(1,2);
        $PlanilhaRemanejadaGrupoA = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        //PLANILHA ATIVA - GRUPO B
        $where['a.idEtapa in (?)'] = array(3);
        $PlanilhaRemanejadaGrupoB = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        //PLANILHA ATIVA - GRUPO C
        $where['a.idEtapa in (?)'] = array(4);
        $PlanilhaRemanejadaGrupoC = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        //PLANILHA ATIVA - GRUPO D
        $where['a.idEtapa in (?)'] = array(5);
        $PlanilhaRemanejadaGrupoD = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        //Os grupos est�o relacionados na tabela SAC.dbo.tbPlanilhaEtapa
        $valorTotalGrupoA = 0;
        $valorTotalGrupoB = 0;
        $valorTotalGrupoC = 0;
        $valorTotalGrupoD = 0;

        $valorTotalGrupoA = $PlanilhaAtivaGrupoA->Total-$PlanilhaRemanejadaGrupoA->Total;
        $valorTotalGrupoB = $PlanilhaAtivaGrupoB->Total-$PlanilhaRemanejadaGrupoB->Total;
        $valorTotalGrupoC = $PlanilhaAtivaGrupoC->Total-$PlanilhaRemanejadaGrupoC->Total;
        $valorTotalGrupoD = $PlanilhaAtivaGrupoD->Total-$PlanilhaRemanejadaGrupoD->Total;

        // caso haja saldo positivo nos grupos B, C ou D, remaneja saldo para grupo A
        if (!empty($PlanilhaRemanejadaGrupoB->Total) && $valorTotalGrupoB > 0) {
            $PlanilhaRemanejadaGrupoA->Total += $valorTotalGrupoB; // adiciona saldo de B a A
            $valorTotalGrupoA += $valorTotalGrupoB;                // adiciona ao total de A
            $PlanilhaRemanejadaGrupoB->Total += $valorTotalGrupoB; // zera saldo de B
        }
        if (!empty($PlanilhaRemanejadaGrupoC->Total) && $valorTotalGrupoC > 0) {
            $PlanilhaRemanejadaGrupoA->Total += $valorTotalGrupoC;
            $valorTotalGrupoA += $valorTotalGrupoC;
            $PlanilhaRemanejadaGrupoC->Total += $valorTotalGrupoC;
        }
        if (!empty($PlanilhaRemanejadaGrupoD->Total) && $valorTotalGrupoD > 0) {
            $PlanilhaRemanejadaGrupoA->Total += $valorTotalGrupoD;
            $valorTotalGrupoA += $valorTotalGrupoD;
            $PlanilhaRemanejadaGrupoD->Total += $valorTotalGrupoD;
        }
        
        $erros = 0;
        
        if (!empty($PlanilhaRemanejadaGrupoA->Total) && $PlanilhaAtivaGrupoA->Total != $PlanilhaRemanejadaGrupoA->Total) {
            if ($valorTotalGrupoA != 0) {
                $erros++;
            }
        }
        
        if (!empty($PlanilhaRemanejadaGrupoB->Total) && $PlanilhaAtivaGrupoB->Total != $PlanilhaRemanejadaGrupoB->Total) {
            $erros++;
        }

        if (!empty($PlanilhaRemanejadaGrupoC->Total) && $PlanilhaAtivaGrupoC->Total != $PlanilhaRemanejadaGrupoC->Total) {
            $erros++;
        }

        if (!empty($PlanilhaRemanejadaGrupoD->Total) && $PlanilhaAtivaGrupoD->Total != $PlanilhaRemanejadaGrupoD->Total) {
            $erros++;
        }
        
        $id = Seguranca::encrypt($idPronac);
        if ($erros > 0) {
            parent::message("<b>A T E N &Ccedil; &Atilde;; O !!!</b> Para finalizar a opera&ccedil;&atilde;o de remanejamento os valores da coluna 'Valor da Planilha Remanejada' devem ser igual a R$0,00 (zero real).", "readequacao/remanejamento-menor?idPronac=$id", "ERROR");
        } else {
            $auth = Zend_Auth::getInstance(); // pega a autentica��o
            $tblAgente = new Agente_Model_DbTable_Agentes();
            $rsAgente = $tblAgente->buscar(array('CNPJCPF=?'=>$auth->getIdentity()->Cpf))->current();

            
            $dadosReadequacao = array();
            $dadosReadequacao['idPronac'] = $idPronac;
            $dadosReadequacao['dtSolicitacao'] = new Zend_Db_Expr('GETDATE()');
            $dadosReadequacao['idSolicitante'] = $rsAgente->idAgente;
            $dadosReadequacao['dsJustificativa'] = utf8_decode('Readequação até 50%');
            $dadosReadequacao['stEstado'] = Readequacao_Model_tbReadequacao::ST_ESTADO_FINALIZADO;
            $update = $Readequacao_Model_tbReadequacao->update(
                $dadosReadequacao,
                array(
                    'idPronac=?' => $idPronac,
                    'idTipoReadequacao=?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL,
                    'stAtendimento=?' => 'D',
                    'siEncaminhamento=?' => Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_NAO_ENVIA_MINC,
                    'stEstado = ?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO,
                    'idReadequacao=?' => $idReadequacao
                )
            );
            
            if ($update > 0) {
                $dadosReadequacaoAnterior = array('stAtivo' => 'N');
                $whereReadequacaoAnterior = array(
                    'IdPRONAC = ?' => $idPronac,
                    'stAtivo = ?' => 'S'
                );
                $update = $tbPlanilhaAprovacao->update($dadosReadequacaoAnterior, $whereReadequacaoAnterior);
                
                $dadosReadequacaoNova = array('stAtivo' => 'S');
                $whereReadequacaoNova = array(
                    'IdPRONAC = ?' => $idPronac,
                    'stAtivo = ?' => 'N',
                    'idReadequacao=?' => $idReadequacao
                );
                $tbPlanilhaAprovacao->update($dadosReadequacaoNova, $whereReadequacaoNova);
                parent::message("O remanejamento foi finalizado com sucesso!", "consultardadosprojeto?idPronac=$id", "CONFIRM");
            } else {
                parent::message("Ocorreu um erro durante o cadastro do remanejamento!", "consultardadosprojeto?idPronac=$id", "ERROR");
            }
        }
    }
    
    public function carregarValorPorGrupoRemanejamentoAction()
    {
        $this->_helper->layout->disableLayout(); // Desabilita o Zend Layout
        $idPronac = $this->_request->getParam("idPronac");
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }
        
        try {
            $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();

            //ARRAY PARA BUSCAR VALOR TOTAL DA PLANILHA ATIVA
            $where = array();
            $where['a.IdPRONAC = ?'] = $idPronac;
            $where['a.stAtivo = ?'] = 'S';

            //PLANILHA ATIVA - GRUPO A
            $where['a.idEtapa in (?)'] = array(1,2);
            $PlanilhaAtivaGrupoA = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

            //PLANILHA ATIVA - GRUPO B
            $where['a.idEtapa in (?)'] = array(3);
            $PlanilhaAtivaGrupoB = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

            //PLANILHA ATIVA - GRUPO C
            $where['a.idEtapa in (?)'] = array(4);
            $PlanilhaAtivaGrupoC = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

            //PLANILHA ATIVA - GRUPO D
            $where['a.idEtapa in (?)'] = array(5);
            $PlanilhaAtivaGrupoD = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

            $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
            $readequacaoAtiva = $Readequacao_Model_tbReadequacao->buscar(
                array(
                    'idPronac = ?'=> $idPronac,
                    'idTipoReadequacao = ?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL,
                    'stEstado = ?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO
                )
            );
            
            $where = array();
            $where['a.IdPRONAC = ?'] = $idPronac;
            
            //ARRAY PARA BUSCAR VALOR TOTAL DA PLANILHA REMANEJADA
            if (count($readequacaoAtiva) > 0) {
                $idReadequacao = $readequacaoAtiva[0]['idReadequacao'];

                $where['a.tpPlanilha = ?'] = 'RP';
                $where['a.stAtivo = ?'] = 'N';
                $where['a.idReadequacao = ?'] = $idReadequacao;
            } elseif (count($readequacaoAtiva) == 0) {
                $where['a.stAtivo = ?'] = 'S';
            }
            
            $PlanilhaRemanejada = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();
            
            //PLANILHA ATIVA - GRUPO A
            $where['a.idEtapa in (?)'] = array(1,2);
            $PlanilhaRemanejadaGrupoA = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

            //PLANILHA ATIVA - GRUPO B
            $where['a.idEtapa in (?)'] = array(3);
            $PlanilhaRemanejadaGrupoB = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

            //PLANILHA ATIVA - GRUPO C
            $where['a.idEtapa in (?)'] = array(4);
            $PlanilhaRemanejadaGrupoC = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

            //PLANILHA ATIVA - GRUPO D
            $where['a.idEtapa in (?)'] = array(5);
            $PlanilhaRemanejadaGrupoD = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

            //Os grupos est�o relacionados na tabela SAC.dbo.tbPlanilhaEtapa
            $valorTotalGrupoA = 0;
            $valorTotalGrupoB = 0;
            $valorTotalGrupoC = 0;
            $valorTotalGrupoD = 0;

            if ($PlanilhaRemanejadaGrupoA->Total > 0) {
                $valorTotalGrupoA = $PlanilhaAtivaGrupoA->Total-$PlanilhaRemanejadaGrupoA->Total;
            }
            if ($PlanilhaRemanejadaGrupoB->Total > 0) {
                $valorTotalGrupoB = $PlanilhaAtivaGrupoB->Total-$PlanilhaRemanejadaGrupoB->Total;
            }
            if ($PlanilhaRemanejadaGrupoC->Total > 0) {
                $valorTotalGrupoC = $PlanilhaAtivaGrupoC->Total-$PlanilhaRemanejadaGrupoC->Total;
            }
            if ($PlanilhaRemanejadaGrupoD->Total > 0) {
                $valorTotalGrupoD = $PlanilhaAtivaGrupoD->Total-$PlanilhaRemanejadaGrupoD->Total;
            }
            
            $valorTotalGrupoASoma = 0;
                        
            $dadosPlanilha = array();
            $dadosPlanilha['dadosPlanilhaAtivaA'] = $PlanilhaAtivaGrupoA->Total;
            $dadosPlanilha['dadosPlanilhaRemanejadaA'] = $PlanilhaRemanejadaGrupoA->Total;

            if ($PlanilhaAtivaGrupoA->Total == $PlanilhaRemanejadaGrupoA->Total) {
                $dadosPlanilha['GrupoA'] = utf8_encode('<span class="bold">R$ '.number_format($valorTotalGrupoA, 2, ',', '.')).'</span>';
            } elseif ($PlanilhaAtivaGrupoA->Total < $PlanilhaRemanejadaGrupoA->Total) {
                $dadosPlanilha['GrupoA'] = utf8_encode('<span class="red bold">R$ '.number_format($valorTotalGrupoA, 2, ',', '.')).'</span>';
            } elseif (!empty($PlanilhaRemanejadaGrupoA->Total)) {
                $dadosPlanilha['GrupoA'] = utf8_encode('<span class="blue bold">R$ '.number_format($valorTotalGrupoA, 2, ',', '.')).'</span>';
            }
            
            if ($PlanilhaAtivaGrupoB->Total == $PlanilhaRemanejadaGrupoB->Total) {
                $dadosPlanilha['GrupoB'] = utf8_encode('<span class="bold">R$ '.number_format($valorTotalGrupoB, 2, ',', '.')).'</span>';
            } elseif ($PlanilhaAtivaGrupoB->Total < $PlanilhaRemanejadaGrupoB->Total) {
                $dadosPlanilha['GrupoB'] = utf8_encode('<span class="red bold">R$ '.number_format($valorTotalGrupoB, 2, ',', '.')).'</span>';
            } elseif (!empty($PlanilhaRemanejadaGrupoB->Total)) {
                $dadosPlanilha['GrupoB'] = utf8_encode('<span class="blue bold">R$ '.number_format($valorTotalGrupoB, 2, ',', '.')).'</span>';
                $valorTotalGrupoASoma += $valorTotalGrupoB;
            }

            if ($PlanilhaAtivaGrupoC->Total == $PlanilhaRemanejadaGrupoC->Total) {
                $dadosPlanilha['GrupoC'] = utf8_encode('<span class="bold">R$ '.number_format($valorTotalGrupoC, 2, ',', '.')).'</span>';
            } elseif ($PlanilhaAtivaGrupoC->Total < $PlanilhaRemanejadaGrupoC->Total) {
                $dadosPlanilha['GrupoC'] = utf8_encode('<span class="red bold">R$ '.number_format($valorTotalGrupoC, 2, ',', '.')).'</span>';
            } elseif (!empty($PlanilhaRemanejadaGrupoC->Total)) {
                $dadosPlanilha['GrupoC'] = utf8_encode('<span class="blue bold">R$ '.number_format($valorTotalGrupoC, 2, ',', '.')).'</span>';
                $valorTotalGrupoASoma += $valorTotalGrupoC;
            }
            
            if ($PlanilhaAtivaGrupoD->Total == $PlanilhaRemanejadaGrupoD->Total) {
                $dadosPlanilha['GrupoD'] = utf8_encode('<span class="bold">R$ '.number_format($valorTotalGrupoD, 2, ',', '.')).'</span>';
            } elseif ($PlanilhaAtivaGrupoD->Total < $PlanilhaRemanejadaGrupoD->Total) {
                $dadosPlanilha['GrupoD'] = utf8_encode('<span class="red bold">R$ '.number_format($valorTotalGrupoD, 2, ',', '.')).'</span>';
            } elseif (!empty($PlanilhaRemanejadaGrupoC->Total)) {
                $dadosPlanilha['GrupoD'] = utf8_encode('<span class="blue bold">R$ '.number_format($valorTotalGrupoD, 2, ',', '.')).'</span>';
                $valorTotalGrupoASoma += $valorTotalGrupoD;
            }

            $valorTotalGrupoASoma = round($valorTotalGrupoASoma, 2) + round($valorTotalGrupoA, 2);
            if ($valorTotalGrupoASoma == 0) {
                $dadosPlanilha['Somatoria'] .= utf8_encode(' <span class="bold">R$ '.number_format($valorTotalGrupoASoma, 2, ',', '.')).' (A+B+C+D)</span>';
            } elseif ($valorTotalGrupoASoma < 0) {
                $dadosPlanilha['Somatoria'] .= utf8_encode(' <span class="red bold">R$ '.number_format($valorTotalGrupoASoma, 2, ',', '.')).' (A+B+C+D)</span>';
            } else {
                $dadosPlanilha['Somatoria'] .= utf8_encode(' <span class="blue bold">R$ '.number_format($valorTotalGrupoASoma, 2, ',', '.')).' (A+B+C+D)</span>';
            }
            
            if (empty($PlanilhaRemanejada->Total) || $PlanilhaRemanejada->Total == 0) {
                $dadosPlanilha['GrupoA'] = utf8_encode('<span class="bold">R$ '.number_format(0, 2, ',', '.')).'</span>';
                $dadosPlanilha['GrupoB'] = utf8_encode('<span class="bold">R$ '.number_format(0, 2, ',', '.')).'</span>';
                $dadosPlanilha['GrupoC'] = utf8_encode('<span class="bold">R$ '.number_format(0, 2, ',', '.')).'</span>';
                $dadosPlanilha['GrupoD'] = utf8_encode('<span class="bold">R$ '.number_format(0, 2, ',', '.')).'</span>';
            }
            
            $this->_helper->json(array('resposta'=>true, 'dadosPlanilha'=>$dadosPlanilha));
        } catch (Zend_Exception $e) {
            $this->_helper->json(array('resposta'=>false));
        }
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function carregarValorEntrePlanilhasAction()
    {
        $auth = Zend_Auth::getInstance(); // pega a autenticacao
        $this->_helper->layout->disableLayout(); // desabilita o Zend_Layout
        $get = Zend_Registry::get('get');
        $idPronac = $this->_request->getParam("idPronac");
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();

        //BUSCAR VALOR TOTAL DA PLANILHA ATIVA
        $where = array();
        $where['a.IdPRONAC = ?'] = $idPronac;
        $where['a.stAtivo = ?'] = 'S';
        $PlanilhaAtiva = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();
        //x($PlanilhaAtiva->Total);

        //BUSCAR VALOR TOTAL DA PLANILHA DE REMANEJADA
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $readequacaoAtiva = $Readequacao_Model_tbReadequacao->buscar(
            array(
                'idPronac = ?'=> $idPronac,
                'idTipoReadequacao = ?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL,
                'stEstado = ?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO
            )
        );
        
        $where = array();
        $where['a.IdPRONAC = ?'] = $idPronac;
        $where['a.tpPlanilha = ?'] = 'RP';
        $where['a.stAtivo = ?'] = 'N';
        $where['a.tpAcao != ?'] = 'E';

        if (count($readequacaoAtiva) > 0) {
            $idReadequacao = $readequacaoAtiva[0]['idReadequacao'];
            $where['a.idReadequacao = ?'] = $idReadequacao;
        }
        
        $PlanilhaRemanejada = $tbPlanilhaAprovacao->valorTotalPlanilha($where)->current();

        if ($PlanilhaRemanejada->Total > 0) {
            if ($PlanilhaAtiva->Total == $PlanilhaRemanejada->Total) {
                $statusPlanilha = 'neutro';
            } elseif ($PlanilhaAtiva->Total > $PlanilhaRemanejada->Total) {
                $statusPlanilha = 'positivo';
            } else {
                $statusPlanilha = 'negativo';
            }
        } else {
            $PlanilhaAtiva->Total = 0;
            $PlanilhaRemanejada->Total = 0;
            $statusPlanilha = 'neutro';
        }

        $this->montaTela(
            'remanejamento-menor/carregar-valor-entre-planilhas.phtml',
            array(
            'statusPlanilha' => $statusPlanilha,
            'vlDiferencaPlanilhas' => 'R$ '.number_format(($PlanilhaAtiva->Total-$PlanilhaRemanejada->Total), 2, ',', '.')
            )
        );
    }

    public function reintegrarItemAction()
    {
        $this->_helper->layout->disableLayout();
        $idPlanilhaAprovacao = $this->_request->getParam("idPlanilha");
        $idPlanilhaAprovacaoPai = $this->_request->getParam("idPlanilhaAprovacaoPai");
        $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();
        
        $auth = Zend_Auth::getInstance(); // pega a autentica��o
        $tblAgente = new Agente_Model_DbTable_Agentes();
        $rsAgente = $tblAgente->buscar(array('CNPJCPF = ?'=>$auth->getIdentity()->Cpf));
        if ($rsAgente->count() > 0) {
            $idAgente = $rsAgente[0]->idAgente;
        }

        /* DADOS DO ITEM ATIVO */
        $where = array();
        $where['idPlanilhaAprovacao = ?'] = $idPlanilhaAprovacaoPai;
        $where['stAtivo = ?'] = 'S';
        $planilhaAtiva = $tbPlanilhaAprovacao->buscar($where)->current();
        
        try {
            $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
            $readequacaoAtiva = $Readequacao_Model_tbReadequacao->buscar(
                array(
                    'idPronac = ?' => $idPronac,
                    'idTipoReadequacao = ?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL,
                    'stEstado = ?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO
                )
            );
            
            $where = array();
            $where['idPlanilhaAprovacaoPai = ?'] = $idPlanilhaAprovacaoPai;
            $where['idReadequacao = ?'] = $idReadequacao;
            $where['tpPlanilha = ?'] = 'RP';
            $where['stAtivo = ?'] = 'N';
            $item = $tbPlanilhaAprovacao->buscar($where)->current();
            $item->qtItem = $planilhaAtiva->qtItem;
            $item->nrOcorrencia = $planilhaAtiva->nrOcorrencia;
            $item->vlUnitario = $planilhaAtiva->vlUnitario;
            $item->dsJustificativa = null;
            $item->idAgente = $idAgente;
            
            $dadosPlanilhaEditavel = array();
            $dadosPlanilhaEditavel['Quantidade'] = $planilhaAtiva->qtItem;
            $dadosPlanilhaEditavel['Ocorrencia'] = $planilhaAtiva->nrOcorrencia;
            $dadosPlanilhaEditavel['ValorUnitario'] = utf8_encode('R$ '.number_format($planilhaAtiva->vlUnitario, 2, ',', '.'));
            $dadosPlanilhaEditavel['TotalSolicitado'] = utf8_encode('R$ '.number_format(($planilhaAtiva->qtItem*$planilhaAtiva->nrOcorrencia*$planilhaAtiva->vlUnitario), 2, ',', '.'));
            $dadosPlanilhaEditavel['Justificativa'] = '';
            
            $x = $item->save();
            $this->_helper->json(array('resposta'=>true, 'dadosPlanilhaEditavel'=>$dadosPlanilhaEditavel));
        } catch (Zend_Exception $e) {
            $this->_helper->json(array('resposta'=>$e));
        }
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function reintegrarPlanilhaAction()
    {
        $this->_helper->layout->disableLayout();
        $idPronac = $this->_request->getParam("idPronac");
        $idReadequacao = $this->_request->getParam("idReadequacao");
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }
        
        $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();
        
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $readequacao = $Readequacao_Model_tbReadequacao->buscar(
            array(
                'idReadequacao = ?' => $idReadequacao
            )
        );
        
        try {
            if (!empty($readequacao)) {
                $idReadequacao = $readequacao[0]['idReadequacao'];
                
                $del = $tbPlanilhaAprovacao->delete(
                    array(
                        'IdPRONAC = ?'=>$idPronac,
                        'idReadequacao = ?' => $idReadequacao
                    )
                );
                
                if ($del > 0) {
                    $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
                    $readequacaoAtiva = $Readequacao_Model_tbReadequacao->delete(
                        array(
                            'idPronac=?' => $idPronac,
                            'idTipoReadequacao=?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL,
                            'idReadequacao = ?' => $idReadequacao
                        )
                    );
                    
                    $planilhaAtiva = $tbPlanilhaAprovacao->buscarPlanilhaAtiva($idPronac);
                    $this->_helper->json(array('resposta'=>true));
                } else {
                    $msg = utf8_encode('A planilha j&aacute; foi reintegrada.');
                    $this->_helper->json(array('resposta'=>false, 'msg'=>$msg));
                }
            } else {
                $msg = utf8_encode('A planilha j&aacute; foi reintegrada.');
                $this->_helper->json(array('resposta'=>false, 'msg'=>$msg));
            }
        } catch (Zend_Exception $e) {
            $this->_helper->json(array('resposta'=>false, 'msg'=>'Ocorreu um erro durante o processo.'));
        }
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function alterarItemAction()
    {
        $this->_helper->layout->disableLayout();
        $idPlanilhaAprovacao = $this->_request->getParam("idPlanilha");
        $idPlanilhaAprovacaoPai = $this->_request->getParam("idPlanilhaAprovacaoPai");

        if (!$idPlanilhaAprovacao) {
            $this->_helper->json(array('resposta'=>false, 'msg'=>'Informe o idPlanilhaAprovacao.'));
        }
        
        /* DADOS DO ITEM ATIVO */
        $where = array();

        if (empty($idPlanilhaAprovacaoPai) || $idPlanilhaAprovacaoPai == '') {
            $where['idPlanilhaAprovacao = ?'] = $idPlanilhaAprovacao;
        } else {
            $where['idPlanilhaAprovacaoPai = ?'] = $idPlanilhaAprovacaoPai;
        }

        $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();
        $planilhaAtiva = $tbPlanilhaAprovacao->buscarDadosAvaliacaoDeItemRemanejamento($where);

        $idPlanilhaAprovacaoComprovado = (!empty($idPlanilhaAprovacaoPai)) ? array($idPlanilhaAprovacao,$idPlanilhaAprovacaoPai) : $idPlanilhaAprovacao;

       /* DADOS ORIGINAIS PARA REFERÊNCIA DE MÍNIMO E MÁXIMO */
        $idPronac = $planilhaAtiva[0]['idPRONAC'];
        $idPlanilhaItem = $planilhaAtiva[0]['idPlanilhaItem'];

        $whereItemValorComprovado = array();
        $whereItemValorComprovado['b.IdPRONAC = ?'] = $idPronac;
        $whereItemValorComprovado['b.idPlanilhaItem = ?'] = $idPlanilhaItem;
        $whereItemValorComprovado['b.idEtapa = ?'] = $planilhaAtiva[0]['idEtapa'];
        $whereItemValorComprovado['b.idProduto = ?'] = $planilhaAtiva[0]['idProduto'];
        $whereItemValorComprovado['b.idUFDespesa = ?'] = $planilhaAtiva[0]['idUFDespesa'];
        $whereItemValorComprovado['b.idMunicipioDespesa = ?'] = $planilhaAtiva[0]['idMunicipioDespesa'];
        $whereItemValorComprovado['b.nrFonteRecurso = ?'] = $planilhaAtiva[0]['nrFonteRecurso'];

        $tbCompPagxPlanAprov = new tbComprovantePagamentoxPlanilhaAprovacao();
        $resComprovado = $tbCompPagxPlanAprov->buscarValorComprovadoPorFonteProdutoEtapaLocalItem($whereItemValorComprovado);

        $whereItemPlanilhaOriginal = array();
        $whereItemPlanilhaOriginal['tpPlanilha = ?'] = 'CO'; # CO - planilha do componente da comissao (original aprovada)
        $whereItemPlanilhaOriginal['IdPRONAC = ?'] = $idPronac;
        $whereItemPlanilhaOriginal['idPlanilhaItem = ?'] = $idPlanilhaItem;
        $whereItemPlanilhaOriginal['idEtapa = ?'] = $planilhaAtiva[0]['idEtapa'];
        $whereItemPlanilhaOriginal['idProduto = ?'] = $planilhaAtiva[0]['idProduto'];
        $whereItemPlanilhaOriginal['idUFDespesa = ?'] = $planilhaAtiva[0]['idUFDespesa'];
        $whereItemPlanilhaOriginal['idMunicipioDespesa = ?'] = $planilhaAtiva[0]['idMunicipioDespesa'];
        $whereItemPlanilhaOriginal['nrFonteRecurso = ?'] = $planilhaAtiva[0]['nrFonteRecurso'];

        $planilhaOriginal = $tbPlanilhaAprovacao->buscar($whereItemPlanilhaOriginal);

        $dadosPlanilhaOriginal = array();
        foreach ($planilhaOriginal as $registro) {
            $vlTotalItem = $registro['qtItem']*$registro['nrOcorrencia']*$registro['vlUnitario'];
            
            //CALCULAR VALORES MINIMO E MAXIMO PARA VALIDACAO
            $vlAtual = @number_format(($registro['qtItem']*$registro['nrOcorrencia']*$registro['vlUnitario']), 2, '', '');
            $vlAtualPerc = $vlAtual* Readequacao_Model_tbReadequacao::PERCENTUAL_REMANEJAMENTO/100;
            
            //VALOR MINIMO E MAXIMO DO ITEM ORIGINAL
            //SE TIVER VALOR COMPROVADO, DEVE SUBTRAIR O VALOR DO ITEM COMPROVADO DO VALOR UNITARIO
            $vlAtualMin = (number_format($resComprovado->vlComprovado, 2, '', '') > round($vlAtual-$vlAtualPerc)) ? number_format($resComprovado->vlComprovado, 2, '', '') : round($vlAtual-$vlAtualPerc);
            $vlAtualMax = round($vlAtual+$vlAtualPerc);
                
            if ($vlAtualMin > $vlTotalItem) {
                $dadosPlanilhaOriginal['ValorMinimoProItem'] = utf8_encode('R$ '.number_format($vlAtualMin/100, 2, ',', '.'));
            } else {
                $dadosPlanilhaOriginal['ValorMinimoProItem'] = utf8_encode('R$ '.number_format(($vlAtual - ($vlAtual * Readequacao_Model_tbReadequacao::PERCENTUAL_REMANEJAMENTO/100)), 2, ',', '.'));
            }
            $dadosPlanilhaOriginal['ValorMaximoProItem'] = utf8_encode('R$ '.number_format(($vlAtual + ($vlAtual * Readequacao_Model_tbReadequacao::PERCENTUAL_REMANEJAMENTO/100))/100, 2, ',', '.'));
            $dadosPlanilhaOriginal['vlMinimoValidacao'] = utf8_encode($vlAtualMin);
            $dadosPlanilhaOriginal['vlMaximoValidacao'] = utf8_encode($vlAtualMax);
            $dadosPlanilhaOriginal['ValorMinimoProItemValidacao'] = utf8_encode($vlAtualMin);
            $dadosPlanilhaOriginal['ValorMaximoProItemValidacao'] = utf8_encode($vlAtualMax);
            
            $dadosPlanilhaOriginal['idPlanilhaAprovacao'] = $registro['idPlanilhaAprovacao'];
            $dadosPlanilhaOriginal['idPlanilhaItem'] = $registro['idPlanilhaItem'];
            $dadosPlanilhaOriginal['Quantidade'] = $registro['qtItem'];
            $dadosPlanilhaOriginal['Ocorrencia'] = $registro['nrOcorrencia'];
            $dadosPlanilhaOriginal['ValorUnitario'] = utf8_encode('R$ '.number_format($registro['vlUnitario'], 2, ',', '.'));
            $dadosPlanilhaOriginal['TotalSolicitado'] = utf8_encode('R$ '.number_format(($vlTotalItem), 2, ',', '.'));
        }
        
        /* DADOS DO ITEM PARA EDICAO DO REMANEJAMENTO */

        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $readequacaoAtiva = $Readequacao_Model_tbReadequacao->buscar(
            array(
                'idPronac = ?' => $idPronac,
                'stEstado = ?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO,
                'idTipoReadequacao = ?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL
            )
        );
        
        $where = array();
        $where['idPlanilhaAprovacaoPai = ?'] = $idPlanilhaAprovacaoPai;
        
        if (count($readequacaoAtiva)>0) {
            $idReadequacao = $readequacaoAtiva[0]['idReadequacao'];
            $where['idReadequacao = ?'] = $idReadequacao;
        } else {
            $where['stAtivo = ?'] = 'S';
        }
        
        $planilhaEditaval = $tbPlanilhaAprovacao->buscarDadosAvaliacaoDeItemRemanejamento($where);
        
        $dadosPlanilhaAtiva = array();
        $dadosPlanilhaEditavel = array();
        if (count($planilhaAtiva) > 0) {
            /* PROJETO */
            $Projetos = new Projetos();
            $projeto = $Projetos->buscar(array('IdPRONAC = ?' => $planilhaAtiva[0]->idPRONAC))->current();
            $dadosProjeto = array(
                'IdPRONAC' => $projeto->IdPRONAC,
                'PRONAC' => $projeto->AnoProjeto.$projeto->Sequencial,
                'NomeProjeto' => utf8_encode($projeto->NomeProjeto)
            );

            foreach ($planilhaAtiva as $registro) {
                $vlTotalItem = $registro['Quantidade']*$registro['Ocorrencia']*$registro['ValorUnitario'];
                
                $dadosPlanilhaAtiva['idPlanilhaAprovacao'] = $registro['idPlanilhaAprovacao'];
                $dadosPlanilhaAtiva['idProduto'] = $registro['idProduto'];
                $dadosPlanilhaAtiva['descProduto'] = utf8_encode($registro['descProduto']);
                $dadosPlanilhaAtiva['idEtapa'] = $registro['idEtapa'];
                $dadosPlanilhaAtiva['descEtapa'] = utf8_encode($registro['descEtapa']);
                $dadosPlanilhaAtiva['idPlanilhaItem'] = $registro['idPlanilhaItem'];
                $dadosPlanilhaAtiva['descItem'] = utf8_encode($registro['descItem']);
                $dadosPlanilhaAtiva['idUnidade'] = $registro['idUnidade'];
                $dadosPlanilhaAtiva['descUnidade'] = utf8_encode($registro['descUnidade']);
                $dadosPlanilhaAtiva['Quantidade'] = $registro['Quantidade'];
                $dadosPlanilhaAtiva['Ocorrencia'] = $registro['Ocorrencia'];
                $dadosPlanilhaAtiva['ValorUnitario'] = utf8_encode('R$ '.number_format($registro['ValorUnitario'], 2, ',', '.'));
                $dadosPlanilhaAtiva['QtdeDias'] = $registro['QtdeDias'];
                $dadosPlanilhaAtiva['TotalSolicitado'] = utf8_encode('R$ '.number_format(($vlTotalItem), 2, ',', '.'));
                $dadosPlanilhaAtiva['ValorMinimoProItemValidacao'] = utf8_encode($vlAtualMin);
                $dadosPlanilhaAtiva['ValorMaximoProItemValidacao'] = utf8_encode($vlAtualMax);
                
                $dadosPlanilhaAtiva['Justificativa'] = utf8_encode($registro['Justificativa']);
            }

            if (count($planilhaEditaval) > 0) {
                foreach ($planilhaEditaval as $registroEditavel) {
                    $dadosPlanilhaEditavel['idPlanilhaAprovacao'] = $registroEditavel['idPlanilhaAprovacao'];
                    $dadosPlanilhaEditavel['idProduto'] = $registroEditavel['idProduto'];
                    $dadosPlanilhaEditavel['descProduto'] = utf8_encode($registroEditavel['descProduto']);
                    $dadosPlanilhaEditavel['idEtapa'] = $registroEditavel['idEtapa'];
                    $dadosPlanilhaEditavel['descEtapa'] = utf8_encode($registroEditavel['descEtapa']);
                    $dadosPlanilhaEditavel['idPlanilhaItem'] = $registroEditavel['idPlanilhaItem'];
                    $dadosPlanilhaEditavel['descItem'] = utf8_encode($registroEditavel['descItem']);
                    $dadosPlanilhaEditavel['idUnidade'] = $registroEditavel['idUnidade'];
                    $dadosPlanilhaEditavel['descUnidade'] = utf8_encode($registroEditavel['descUnidade']);
                    $dadosPlanilhaEditavel['Quantidade'] = $registroEditavel['Quantidade'];
                    $dadosPlanilhaEditavel['Ocorrencia'] = $registroEditavel['Ocorrencia'];
                    $dadosPlanilhaEditavel['ValorUnitario'] = utf8_encode('R$ '.number_format($registroEditavel['ValorUnitario'], 2, ',', '.'));
                    $dadosPlanilhaEditavel['QtdeDias'] = $registroEditavel['QtdeDias'];
                    $dadosPlanilhaEditavel['TotalSolicitado'] = utf8_encode('R$ '.number_format(($registroEditavel['Quantidade']*$registroEditavel['Ocorrencia']*$registroEditavel['ValorUnitario']), 2, ',', '.'));
                    $dadosPlanilhaEditavel['Justificativa'] = utf8_encode($registroEditavel['Justificativa']);
                    $dadosPlanilhaEditavel['idAgente'] = $registroEditavel['idAgente'];
                }
            } else {
                $dadosPlanilhaEditavel = $dadosPlanilhaAtiva;
            }

            $tbCompPagxPlanAprov = new tbComprovantePagamentoxPlanilhaAprovacao();
            if (!empty($idPlanilhaAprovacaoPai)) {
                $idPlanilhaAprovacao = $idPlanilhaAprovacaoPai;
            }
            $res = $tbCompPagxPlanAprov->buscarValorComprovadoDoItem($idPlanilhaAprovacao);  // <<--- quando já foi remanejado, deve puxar idPlanilhaAprovacaoPai
            $valoresDoItem = array(
                'vlComprovadoDoItem' => utf8_encode('R$ '.number_format($resComprovado->vlComprovado, 2, ',', '.')),
                'vlComprovadoDoItemValidacao' => utf8_encode(number_format($resComprovado->vlComprovado, 2, '', ''))
            );

            $this->_helper->json(array('resposta'=>true, 'dadosPlanilhaAtiva'=>$dadosPlanilhaAtiva, 'dadosPlanilhaEditavel'=>$dadosPlanilhaEditavel, 'valoresDoItem'=>$valoresDoItem, 'dadosProjeto'=>$dadosProjeto, 'dadosPlanilhaOriginal' => $dadosPlanilhaOriginal));
        } else {
            $this->_helper->json(array('resposta'=>false));
        }
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function salvarAvaliacaoDoItemRemanejamentoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $auth = Zend_Auth::getInstance(); // pega a autentica��o
        $idPlanilhaAprovacao = $this->_request->getParam("idPlanilha");
        $idPlanilhaAprovacaoPai = $this->_request->getParam("idPlanilhaAprovacaoPai");
        
        $tblAgente = new Agente_Model_DbTable_Agentes();
        $rsAgente = $tblAgente->buscar(array('CNPJCPF = ?'=>$auth->getIdentity()->Cpf));
        if ($rsAgente->count() > 0) {
            $idAgente = $rsAgente[0]->idAgente;
        }

        $ValorUnitario = str_replace('.', '', $this->_request->getParam('ValorUnitario'));
        $ValorUnitario = str_replace(',', '.', $ValorUnitario);
        $vlTotal = @number_format(($this->_request->getParam('Quantidade')* $this->_request->getParam('Ocorrencia')*$ValorUnitario), 2, '', '');
        
        $idPronac = $this->_request->getParam("idPronac");
        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }
        
        $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $existeRemanejamento50EmAndamento = $Readequacao_Model_tbReadequacao->existeRemanejamento50EmAndamento($idPronac);
        
        //BUSCA OS DADOS DO ITEM ORIGINAL PARA VALIDA��O DE VALORES
        if (!$existeRemanejamento50EmAndamento && !$idPlanilhaAprovacaoPai) {
            $valoresItem = $tbPlanilhaAprovacao->buscar(
                array(
                    'IdPRONAC=?'=>$idPronac,
                    'stAtivo=?'=>'S',
                    'idPlanilhaAprovacao=?'=> $idPlanilhaAprovacao
                )
            )->current();
        } elseif ($existeRemanejamento50EmAndamento && $idPlanilhaAprovacaoPai) {
            $valoresItem = $tbPlanilhaAprovacao->buscar(
                array(
                    'IdPRONAC=?'=>$idPronac,
                    'stAtivo=?'=>'N',
                    'idPlanilhaAprovacaoPai=?'=> $idPlanilhaAprovacaoPai
                )
            )->current();
        } elseif ($existeRemanejamento50EmAndamento && !$idPlanilhaAprovacaoPai) {
            $valoresItem = $tbPlanilhaAprovacao->buscar(
                array(
                    'IdPRONAC=?'=>$idPronac,
                    'stAtivo=?'=>'S',
                    'idPlanilhaAprovacao=?'=> $idPlanilhaAprovacao
                )
            )->current();
        } elseif (!$existeRemanejamento50EmAndamento && $idPlanilhaAprovacaoPai) {
            $valoresItem = $tbPlanilhaAprovacao->buscar(
                array(
                    'IdPRONAC=?'=>$idPronac,
                    'stAtivo=?'=>'S',
                    'idPlanilhaAprovacaoPai=?'=> $idPlanilhaAprovacaoPai
                )
            )->current();
        }
        
        $vlAtual = @number_format(($valoresItem['qtItem']*$valoresItem['nrOcorrencia']*$valoresItem['vlUnitario']), 2, '', '');
        $vlAtualPerc = $vlAtual* Readequacao_Model_tbReadequacao::PERCENTUAL_REMANEJAMENTO /100;
        
        //VALOR M�NIMO E M�XIMO DO ITEM ORIGINAL
        $vlAtualMin = round($vlAtual-$vlAtualPerc);
        $vlAtualMax = round($vlAtual+$vlAtualPerc);
        
        //VERIFICA SE O VALOR TOTAL DOS DADOS INFORMADOR PELO PROPONENTE EST� ENTRE O M�NIMO E M�XIMO PERMITIDO
        if ($vlTotal < $vlAtualMin || $vlTotal > $vlAtualMax) {
            $mensagem = ($vlTotal < $vlAtualMin) ? "O valor total do item desejado é menor que o mínimo de " . Readequacao_Model_tbReadequacao::PERCENTUAL_REMANEJAMENTO . "% do valor original." : "O valor total do item ultrapassou a margem de ". Readequacao_Model_tbReadequacao::PERCENTUAL_REMANEJAMENTO . ".";
            
            $this->_helper->json(array('resposta'=>false, 'msg'=> $mensagem,
            'qtItem' => $valoresItem['qtItem'],
            'nrOcorrencia' => $valoresItem['nrOcorrencia'],
            'vlUnitario' => $valoresItem['vlUnitario'],
            'vlTotal' => $vlTotal,
            'vlAtual' => $vlAtual,
            'vlAtualMin' => $vlAtualMin,
            'vlAtualMax' => $vlAtualMax
            ));
            $this->_helper->viewRenderer->setNoRender(true);
        }

        // verifica se existe readequacao ativa
        $readequacaoAtiva = $Readequacao_Model_tbReadequacao->buscarDadosReadequacoes(
            array(
                'a.idPronac=?' => $idPronac,
                'a.idTipoReadequacao=?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL,
                'a.stEstado=?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO,
                'a.stAtendimento=?' => 'D',
                'a.siEncaminhamento=?' => 11
            )
        )->toArray();
        
        try {
            if (empty($readequacaoAtiva)) {
                // cria readequacao e copia planilhas
                
                $auth = Zend_Auth::getInstance();
                $tblAgente = new Agente_Model_DbTable_Agentes();
                $rsAgente = $tblAgente->buscar(array('CNPJCPF=?'=>$auth->getIdentity()->Cpf))->current();
                
                $dadosReadequacao = array();
                $dadosReadequacao['idPronac'] = $idPronac;
                $dadosReadequacao['idTipoReadequacao'] = 1;
                $dadosReadequacao['dtSolicitacao'] = new Zend_Db_Expr('GETDATE()');
                $dadosReadequacao['idSolicitante'] = $rsAgente->idAgente;
                $dadosReadequacao['dsJustificativa'] = utf8_decode('Readequação até 50%');
                $dadosReadequacao['stAtendimento'] = 'D';
                $dadosReadequacao['siEncaminhamento'] = 11;
                $dadosReadequacao['stEstado'] = Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO;
                $idReadequacao = $Readequacao_Model_tbReadequacao->inserir($dadosReadequacao);
                
                $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();
                $planilhaAtiva = $tbPlanilhaAprovacao->buscar(
                    array(
                        'IdPRONAC=?'=>$idPronac,
                        'StAtivo=?'=>'S',
                        'tpAcao!=? OR tpAcao IS NULL' => 'E'
                    )
                );
                
                $planilhaRP = array();
                foreach ($planilhaAtiva as $value) {
                    $planilhaRP['tpPlanilha'] = 'RP';
                    $planilhaRP['dtPlanilha'] = new Zend_Db_Expr('GETDATE()');
                    $planilhaRP['idPlanilhaProjeto'] = $value['idPlanilhaProjeto'];
                    $planilhaRP['idPlanilhaProposta'] = $value['idPlanilhaProposta'];
                    $planilhaRP['IdPRONAC'] = $value['IdPRONAC'];
                    $planilhaRP['idProduto'] = $value['idProduto'];
                    $planilhaRP['idEtapa'] = $value['idEtapa'];
                    $planilhaRP['idPlanilhaItem'] = $value['idPlanilhaItem'];
                    $planilhaRP['dsItem'] = $value['dsItem'];
                    $planilhaRP['idUnidade'] = $value['idUnidade'];
                    $planilhaRP['qtItem'] = $value['qtItem'];
                    $planilhaRP['nrOcorrencia'] = $value['nrOcorrencia'];
                    $planilhaRP['vlUnitario'] = $value['vlUnitario'];
                    $planilhaRP['qtDias'] = $value['qtDias'];
                    $planilhaRP['tpDespesa'] = $value['tpDespesa'];
                    $planilhaRP['tpPessoa'] = $value['tpPessoa'];
                    $planilhaRP['nrContraPartida'] = $value['nrContraPartida'];
                    $planilhaRP['nrFonteRecurso'] = $value['nrFonteRecurso'];
                    $planilhaRP['idUFDespesa'] = $value['idUFDespesa'];
                    $planilhaRP['idMunicipioDespesa'] = $value['idMunicipioDespesa'];
                    $planilhaRP['dsJustificativa'] = $value['dsJustificativa'];
                    $planilhaRP['idAgente'] = 0;
                    $planilhaRP['idPlanilhaAprovacaoPai'] = (!empty($value['idPlanilhaAprovacaoPai'])) ? $value['idPlanilhaAprovacaoPai'] : $value['idPlanilhaAprovacao'];
                    $planilhaRP['idReadequacao'] = $idReadequacao;
                    $planilhaRP['tpAcao'] = ($value['tpAcao']) ? $value['tpAcao'] : 'N';
                    $planilhaRP['idRecursoDecisao'] = $value['idRecursoDecisao'];
                    $planilhaRP['stAtivo'] = 'N';
                    $tbPlanilhaAprovacao->inserir($planilhaRP);
                }

                $readequacaoAtiva = $Readequacao_Model_tbReadequacao->buscarDadosReadequacoes(
                    array(
                        'a.idPronac=?' => $idPronac,
                        'a.idTipoReadequacao=?' => Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL,
                        'a.stEstado=?' => Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO,
                        'a.stAtendimento=?' => 'D',
                        'a.siEncaminhamento=?' => 11
                    )
                )->toArray();
            }

            if (empty($idPlanilhaAprovacaoPai)) {
                $resultIdPlanilhaAprovacaoPai = $tbPlanilhaAprovacao->getInfoIdPlanilhaPai($idPlanilhaAprovacao, 'RP');
                if (count($resultIdPlanilhaAprovacaoPai) > 0) {
                    if ($resultIdPlanilhaAprovacaoPai[0]['tpAcao'] == 'I' && $resultIdPlanilhaAprovacaoPai[0]['tpPlanilha'] == 'SR') {
                        $where['idPlanilhaAprovacao = ?'] = $idPlanilhaAprovacaoPai;
                        $where['stAtivo = ?'] = 'N';
                        $where['tpPlanilha = ?'] = 'SR';
                    } else {
                        $idPlanilhaAprovacaoPai = $resultIdPlanilhaAprovacaoPai[0]['idPlanilhaAprovacaoPai'];
                        $where['idPlanilhaAprovacaoPai=?'] = $idPlanilhaAprovacaoPai;
                        $where['stAtivo = ?'] = 'N';
                        $where['tpPlanilha = ?'] = 'RP';
                    }
                } else {
                    $where['idPlanilhaAprovacaoPai=?'] = $idPlanilhaAprovacaoPai;
                    $where['stAtivo = ?'] = 'N';
                    $where['tpPlanilha = ?'] = 'RP';
                }
            } else {
                $where['idPlanilhaAprovacaoPai=?'] = $idPlanilhaAprovacaoPai;
                $where['stAtivo = ?'] = 'N';
                $where['tpPlanilha = ?'] = 'RP';
            }

            $idReadequacao = $readequacaoAtiva[0]['idReadequacao'];
            $where['idReadequacao = ?'] = $idReadequacao;
            $where['IdPRONAC = ?'] = $idPronac;
            
            $editarItem = $tbPlanilhaAprovacao->buscar($where)->current();
            
            $editarItem->qtItem = $_POST['Quantidade'];
            $editarItem->nrOcorrencia = $_POST['Ocorrencia'];
            $editarItem->vlUnitario = $ValorUnitario;
            $editarItem->dsJustificativa = utf8_decode($_POST['Justificativa']);
            $editarItem->idAgente = $idAgente;
            $editarItem->save();
            
            $this->_helper->json(array('resposta'=>true, 'msg'=>'Dados salvos com sucesso!'));
            $this->_helper->viewRenderer->setNoRender(true);
        } catch (Zend_Exception $e) {
            $this->_helper->json(array('resposta'=>$e));
            $this->_helper->viewRenderer->setNoRender(true);
        }
    }

    /**
     * Método criar readequação de planilha orçamentária
     * @access private
     * @param integer $idPronac
     * @return Bool
     */
    private function criarReadequacaoPlanilha($idPronac)
    {
        $auth = Zend_Auth::getInstance();        
        $tblAgente = new Agente_Model_DbTable_Agentes();
        $rsAgente = $tblAgente->buscar(array('CNPJCPF=?'=>$auth->getIdentity()->Cpf))->current();
        
        $Readequacao_Model_tbReadequacao = new Readequacao_Model_tbReadequacao();
        $dados = array();
        $dados['idPronac'] = $idPronac;
        $dados['idTipoReadequacao'] = Readequacao_Model_tbReadequacao::TIPO_READEQUACAO_REMANEJAMENTO_PARCIAL;
        $dados['dtSolicitacao'] = new Zend_Db_Expr('GETDATE()');
        $dados['idSolicitante'] = $rsAgente->idAgente;
        $dados['dsJustificativa'] = utf8_decode('Readequação até 50%');
        $dados['dsSolicitacao'] = '';
        $dados['stAtendimento'] = 'D';
        $dados['idDocumento'] = null;
        $dados['siEncaminhamento'] = Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_NAO_ENVIA_MINC;
        $dados['stEstado'] = Readequacao_Model_tbReadequacao::ST_ESTADO_EM_ANDAMENTO;
        
        try {
            $idReadequacao = $Readequacao_Model_tbReadequacao->inserir($dados);
            
            return $idReadequacao;
            
        } catch (Zend_Exception $e) {
            $this->_helper->json(array('msg' => 'Houve um erro na criação do registro de tbReadequacao'));
            $this->_helper->viewRenderer->setNoRender(true);
        }
    }
    
    /**
     * Função para verificar e copiar planilha
     * 
     * @access public
     * @return Bool   True se foi possível criar a planilha ou se ela existe
     */
    public function verificarPlanilhaAtivaAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        
        $idPronac = $this->_request->getParam('idPronac');
        $idReadequacao = $this->_request->getParam('idReadequacao');
        
        if (!$idReadequacao || $idReadequacao == 0) {
            $idReadequacao = $this->criarReadequacaoPlanilha($idPronac);
            
            $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();
            
            $verificarPlanilhaReadequadaAtual = $tbPlanilhaAprovacao->buscarPlanilhaReadequadaEmEdicao($idPronac, $idReadequacao);
            
            if (count($verificarPlanilhaReadequadaAtual) == 0) {
                $planilhaAtiva = $tbPlanilhaAprovacao->buscarPlanilhaAtiva($idPronac);
                $criarPlanilha = $this->copiarPlanilhas($idPronac, $idReadequacao);
                
                if ($criarPlanilha) {
                    $this->_helper->json(array(
                        'msg' => 'Planilha copiada corretamente',
                        'idReadequacao' => $idReadequacao
                    ));
                } else {
                    $this->_helper->json(array(
                        'msg' => 'Houve um erro ao tentar copiar a planilha',
                        'idReadequacao' => $idReadequacao
                    ));
                }
            }            
        } else {
            $this->_helper->json(array(
                'msg' => 'OK - planilha existe',
                'idReadequacao' => $idReadequacao
            ));            
        }
    }
    
    /**
     * Método que copia planilha associando a um idReadequacao
     * @access private
     * @param integer $idPronac
     * @param integer $idReadequacao
     * @return Bool
     */
    private function copiarPlanilhas($idPronac, $idReadequacao)
    {
        $tbPlanilhaAprovacao = new tbPlanilhaAprovacao();
        $planilha = array();
        
        try {
            $planilhaAtiva = $tbPlanilhaAprovacao->buscarPlanilhaAtivaNaoExcluidos($idPronac);
            
            foreach ($planilhaAtiva as $value) {
                $planilha['tpPlanilha'] = 'SR';
                $planilha['dtPlanilha'] = new Zend_Db_Expr('GETDATE()');
                $planilha['idPlanilhaProjeto'] = $value['idPlanilhaProjeto'];
                $planilha['idPlanilhaProposta'] = $value['idPlanilhaProposta'];
                $planilha['IdPRONAC'] = $value['IdPRONAC'];
                $planilha['idProduto'] = $value['idProduto'];
                $planilha['idEtapa'] = $value['idEtapa'];
                $planilha['idPlanilhaItem'] = $value['idPlanilhaItem'];
                $planilha['dsItem'] = $value['dsItem'];
                $planilha['idUnidade'] = $value['idUnidade'];
                $planilha['qtItem'] = $value['qtItem'];
                $planilha['nrOcorrencia'] = $value['nrOcorrencia'];
                $planilha['vlUnitario'] = $value['vlUnitario'];
                $planilha['qtDias'] = $value['qtDias'];
                $planilha['tpDespesa'] = $value['tpDespesa'];
                $planilha['tpPessoa'] = $value['tpPessoa'];
                $planilha['nrContraPartida'] = $value['nrContraPartida'];
                $planilha['nrFonteRecurso'] = $value['nrFonteRecurso'];
                $planilha['idUFDespesa'] = $value['idUFDespesa'];
                $planilha['idMunicipioDespesa'] = $value['idMunicipioDespesa'];
                $planilha['dsJustificativa'] = null;
                $planilha['idAgente'] = 0;
                $planilha['idPlanilhaAprovacaoPai'] = $value['idPlanilhaAprovacao'];
                $planilha['idReadequacao'] = $idReadequacao;
                $planilha['tpAcao'] = 'N';
                $planilha['idRecursoDecisao'] = $value['idRecursoDecisao'];
                $planilha['stAtivo'] = 'N';
                
                $tbPlanilhaAprovacao->inserir($planilha);
            }
            return true;
        } catch (Zend_Exception $e) {
            $this->_helper->json(array('msg' => 'Houve um erro na c&oacute;pia das planilhas!'));
        }
    }    
}
