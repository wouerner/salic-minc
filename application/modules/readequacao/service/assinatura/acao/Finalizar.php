<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoFinalizar;

class Finalizar implements IAcaoFinalizar
{
    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {

        $idTipoDoAtoAdministrativo = $assinatura->modeloTbDocumentoAssinatura->getIdTipoDoAtoAdministrativo();
        if ((int)$idTipoDoAtoAdministrativo == (int)\Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_READEQUACAO_VINCULADAS) {
            $tbReadequacaoXParecerDbTable = new \Readequacao_Model_DbTable_TbReadequacaoXParecer();
            $tbReadequacaoXParecer = $tbReadequacaoXParecerDbTable->findBy([
                'idParecer' => $assinatura->modeloTbDocumentoAssinatura->getIdAtoDeGestao()
            ]);

            $objReadequacao_ReadequacoesController = new \Readequacao_ReadequacoesController();
            $objReadequacao_ReadequacoesController->encaminharOuFinalizarReadequacaoChecklist(
                $tbReadequacaoXParecer['idReadequacao']
            );
        }
    }
}