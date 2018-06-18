<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IListaAcoesModulo;

class ListaAcoesModulo implements IListaAcoesModulo
{

    public function __invoke(\MinC\Assinatura\Model\Assinatura $assinatura): array
    {
        return [
            'encaminhar' => new Encaminhar($assinatura),
            'devolver' => new Devolver($assinatura),
            'finalizar' => new Finalizar($assinatura)
        ];
    }
}