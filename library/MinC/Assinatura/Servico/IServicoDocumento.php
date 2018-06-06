<?php

namespace MinC\Assinatura\Servico;

interface IServicoDocumento
{
    /**
     * @return \MinC\Assinatura\Documento\IDocumentoAssinatura
     */
    function obterServicoDocumentoAssinatura();
}