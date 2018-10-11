<?php

namespace Application\Modules\AvaliacaoResultados\Service\LaudoFinal;

class Laudo 
{
    public function obterProjetos(){
        $model = new \AvaliacaoResultados_Model_DbTable_LaudoFinal();
        $model->projetosLaudoFinal();

        return $model->projetosLaudoFinal();
    }

    public function obterLaudo(){
        return[222222];
    }
    public function salvarLaudo($idLaudoFinal, $idPronac, $dtLaudoFinal, $siManifestacao, $dsLaudoFinal, $idUsuario){
        return true;
    }
}