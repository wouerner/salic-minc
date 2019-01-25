<?php

namespace Application\Modules\AvaliacaoResultados\Service\Fluxo;

class Estado 
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    public function validar($atual, $proximoEstado) {
        $estado = new \AvaliacaoResultados_Model_DbTable_Estados();
        $estado = $estado->findBy($atual);
        $proximo = json_decode($estado['proximo']);

        if (!in_array($proximoEstado, $proximo->proximo)) {
            throw new \Exception('Esse fluxo não pode ser executado!');
        }

        return true;
    }

    public function eventos($atual, $params) {
        $estado = new \AvaliacaoResultados_Model_DbTable_Estados();
        $estado = $estado->findBy($atual);

        $proximo = json_decode($estado['proximo']);
        $proximo = $proximo->proximo->{$params['proximo']};

        $inc = APPLICATION_PATH . $proximo->path;
        require($inc);

        $class = '\\' . $proximo->class;

        $eventClass = new $class();

        $eventClass->run($params);
    }

    public function alterarEstado($params){

        $model = new \AvaliacaoResultados_Model_FluxosProjeto();
        $mapper = new \AvaliacaoResultados_Model_FluxosProjetoMapper();

        $row = $mapper->find(['idPronac = ?' => $params['idPronac']]);

        if (!empty($row)) {
            $model->setId($row['id']);
        }

        $model->setIdPronac($params['idPronac']);
        $model->setEstadoId($params['proximo']);
        $model->setOrgao($params['idOrgaoDestino']);
        $model->setGrupo($params['cdGruposDestino']);
        $model->setIdAgente($params['idAgenteDestino']);

        $mapper->save($model);
    }
}