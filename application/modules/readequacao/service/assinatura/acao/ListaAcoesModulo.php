<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IListaAcoesModulo;

class ListaAcoesModulo implements IListaAcoesModulo
{

    public function __invoke(): array
    {
        return [
            'encaminhar' => Encaminhar::class,
            'devolver' => Devolver::class,
            'finalizar' => Finalizar::class,
        ];
    }
}