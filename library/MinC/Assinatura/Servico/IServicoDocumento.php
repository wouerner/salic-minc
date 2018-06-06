<?php

namespace MinC\Assinatura\Servico;

interface IServicoDocumento
{
    /**
     * @return \MinC\Assinatura\Servico\IDocumentoAssinatura
     */
    function obterServicoDocumentoAssinatura();
}