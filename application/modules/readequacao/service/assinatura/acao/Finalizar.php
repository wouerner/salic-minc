<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcao;

class Finalizar implements IAcao, IAcaoFinalizar
{
    private $assinatura;

    public function __construct(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $this->assinatura = $assinatura;
    }

    public function executar()
    {

    }

}