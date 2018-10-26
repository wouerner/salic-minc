<?php

use Application\Modules\AvaliacaoResultados\Service\Encaminhar\AvaliacaoFinanceira as EncaminharAvaliacaoService;

class AvaliacaoResultados_Events_Encaminhar
{
    protected $events;

    public function __construct(Zend_EventManager_EventCollection $events = null)
    {
        if (null !== $events) {
            $this->events = $events;
        } elseif (null === $this->events) {
            $this->events = new Zend_EventManager_EventManager(__CLASS__);
        }

        $this->attach();
    }

    public function attach() {
        $this->events->attach('run', $this->alterarSituacaoProjeto());
        $this->events->attach('run', $this->salvarEncaminhamento());
        $this->events->attach('run', $this->alterarEstado());
    }

    public function run($params) {
        /* var_dump($params);die; */
        $this->events->trigger(__FUNCTION__, $this, $params);
    }

    public function salvarEncaminhamento() {
        return function($t) {
            $params = $t->getParams();
            $EncaminharAvaliacaoService = new EncaminharAvaliacaoService();
            $EncaminharAvaliacaoService->salvar($params);
        };
    }

    public function alterarSituacaoProjeto() {
        return function($t) {
            $params = $t->getParams();
            $projeto = new Projetos();
            $projeto->alterarSituacao($params['idPronac'], '', 'E27', 'Comprova&ccedil;&atilde;o Financeira do Projeto em Análise');
        };
    }

    public function alterarEstado() {
        return function($t) {
            $params = $t->getParams();

            $model = new AvaliacaoResultados_Model_FluxosProjeto();
            $mapper = new AvaliacaoResultados_Model_FluxosProjetoMapper();

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
        };
    }
}