<?php

namespace MinC\Assinatura\Servico;

interface IDocumentoAssinatura
{
    function criarDocumento();

    function iniciarFluxo();
}