<?php

class VerificarAlteracaoProjetoController extends MinC_Controller_Action_Abstract
{

    public function init()
    {
        $this->view->title = "Salic - Sistema de Apoio &agrave;s Leis de Incentivo &agrave; Cultura"; // t�tulo da p�gina
        $auth = Zend_Auth::getInstance();
        $Usuario = new UsuarioDAO();
        $GrupoAtivo = new Zend_Session_Namespace('GrupoAtivo'); // cria a sess�o com o grupo ativo

        if ($auth->hasIdentity()) {
            $PermissoesGrupo = array();
            $PermissoesGrupo[] = 93;
            $PermissoesGrupo[] = 103;
            if (!in_array($GrupoAtivo->codGrupo, $PermissoesGrupo)) {
                parent::message("Voc&ecirc; n&atilde;o tem permiss&atilde;o para acessar essa &aacute;rea do sistema!", "principal/index", "ALERT");
            }

            $grupos = $Usuario->buscarUnidades($auth->getIdentity()->usu_codigo, 21);

            $this->view->usuario = $auth->getIdentity();
            $this->view->arrayGrupos = $grupos;
            $this->view->grupoAtivo = $GrupoAtivo->codGrupo;
            $this->view->orgaoAtivo = $GrupoAtivo->codOrgao;
        } else {
            return $this->_helper->redirector->goToRoute(array('controller' => 'index', 'action' => 'logout'), null, true);
        }

        parent::init();
    }

    public function paineltecnicoAction()
    {
        $resultadobusca = VerificarAlteracaoProjetoDAO::buscarProjetos();
        $Result['NomeProponente'] = array();
        $Result['RazaoSocial'] = array();
        $Result['FichaTecnica'] = array();
        $Result['LocalRealizacao'] = array();
        $Result['NomeProjeto'] = array();
        $Result['ProrrogacaoPrazoCaptacao'] = array();
        $Result['ProrrogacaoPrazoExecucao'] = array();

        foreach ($resultadobusca as $ResultAltBusca) {
            switch ($ResultAltBusca->tpAlteracaoProjeto) {
                case 1: {
                    $Result['NomeProponente'][] = $ResultAltBusca;
                    break;
                }
                case 2: {
                    $Result['RazaoSocial'][] = $ResultAltBusca;
                    break;
                }
                case 3: {
                    $Result['FichaTecnica'][] = $ResultAltBusca;
                    break;
                }
                case 4: {
                    $Result['LocalRealizacao'][] = $ResultAltBusca;
                    break;
                }
                case 5: {
                    $Result['NomeProjeto'][] = $ResultAltBusca;
                    break;
                }
                case 9: {
                    $Result['ProrrogacaoPrazoCaptacao'][] = $ResultAltBusca;
                    break;
                }
                case 10: {
                    $Result['ProrrogacaoPrazoExecucao'][] = $ResultAltBusca;
                    break;
                }
                default:
                    break;
            }
        }
        $Total['NomeProponente'] = count($Result['NomeProponente']);
        $Total['RazaoSocial'] = count($Result['RazaoSocial']);
        $Total['FichaTecnica'] = count($Result['FichaTecnica']);
        $Total['LocalRealizacao'] = count($Result['LocalRealizacao']);
        $Total['NomeProjeto'] = count($Result['NomeProjeto']);
        $Total['ProrrogacaoPrazoCaptacao'] = count($Result['ProrrogacaoPrazoCaptacao']);
        $Total['ProrrogacaoPrazoExecucao'] = count($Result['ProrrogacaoPrazoExecucao']);
        $this->view->resultBusca = $Result;
        $this->view->resultTotal = $Total;
    }


    public function nomeprojetoAction()
    {
        if ($_POST) {
            $recebidoPost = Zend_Registry::get('post');
            if ($recebidoPost->stAprovacao == 'RT') {
                $this->RetornoTecnico($_POST);
            } else {
                if ($recebidoPost->stAprovacao == 'D') {
                    $recDadosParaAlteracao = tbalteracaonomeprojetoDAO::buscarDadosNmProj($_POST['idpedidoalteracao']);
                    $dadosalterar = array("nomeProjeto" => $recDadosParaAlteracao[0]->nmprojeto);
                    tbalteracaonomeprojetoDAO::alterarNomeProjeto($dadosalterar, $recDadosParaAlteracao[0]->idPRONAC);
                }
                $this->InserirStatusAvaliacaoProjeto($_POST);
            }
        }
        $recebidoGet = Zend_Registry::get('get');
        $idpedidoalteracao = $recebidoGet->idpedidoalteracao;
        $resultadoBuscaPedidoAlteracao = VerificarAlteracaoProjetoDAO::BuscarDadosGenericos($idpedidoalteracao);
        $resultadoDadosAlteracaoNomeProjeto = PedidoAlteracaoDAO::buscarAlteracaoNomeProjeto($idpedidoalteracao);
        $arquivos = VerificarAlteracaoProjetoDAO::buscarArquivosSolicitacao($idpedidoalteracao);
        $this->view->resultArquivo = $arquivos;
        $this->view->resultAlteracaoNomeProjeto = $resultadoDadosAlteracaoNomeProjeto;
        $this->view->resultConsulta = $resultadoBuscaPedidoAlteracao;
    }

