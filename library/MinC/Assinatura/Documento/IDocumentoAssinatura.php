<?php

namespace MinC\Assinatura\Documento;

interface IDocumentoAssinatura
{
    function gerarDocumentoAssinatura();

    function encaminharProjetoParaAssinatura();
}