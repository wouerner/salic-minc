<?php

namespace MinC\Assinatura\Acao;

interface IListaAcoesModulo
{
    public function __invoke(\MinC\Assinatura\Model\Assinatura $assinatura): array;
}