    public function solaltrazsocAction()
    {
        if ($_POST) {
            $recebidoPost = Zend_Registry::get('post');
            if ($recebidoPost->stAprovacao == 'RT') {
                $this->RetornoTecnico($_POST);
            } else {
                if ($recebidoPost->stAprovacao == 'D') {
                    $recDadosParaAlteracao = tbalteracaoaltrazDAO::buscarDadosAltRaz($_POST['idpedidoalteracao']);
                    $dadosalterar = array("descricao" => $recDadosParaAlteracao[0]->nmrazaosocial);
                    tbalteracaoaltrazDAO::alterarRazaoSocialProjeto($dadosalterar, $recDadosParaAlteracao[0]->idAgente);
                }
                $this->InserirStatusAvaliacaoProjeto($_POST);
            }
        }
        $recebidoGet = Zend_Registry::get('get');
        $idpedidoalteracao = $recebidoGet->idpedidoalteracao;
        $resultadoBuscaPedidoAlteracao = tbPedidoAlteracaoProjetoDAO::buscarDadosPedidoAlteracao($idpedidoalteracao);

        $this->view->resultConsulta = $resultadoBuscaPedidoAlteracao;
        $this->view->resultArquivo = tbpedidoaltprojetoxarquivoDAO::buscarArquivos($idpedidoalteracao);
        $this->view->resultParecerTecnico = tbalteracaonomeprojetoDAO::buscarDadosParecerTecnico($idpedidoalteracao);
    }

    public function solaltnomprpAction()
    {
        if ($_POST) {
            $recebidoPost = Zend_Registry::get('post');
            if ($recebidoPost->stAprovacao == 'RT') {
                $this->RetornoTecnico($_POST);
            } else {
                if ($recebidoPost->stAprovacao == 'D') {
                    $recDadosParaAlteracao = tbalteracaonomeproponenteDAO::buscarDadosAltNomProp($_POST['idpedidoalteracao']);
                    $dadosalterar = array("cgccpf" => $recDadosParaAlteracao[0]->nrCNPJCPF);
                    tbalteracaonomeproponenteDAO::alterarNomeProponente($dadosalterar, $recDadosParaAlteracao[0]->idPRONAC);
                }
                $this->InserirStatusAvaliacaoProjeto($_POST);
            }
        }
        $recebidoGet = Zend_Registry::get('get');
        $idpedidoalteracao = $recebidoGet->idpedidoalteracao;
        $resultadoBuscaPedidoAlteracao = tbPedidoAlteracaoProjetoDAO::buscarDadosPedidoAlteracao($idpedidoalteracao);
        $this->view->resultConsulta = $resultadoBuscaPedidoAlteracao;
        $this->view->resultArquivo = tbpedidoaltprojetoxarquivoDAO::buscarArquivos($idpedidoalteracao);
        $this->view->resultProjeto = tbalteracaonomeproponenteDAO::buscarProjPorProp($resultadoBuscaPedidoAlteracao[0]->CgcCpf);
        $this->view->resultParecerTecnico = tbalteracaonomeprojetoDAO::buscarDadosParecerTecnico($idpedidoalteracao);
    }

