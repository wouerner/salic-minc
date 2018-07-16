<?php

namespace Application\Modules\Projeto\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoFinalizar;

class Finalizar implements IAcaoFinalizar
{
    /**
     * @var \MinC\Assinatura\Model\Assinatura $assinatura
     */
    private $assinatura;

    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $this->assinatura = $assinatura;

        $tbProjetoXParecerDbTable = new \Projeto_Model_DbTable_TbProjetoXParecer();
        $tbProjetoXParecer = $tbProjetoXParecerDbTable->findBy([
            'idParecer' => $assinatura->modeloTbDocumentoAssinatura->getIdAtoDeGestao()
        ]);

        $objProjeto_ReadequacoesController = new \Projeto_ReadequacoesController();
        $objProjeto_ReadequacoesController->encaminharOuFinalizarProjetoChecklist(
            $tbProjetoXParecer['idProjeto']
        );
    }
}