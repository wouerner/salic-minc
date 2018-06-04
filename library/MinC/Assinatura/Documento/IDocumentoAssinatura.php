<?php

namespace MinC\Assinatura\Documento;

interface IDocumentoAssinatura
{
    function criarDocumento();

    function iniciarFluxo();
}