    public function solaltlocrelAction()
    {
        if ($_POST) {
            $recebidoPost = Zend_Registry::get('post');
            if ($recebidoPost->stAprovacao == 'RT') {
                $this->RetornoTecnico($_POST);
            } else {
                if ($recebidoPost->stAprovacao == 'D') {
                    $recDadosParaAlteracaoAltLocalRel = tbalteracaolocalrealizacaoDAO::buscarDadosAltLocRel($_POST['idpedidoalteracao']);
                    foreach ($recDadosParaAlteracaoAltLocalRel as $dados) {
                    }
                } else {
                    $this->InserirStatusAvaliacaoProjeto($_POST);
                }
            }
        }
        $recebidoGet = Zend_Registry::get('get');
        $idpedidoalteracao = $recebidoGet->idpedidoalteracao;
        $resultadoBuscaPedidoAlteracao = tbPedidoAlteracaoProjetoDAO::buscarDadosPedidoAlteracao($idpedidoalteracao);
        $this->view->resultAbrangencia = tbAbrangenciaDAO::buscarDadosAbrangencia($resultadoBuscaPedidoAlteracao[0]->idprojeto);
        $this->view->resultConsulta = $resultadoBuscaPedidoAlteracao;
        $this->view->resultLocalRel = tbalteracaolocalrealizacaoDAO::buscarDadosAltLocRel($idpedidoalteracao);
        $this->view->resultArquivo = tbpedidoaltprojetoxarquivoDAO::buscarArquivos($idpedidoalteracao);
        $this->view->resultParecerTecnico = tbalteracaonomeprojetoDAO::buscarDadosParecerTecnico($idpedidoalteracao);
    }

    public function solaltfictecAction()
    {
        if ($_POST) {
            $recebidoPost = Zend_Registry::get('post');
            if ($recebidoPost->stAprovacao == 'RT') {
                $this->RetornoTecnico($_POST);
            } else {
                $this->InserirStatusAvaliacaoProjeto($_POST);
            }
        }
        $recebidoGet = Zend_Registry::get('get');
        $idpedidoalteracao = $recebidoGet->idpedidoalteracao;
        $resultadoBuscaPedidoAlteracao = tbPedidoAlteracaoProjetoDAO::buscarDadosPedidoAlteracao($idpedidoalteracao);
        $this->view->resultConsulta = $resultadoBuscaPedidoAlteracao;
        $this->view->resultArquivo = tbpedidoaltprojetoxarquivoDAO::buscarArquivos($idpedidoalteracao);
        $this->view->resultParecerTecnico = tbalteracaonomeprojetoDAO::buscarDadosParecerTecnico($idpedidoalteracao);
    }

    public function solaltprogprazcapAction()
    {
        if ($_POST) {
            $recebidoPost = Zend_Registry::get('post');
            if ($recebidoPost->stAprovacao == 'RT') {
                $this->RetornoTecnico($_POST);
            } else {
                if ($recebidoPost->stAprovacao == 'D') {
                    $recDadosParaAlteracao = tbprorrogacaoprazoDao::buscarDadosProrrogacaoPrazo($_POST['idpedidoalteracao']);
                    $datainicioprazo = Data::tratarDataZend($recDadosParaAlteracao[0]->dtinicioprazo, 'americano');
                    $datafimprazo = Data::tratarDataZend($recDadosParaAlteracao[0]->dtfimprazo, 'americano');
                    $dadosalterar = array("dtiniciocaptacao" => $datainicioprazo, "dtfimcaptacao" => $datafimprazo);
                    $result = tbprorrogacaoprazoDao::alterarProrrogracaoPrazoCap($dadosalterar, $recDadosParaAlteracao[0]->idPRONAC);
                    if ($result) {
                        $this->InserirStatusAvaliacaoProjeto($_POST);
                    };
                } else {
                    $this->InserirStatusAvaliacaoProjeto($_POST);
                }
            }
        }
        $recebidoGet = Zend_Registry::get('get');
        $idpedidoalteracao = $recebidoGet->idpedidoalteracao;
        $resultadoBuscaPedidoAlteracao = tbPedidoAlteracaoProjetoDAO::buscarDadosPedidoAlteracao($idpedidoalteracao);
        $this->view->resultConsulta = $resultadoBuscaPedidoAlteracao;
        $this->view->resultDadosBanc = tbcontabancariaDao::buscarDadosContaBancaria($resultadoBuscaPedidoAlteracao[0]->idPRONAC);
        $this->view->resultArquivo = tbpedidoaltprojetoxarquivoDAO::buscarArquivos($idpedidoalteracao);
        $this->view->resultParecerTecnico = tbalteracaonomeprojetoDAO::buscarDadosParecerTecnico($idpedidoalteracao);
    }

