<?php

namespace MinC\Assinatura\Acao;

interface IAcaoAssinar
{
    public function __construct(\MinC\Assinatura\Model\Assinatura $assinatura);

    public function executar();
}