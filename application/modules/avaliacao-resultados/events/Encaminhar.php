<?php

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
        /* $this->events->attach('run', $this->alterarSituacaoProjeto()); */
        $this->events->attach('run', $this->salvarEncaminhamento());
    }

    public function run($params) {
        echo "Run || ";
        $this->events->trigger(__FUNCTION__, $this, $params);
    }

    public function salvarEncaminhamento() {
        return function($t) {
            $params = $t->getParams();
            echo ' 1. salvarEncaminhamento || ';
            $mapper = new AvaliacaoResultados_Model_tbEncaminhamentoPrestacaoContasMapper();
            $model = new AvaliacaoResultados_Model_tbEncaminhamentoPrestacaoContas();

            $model->setIdPronac($params['idPronac']);
            $model->setIdAgenteOrigem($params['idAgenteOrigem']);
            $model->setDtInicioEncaminhamento($params['dtInicioEncaminhamento']);
            $model->setIdOrgaoDestino($params['idOrgaoDestino']);
            $model->setIdOrgaoOrigem($params['idOrgaoOrigem']);
            $model->setIdAgenteDestino($params['idAgenteDestino']);
            $model->setCdGruposDestino($params['cdGruposDestino']);
            $model->setCdGruposOrigem($params['cdGruposOrigem']);
            $model->setDtFimEncaminhamento($params['dtFimEncaminhamento']);
            $model->setIdSituacaoEncPrestContas($params['idSituacaoEncPrestContas']);
            $model->setIdSituacao($params['idSituacao']);
            $model->setStAtivo($params['stAtivo']);
            $model->setDsJustificativa($params['dsJustificativa']);
            /* var_dump($model); */
            /* die; */
            var_dump($mapper->save($model));
            die;
        };
    }

    public function alterarSituacaoProjeto() {
        return function() {
            echo ' alterarSituacaoProjeto || ';
        };
    }
}