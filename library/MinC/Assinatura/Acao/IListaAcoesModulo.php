<?php

namespace MinC\Assinatura\Acao;

interface IListaAcoesModulo
{
    public function obterLista(\MinC\Assinatura\Model\Assinatura $assinatura): array;
}