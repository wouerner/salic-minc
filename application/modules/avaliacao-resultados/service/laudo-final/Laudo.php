<?php

namespace Application\Modules\AvaliacaoResultados\Service\LaudoFinal;

class Laudo 
{
    public function obterProjetos(){
        return [323232];
    }

    public function obterLaudo(){
        return[222222];
    }

    public function salvarLaudo($idLaudoFinal, $idPronac, $dtLaudoFinal, $siManifestacao, $dsLaudoFinal, $idUsuario){
        $model = new \AvaliacaoResultados_Model_LaudoFinal;
        $model->setIdLaudoFinal($idLaudoFinal);
        $model->setIdPronac($idPronac);
        $model->setDtLaudoFinal($dtLaudoFinal);
        $model->setSiManifestacao($siManifestacao);
        $model->setDsLaudoFinal($dsLaudoFinal);
        $model->setIdUsuario($idUsuario);

        $mapper = new \AvaliacaoResultados_Model_LaudoFinalMapper;
        $mapper->save($model);
        return true;
    }
}