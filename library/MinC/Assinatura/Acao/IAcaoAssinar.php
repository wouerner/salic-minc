<?php

namespace MinC\Assinatura\Acao;

interface IAcao
{
    public function __construct(\MinC\Assinatura\Model\Assinatura $assinatura);

    public function executar();
}