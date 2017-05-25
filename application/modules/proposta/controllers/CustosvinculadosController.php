<?php

class Proposta_CustosvinculadosController extends Proposta_GenericController
{


    /**
     * Reescreve o metodo init()
     * @access public
     * @param void
     * @return void
     */
    public function init()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $arrAuth = array_change_key_case((array)$auth);
        $PermissoesGrupo = array();

        //Da permissao de acesso a todos os grupos do usuario logado afim de atender o UC75
        if (isset($arrAuth['usu_codigo'])) {
            //Recupera todos os grupos do Usuario
            $Usuario = new Autenticacao_Model_Usuario(); // objeto usuario
            $grupos = $Usuario->buscarUnidades($arrAuth['usu_codigo'], 21);
            foreach ($grupos as $grupo) {
                $PermissoesGrupo[] = $grupo->gru_codigo;
            }
        }

        isset($arrAuth['usu_codigo']) ? parent::perfil(1, $PermissoesGrupo) : parent::perfil(4, $PermissoesGrupo);

        // pega o idAgente do usuario logado
        $auxUsuario = isset($arrAuth['usu_codigo']) ? $arrAuth['usu_codigo'] : $arrAuth['idusuario'];
        $this->getIdUsuario = UsuarioDAO::getIdUsuario($auxUsuario);

        if ($this->getIdUsuario) {
            $this->getIdUsuario = $this->getIdUsuario["idAgente"];
        } else {
            $this->getIdUsuario = 0;
        }

        $mapperUf = new Agente_Model_UFMapper();
        $uf = $mapperUf->fetchPairs('idUF', 'Sigla');
        $this->view->comboestados = $uf;
        //$this->view->comboestados = Estado::buscar();
        $table = new Agente_Model_DbTable_Pais();
        $this->view->paises = $table->fetchPairs('idPais', 'Descricao');
        //$this->view->paises = DeslocamentoDAO::buscarPais();

        parent::init();
        //recupera ID do pre projeto (proposta)
        $idPreProjeto = $this->getRequest()->getParam('idPreProjeto');

        if (!empty ($idPreProjeto)) {
            $this->idPreProjeto = $idPreProjeto;
            $this->view->idPreProjeto = $idPreProjeto;
            //VERIFICA SE A PROPOSTA ESTA COM O MINC
            $Movimentacao = new Proposta_Model_DbTable_TbMovimentacao();
            $rsStatusAtual = $Movimentacao->buscarStatusAtualProposta($_REQUEST['idPreProjeto']);
            $this->view->movimentacaoAtual = $rsStatusAtual['movimentacao'];
        } else {
            if ($_REQUEST['idPreProjeto'] != '0') {
                parent::message("Necess&aacute;rio informar o n&uacute;mero da proposta.", "/proposta/manterpropostaincentivofiscal/index", "ERROR");
            }
        }
    }

    /**
     * indexAction
     *
     * @access public
     * @return void
     *
     * @since 21/09/2016
     *
     */
    public function indexAction()
    {

    }




}
