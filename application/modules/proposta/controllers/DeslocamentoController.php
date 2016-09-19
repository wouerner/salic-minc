<?php

/**
 * Proposta_DeslocamentoController
 *
 * @uses MinC_Controller_Action_Abstract
 * @author  wouerner <wouerner@gmail.com>
 */
class Proposta_DeslocamentoController extends MinC_Controller_Action_Abstract {

    private $idPreProjeto = null;

    /**
     * Reescreve o m�todo init()
     * @access public
     * @param void
     * @return void
     */
    public function init()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $arrAuth = array_change_key_case((array) $auth);
        $PermissoesGrupo = array();

        //Da permissao de acesso a todos os grupos do usuario logado afim de atender o UC75
        if(isset($arrAuth['usu_codigo'])){
            //Recupera todos os grupos do Usuario
            $Usuario = new Autenticacao_Model_Usuario(); // objeto usu�rio
            $grupos = $Usuario->buscarUnidades($arrAuth['usu_codigo'], 21);
            foreach ($grupos as $grupo){
                $PermissoesGrupo[] = $grupo->gru_codigo;
            }
        }

        isset($arrAuth['usu_codigo']) ? parent::perfil(1, $PermissoesGrupo) : parent::perfil(4, $PermissoesGrupo);

        // pega o idAgente do usuario logado
        $auxUsuario = isset($arrAuth['usu_codigo']) ? $arrAuth['usu_codigo'] : $arrAuth['idusuario'];
        $this->getIdUsuario = UsuarioDAO::getIdUsuario($auxUsuario);

        if ($this->getIdUsuario) {
            $this->getIdUsuario = $this->getIdUsuario["idAgente"];
        }
        else {
            $this->getIdUsuario = 0;
        }

        $mapperUf = new Agente_Model_UFMapper();
        $uf = $mapperUf->fetchPairs('iduf', 'sigla');
        $this->view->comboestados = $uf;
        //$this->view->comboestados = Estado::buscar();
        $table = new Agente_Model_DbTable_Pais();
        $this->view->paises = $table->fetchPairs('idpais', 'descricao');
        //$this->view->paises = DeslocamentoDAO::buscarPais();

