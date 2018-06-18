<?php

namespace Application\Modules\Assinatura\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IListaAcoes;
use Assinatura_Model_DbTable_TbAssinatura as TbAssinaturaDbTable,
    Application\Modules\Readequacao\Service\Assinatura\Acao\ListaAcoesModulo as ListaAcoesReadequacao;

class ListaAcoes implements IListaAcoes
{

    public function __invoke(): array
    {
        return [
            TbAssinaturaDbTable::TIPO_ATO_PARECER_TECNICO_READEQUACAO_DE_PROJETO => new ListaAcoesReadequacao()
        ];
    }
}