<?php

namespace MinC\Assinatura\Acao;

interface IListaAcoesModulo
{
    public function obterListaAcoesModulo(\MinC\Assinatura\Model\Assinatura $assinatura): array;
}