<?php

namespace Application\Modules\Readequacao\Service\Assinatura;

use MinC\Servico\IServico;

class Readequacao implements IServico
{
    private $grupoAtivo;
    private $auth;
    private $idTipoDoAto;

    public function __construct(
        $grupoAtivo,
        $auth,
        $idTipoDoAto
    ) {
        $this->grupoAtivo = $grupoAtivo;
        $this->auth = $auth;
        $this->idTipoDoAto = $idTipoDoAto;
    }


    public function obterAssinaturas()
    {
        if (is_null($this->idTipoDoAto)) {
            throw new Exception("Identificador do Ato Administrativo n&atilde;o informado.");
        }
        
        $tbAssinaturaDbTable = new \Assinatura_Model_DbTable_TbAssinatura();
        $tbAssinaturaDbTable->preencherModeloAtoAdministrativo([
            'idOrgaoDoAssinante' => $this->grupoAtivo->codOrgao,
            'idPerfilDoAssinante' => $this->grupoAtivo->codGrupo,
            'idOrgaoSuperiorDoAssinante' => $this->auth->getIdentity()->usu_org_max_superior,
            'idTipoDoAto' => $this->idTipoDoAto
        ]);

        $tbReadequacaoDbTable = new \Readequacao_Model_DbTable_TbReadequacao();
        
        return $tbReadequacaoDbTable->obterAssinaturasReadequacaoDisponiveis($tbAssinaturaDbTable);
    }

    public function obterAtoAdministrativoPorTipoReadequacao($idTipoReadequacao)
    {
        return;
    }
}
