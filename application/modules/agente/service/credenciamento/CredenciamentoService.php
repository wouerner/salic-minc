<?php
/**
 * Created by IntelliJ IDEA.
 * User: leonardo
 * Date: 21/05/19
 * Time: 15:56
 */

public function painelcredenciamentoAction()
{
    $this->autenticacao();
    $agentes = new Agente_Model_DbTable_Agentes();

    $nome = $this->_request->getParam('nome');
    $cpf = Mascara::delMaskCPF($this->_request->getParam('cpf'));

    $buscar = $agentes->consultaPareceristasPainel($nome, $cpf);

    $this->view->dados = $buscar;
    $this->view->qtpareceristas = count($buscar);

    $orgaos = new Orgaos();
    $this->view->orgaos = $orgaos->pesquisarTodosOrgaos();
}
