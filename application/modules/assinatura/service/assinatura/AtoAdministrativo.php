<?php

namespace Application\Modules\Assinatura\Service\Assinatura;

use MinC\Assinatura\Servico\IServico;

class AtoAdministrativo implements IServico
{
    public function obterAtoAdministrativoAtual(
        $idTipoDoAto,
        $idOrgaoSuperiorDoAssinante,
        $idOrgaoDoAssinante,
        $idPerfilDoAssinante
    ) {

        $tbAtoAdministrativoDbTable = new \Assinatura_Model_DbTable_TbAtoAdministrativo();
        $atoAdministrativo = $tbAtoAdministrativoDbTable->obterPrimeiroAtoAdministrativo(
            $idTipoDoAto,
            $idOrgaoSuperiorDoAssinante,
            $idPerfilDoAssinante,
            $idOrgaoDoAssinante
        );
        xd_($atoAdministrativo);
        return $atoAdministrativo;
    }
}