    public function solaltprogprazexecAction()
    {
        if ($_POST) {
            $recebidoPost = Zend_Registry::get('post');
            if ($recebidoPost->stAprovacao == 'RT') {
                $this->RetornoTecnico($_POST);
            } else {
                if ($recebidoPost->stAprovacao == 'D') {
                    $recDadosParaAlteracao = tbprorrogacaoprazoDao::buscarDadosProrrogacaoPrazo($_POST['idpedidoalteracao']);
                    $datainicioprazo = Data::tratarDataZend($recDadosParaAlteracao[0]->dtinicioprazo, 'americano');
                    $datafimprazo = Data::tratarDataZend($recDadosParaAlteracao[0]->dtfimprazo, 'americano');
                    $dadosalterar = array("dtinicioexecucao" => $datainicioprazo, "dtfimexecucao" => $datafimprazo);
                    tbprorrogacaoprazoDao::alterarProrrogracaoPrazoExec($dadosalterar, $recDadosParaAlteracao[0]->idPRONAC);
                    if ($result) {
                        $this->InserirStatusAvaliacaoProjeto($_POST);
                    };
                } else {
                    $this->InserirStatusAvaliacaoProjeto($_POST);
                }
            }
        }
        $recebidoGet = Zend_Registry::get('get');
        $idpedidoalteracao = $recebidoGet->idpedidoalteracao;
        $resultadoBuscaPedidoAlteracao = tbPedidoAlteracaoProjetoDAO::buscarDadosPedidoAlteracao($idpedidoalteracao);
        $this->view->resultConsulta = $resultadoBuscaPedidoAlteracao;
        $this->view->resultArquivo = tbpedidoaltprojetoxarquivoDAO::buscarArquivos($idpedidoalteracao);
        $this->view->resultDadosBanc = tbcontabancariaDao::buscarDadosContaBancaria($resultadoBuscaPedidoAlteracao[0]->idPRONAC);
        $this->view->resultParecerTecnico = tbalteracaonomeprojetoDAO::buscarDadosParecerTecnico($idpedidoalteracao);
    }

    public function InserirStatusAvaliacaoProjeto($post)
    {
        $idpedidoalteracao = $post['idpedidoalteracao'];
        $dsJustificativaAvaliacao = $post['dsJustificativaAvaliacao'];
        $stDeferimentoAvaliacao = $post['stAprovacao'];

        $parecerCoordenador = array(
            "dtAvaliacao" => date('Y-m-d H:i:s'),
            "idAvaliador" => 3998,
            "dsJustificativaAvaliacao" => $dsJustificativaAvaliacao,
            "stDeferimentoAvaliacao" => $stDeferimentoAvaliacao);

        $query = tbPedidoAlteracaoProjetoCoordDAO::updateDadosProjeto($parecerCoordenador, $idpedidoalteracao);
        if ($query) {
            $this->redirect('verificaralteracaocoordenador/');
            $this->_helper->viewRenderer->setNoRender(true);
        }
    }

    public function RetornoTecnico($post)
    {
        $idpedidoalteracao = $post['idpedidoalteracao'];
        $dtparecertecnico = $post['dtparecertecnico'];
        $dsJustificativaAvaliacao = TratarString::escapeString($post['dsJustificativaAvaliacao']);
        $dtparecertecnico = date('Y-m-d H:i:00', strtotime($post['dtparecertecnico']));
        $parecerCoordenador = array(
            "dtretornocoordenador" => date('Y-m-d H:i:s'),
            "idcoordenador" => 3998,
            "dsretornocoordenador" => $dsJustificativaAvaliacao);

        $query = tbPedidoAlteracaoProjetoCoordDAO::UpdateAvaliacaoProjeto($parecerCoordenador, $idpedidoalteracao, $dtparecertecnico);

        if ($query) {
            $this->redirect('verificaralteracaocoordenador/');
            $this->_helper->viewRenderer->setNoRender(true);
        }
    }

    public static function VerificarCpfCnpj($dado)
    {
        $qtdcarecteres = strlen($dado);
        switch ($qtdcarecteres) {
            case 11:
                $retorno = Mascara::addMaskCPF($dado);
                break;
            case 14:
                $retorno = Mascara::addMaskCNPJ($dado);
                break;
        }
        return $retorno;
    }

    public static function BuscarDadosTabelasAlt($idpedidoalteracao, $tpalteracao)
    {
        switch ($tpalteracao) {
            case 1: {
                $nomProp = tbalteracaonomeproponenteDAO::buscarDadosAltNomProp($idpedidoalteracao);
                return $nomProp[0];
            }
            case 2: {
                $altRazSoc = tbalteracaoaltrazDAO::buscarDadosAltRaz($idpedidoalteracao);
                return $altRazSoc[0];
            }
            case 3: {
                $altFicTec = tbalteracaofictecDAO::buscarDadosFicTec($idpedidoalteracao);
                return $altFicTec[0];
            }
            case 4: {
                $altLolRel = tbalteracaolocalrealizacaoDAO::buscarDadosAltLocRel($idpedidoalteracao);
                return $altLolRel[0];
            }
            case 5: {
                $altNomProj = tbalteracaonomeprojetoDAO::buscarDadosNmProj($idpedidoalteracao);
                return $altNomProj[0];
            }
        }
    }
}
