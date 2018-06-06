<?php

namespace MinC\Assinatura\Servico;

interface IDocumentoAssinatura
{
    function __construct($idPronac, $idTipoDoAtoAdministrativo, $idAtoDeGestao);

    function criarDocumento();

    function iniciarFluxo();
}