        parent::init();
        //recupera ID do pre projeto (proposta)
        if(!empty ($_REQUEST['idPreProjeto'])) {
            $this->idPreProjeto = $_REQUEST['idPreProjeto'];
            //VERIFICA SE A PROPOSTA ESTA COM O MINC
            $Movimentacao = new Movimentacao();
            $rsStatusAtual = $Movimentacao->buscarStatusAtualProposta($_REQUEST['idPreProjeto']);
            $this->view->movimentacaoAtual = $rsStatusAtual->Movimentacao;
        }else {
            if($_REQUEST['idPreProjeto'] != '0'){
                parent::message("Necess�rio informar o n�mero da proposta.", "/proposta/manterpropostaincentivofiscal/index", "ERROR");
            }
        }
    }

    /**
     * indexAction
     *
     * @access public
     * @return void
     * @todo Refatorar metodo para user metodos padr�es do Zend
     */
    public function indexAction()
    {
        if (empty($_GET['verifica'])) {
            $this->_helper->layout->disableLayout();
        }
        if($_GET) {
            $id = null;

            if(!empty($_GET['id'])) {
                $id = $_GET['id'];
            }

            $idPreProjeto = $this->idPreProjeto;

            $deslocamentos = new DeslocamentoDAO();
            $dados = $deslocamentos->buscarDeslocamento($idPreProjeto, $id);

            if($id && !empty($dados)) {
                foreach($dados as $d) {
                    $idPaisO 		= $d->idPaisOrigem;
                    $idUFO		= $d->idUFOrigem;
                    $idCidadeO 		= $d->idMunicipioOrigem;
                    $idPaisD		= $d->idPaisDestino;
                    $idUFD		= $d->idUFDestino;
                    $idCidadeD 		= $d->idMunicipioDestino;
                    $Qtde  		= $d->Qtde;
                }

                $cidade = new Municipios();
                $this->view->combocidadesO = $cidade->buscar($idUFO);
                //$this->view->combocidadesO = Cidade::buscar($idUFO);
                $this->view->combocidadesD = Cidade::buscar($idUFD);

                $this->view->idPaisO 	= $idPaisO;
                $this->view->idPaisD 	= $idPaisD;
                $this->view->idUFO 	= $idUFO;
                $this->view->idUFD 	= $idUFD;
                $this->view->idCidadeO 	= $idCidadeO;
                $this->view->idCidadeD 	= $idCidadeD;
                $this->view->Qtde 	= $Qtde;
                $this->view->idDeslocamento = $id;
            }

            $this->view->idPreProjeto	= $idPreProjeto;
            $this->view->deslocamentos = $deslocamentos->buscarDeslocamento($idPreProjeto, null);
        }
    }

    public function salvarAction() {

        $post = Zend_Registry::get('post');

        $idPreProjeto	= $post->idPreProjeto;
        $idDeslocamento = $post->idDeslocamento;
        $paisOrigem 	= $post->paisOrigem;
        $paisDestino 	= $post->paisDestino;
        $uf 		= $post->uf;
        $ufD 		= $post->ufD;
        $cidade	 	= $post->cidade;
        $cidadeD 	= $post->cidadeD;
        $quantidade 	= $post->quantidade;

        if(!$uf) {
            $uf = 0;
        }
        if(!$ufD) {
            $ufD = 0;
        }
        if(!$cidade) {
            $cidade = 0;
        }
        if(!$cidadeD) {
            $cidadeD = 0;
        }

        $dados = array(
                'idprojeto' 		=> $idPreProjeto,
                'idpaisorigem' 		=> $paisOrigem,
                'iduforigem' 		=> $uf,
                'idmunicipioorigem' 	=> $cidade,
                'idpaisdestino' 	=> $paisDestino,
                'idufdestino' 		=> $ufD,
                'idmunicipiodestino'    => $cidadeD,
                'qtde' 			=> $quantidade,
                'idusuario' 		=> $this->getIdUsuario
        );

            $deslocamentos = DeslocamentoDAO::buscarDeslocamentosGeral(array("de.idPaisOrigem = "=>$dados["idPaisOrigem"],"de.idPaisDestino = "=>$dados["idPaisDestino"],
            "de.idMunicipioOrigem = "=>$dados["idMunicipioOrigem"],"de.idMunicipioDestino = "=>$dados["idMunicipioDestino"], "de.idProjeto = "=>$idPreProjeto, "de.Qtde = "=>$dados["Qtde"]));

            if(!empty($deslocamentos)){
                parent::message("Trecho j&aacute; cadastrado, transa&ccedil;&atilde;o cancelada!", "/proposta/localderealizacao/index?idPreProjeto=".$this->idPreProjeto.$edital, "ALERT");
                die;
            }

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();

        try {
            if($idDeslocamento == '') {
                $salvar   = DeslocamentoDAO::salvaDeslocamento($dados);
                $db->commit();
                parent::message("Cadastro realizado com sucesso!", "/proposta/localderealizacao/index?idPreProjeto=".$this->idPreProjeto.$edital, "CONFIRM");
            }
            else {
                $atualizaaliza = DeslocamentoDAO::atualizaDeslocamento($paisOrigem,$uf,$cidade,$paisDestino,$ufD,$cidadeD,$quantidade,$idDeslocamento);
                $db->commit();
                parent::message("Altera&ccedil;&atilde;o realizada com sucesso!", "/proposta/localderealizacao/index?idPreProjeto=".$this->idPreProjeto.$edital, "CONFIRM");
            }

        }catch(Zend_Exception $ex) {
            $db->rollback();
            echo $ex->getMessage();
        }
        parent::message("N&atilde;o foi poss&iacute;vel realizar a opera&ccedil;&atilde;o! <br>", "/proposta/localderealizacao/index?idPreProjeto=".$this->idPreProjeto.$edital, "ERROR");
    }

    public function excluirAction() {
        if($_GET['id']) {
            try {
                $excluir = DeslocamentoDAO::excluiDeslocamento($_GET['id']);

                parent::message("Exclus�o realizada com sucesso!", "/localderealizacao/index?idPreProjeto=".$this->idPreProjeto.$edital, "CONFIRM");

            }catch(Zend_Exception $ex) {
                $this->view->message      = $e->getMessage();
                $this->vies->message_type = "ERROR";
            }
        }
        $this->_redirect("localderealizacao\index");
    }

    public function alterarAction() {
        $id = isset($_GET['id']);
        $idPreProjeto = $this->idPreProjeto;
        $this->_redirect("localderealizacao\index?idPreProjeto=".$idPreProjeto."&id=".$id);
    }

    public function consultarcomponenteAction() {
        $this->_helper->layout->disableLayout(); // desabilita o layout
        if(!empty($this->idPreProjeto)) {
            $this->view->deslocamentos = DeslocamentoDAO::buscarDeslocamentos($this->idPreProjeto, null);
        } else {
            die;
        }
    }



}
