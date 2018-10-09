<?php

namespace Application\Modules\Perfil\Service\Perfil;

class Perfil
{
    private $request;
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function alterarPerfil($auth, $grupoAtivo, $tblUsuario)
    {
        $codGrupo = $this->request->getParam('codGrupo'); // grupo do usuário logado
        $codOrgao = $this->request->getParam('codOrgao'); // órgão do usuário logado
        $grupoAtivo->codGrupo = $codGrupo; // armazena o grupo ativo na sessão
        $grupoAtivo->codOrgao = $codOrgao; // armazena o órgão ativo na sessão

        if ($grupoAtivo->codGrupo == "1111" && $grupoAtivo->codOrgao == "2222") {
            $tblSGCacesso = new Autenticacao_Model_Sgcacesso();
            $cpf = $auth->getIdentity()->usu_identificacao;
            $rsSGCacesso = $tblSGCacesso->buscar(array("Cpf = ? " => $cpf))->current()->toArray();
            $auth->getStorage()->write((object)$rsSGCacesso);

            $_SESSION["GrupoAtivo"]["codGrupo"] = $grupoAtivo->codGrupo;
            $_SESSION["GrupoAtivo"]["codOrgao"] = $grupoAtivo->codOrgao;
            parent::message("Seu perfil foi alterado no sistema. Voc&ecirc; ter&aacute; acesso a outras funcionalidades!", "principalproponente", "INFO");
        } else {
//            xd('AAAAAAAAAAAAAAAAAAAA', $codGrupo, $codOrgao);
            //Reescreve a sessao com o novo orgao superior
            $codOrgaoMaxSuperior = $tblUsuario->recuperarOrgaoMaxSuperior($codOrgao);
            $_SESSION['Zend_Auth']['storage']->usu_org_max_superior = $codOrgaoMaxSuperior;

//            // redireciona para a página inicial do sistema
//            parent::message("Seu perfil foi alterado no sistema. Voc&ecirc; ter&aacute; acesso a outras funcionalidades!", "principal", "INFO");
        }
    }
}
