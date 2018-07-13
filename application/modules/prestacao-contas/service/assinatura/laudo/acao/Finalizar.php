<?php

namespace Application\Modules\PrestacaoContas\Service\Assinatura\Laudo\Acao;

use MinC\Assinatura\Acao\IAcaoFinalizar;

class Finalizar implements IAcaoFinalizar
{
    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {

        $idTipoDoAtoAdministrativo = $assinatura->modeloTbDocumentoAssinatura->getIdTipoDoAtoAdministrativo();
        if ((int)$idTipoDoAtoAdministrativo == (int)\Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_PrestacaoContas_VINCULADAS) {
            $tbPrestacaoContasXParecerDbTable = new \PrestacaoContas_Model_DbTable_TbPrestacaoContasXParecer();
            $tbPrestacaoContasXParecer = $tbPrestacaoContasXParecerDbTable->findBy([
                'idParecer' => $assinatura->modeloTbDocumentoAssinatura->getIdAtoDeGestao()
            ]);

            $objPrestacaoContas_ReadequacoesController = new \PrestacaoContas_ReadequacoesController();
            $objPrestacaoContas_ReadequacoesController->encaminharOuFinalizarPrestacaoContasChecklist(
                $tbPrestacaoContasXParecer['idPrestacaoContas']
            );
        }
    }
}