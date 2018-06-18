<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IListaAcoesModulo;

class ListaAcoesModulo implements IListaAcoesModulo
{

    public function obterLista(\MinC\Assinatura\Model\Assinatura $assinatura): array
    {
        return [
            new Assinar($assinatura),
            new Encaminhar($assinatura),
            new Devolver($assinatura),
            new Finalizar($assinatura)
        ];
    }
}