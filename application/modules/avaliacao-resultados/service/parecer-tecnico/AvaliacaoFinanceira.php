<?php

namespace Application\Modules\AvaliacaoResultados\Service\ParecerTecnico;


class AvaliacaoFinanceira
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;


    function __construct(\Zend_Controller_Request_Abstract $request = null, \Zend_Controller_Response_Abstract $response = null )
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarDadosProjeto()
    {
        $vwResultadoDaAvaliacaoFinanceira = new \AvaliacaoResultados_Model_DbTable_vwResultadoDaAvaliacaoFinanceira();
        $dadosAvaliacaoFinanceira = $vwResultadoDaAvaliacaoFinanceira->buscarConsolidacaoComprovantes($this->request->idPronac);
        $dadosAvaliacaoFinanceira = $dadosAvaliacaoFinanceira->toArray();

        $projeto = new \Projetos();
        $dadosProjeto = $projeto->buscar([
            'idPronac = ?' => $this->request->idPronac
        ]);
        $dadosProjeto = $dadosProjeto->toArray()[0];

        $proponente = new \ProponenteDAO();
        $dadosProponente = $proponente->buscarDadosProponente($this->request->idPronac);
        $dadosProponente = (array)$dadosProponente[0];

        $tbAvaliacaoFinanceira = new \AvaliacaoResultados_Model_DbTable_tbAvaliacaoFinanceira();
        $where = [
            'idPronac' => $this->request->idPronac
        ];
        $dadosParecer = $tbAvaliacaoFinanceira->findBy($where);
        $dadosParecer = ($dadosParecer) ?: new \stdClass();

        $vwVisualizarparecer = new \AvaliacaoResultados_Model_DbTable_vwVisualizarParecerDeAvaliacaoDeResultado();
        $dadosObjetoParecer = $vwVisualizarparecer->buscarObjetoParecerAvaliacaoResultado($this->request->idPronac);
        $dadosObjetoParecer = $dadosObjetoParecer ? $dadosObjetoParecer->toArray() : null;

        return [
            'consolidacaoComprovantes' => $dadosAvaliacaoFinanceira,
            'projeto' => $dadosProjeto,
            'proponente' => $dadosProponente,
            'parecer' => $dadosParecer,
            'objetoParecer' => $dadosObjetoParecer
        ];
    }

    public function buscarAvaliacaoFinanceira()
    {
        $tbAvaliacaoFinanceira = new \AvaliacaoResultados_Model_DbTable_tbAvaliacaoFinanceira();
        $where = [
            $tbAvaliacaoFinanceira->getPrimary() => $this->request->idAvaliacaoFinanceira
        ];

        return $tbAvaliacaoFinanceira->findBy($where);
    }

    public function salvar()
    {
        $authInstance = \Zend_Auth::getInstance();
        $arrAuth = array_change_key_case((array)$authInstance->getIdentity());

        $parametros = $this->request->getParams();
        $tbAvaliacaoFinanceira = new \AvaliacaoResultados_Model_tbAvaliacaoFinanceira($parametros);
        $tbAvaliacaoFinanceira->setDtAvaliacaoFinanceira(date('Y-m-d h:i:s'));
        $tbAvaliacaoFinanceira->setIdUsuario($arrAuth['usu_codigo']);

        $mapper = new \AvaliacaoResultados_Model_tbAvaliacaoFinanceiraMapper();
        $codigo = $mapper->save($tbAvaliacaoFinanceira);

        $this->request->setParam('idAvaliacaoFinanceira', $codigo);

        if (!$codigo) {
            return $mapper->getMessages();
        }

        return $this->buscarAvaliacaoFinanceira();
    }

    public function obterProjetosParaAnaliseTecnica()
    {
        $auth = \Zend_Auth::getInstance();
        $this->getIdUsuario = isset($auth->getIdentity()->usu_codigo) ? $auth->getIdentity()->usu_codigo : $auth->getIdentity()->IdUsuario;

        $where['e.stAtivo = ?'] = 1;
        $where['e.idAgenteDestino = ?'] = $this->getIdUsuario; //id Tecnico de Presta&ccedil;&atilde;o de Contas
        $where['e.cdGruposDestino in (?)'] = [124, 125]; //grupo do tecnico de prestacao de contas

        // t�cnico s� visualiza projetos encaminhados para ele
        $where['p.Situacao in (?)'] = array('E17', 'E20', 'E27', 'E30');
        $where['e.idSituacaoEncPrestContas = ?'] = '2';

        $tbProjetos = new \Projetos();

        $projetos = $tbProjetos->buscarPainelTecPrestacaoDeContas($where)->toArray();

        return $projetos;
    }

    public function salvarParecer(Array $parametros){

        $authInstance = \Zend_Auth::getInstance();
        $arrAuth = array_change_key_case((array)$authInstance->getIdentity());

        $tbAvaliacaoFinanceira = new \AvaliacaoResultados_Model_tbAvaliacaoFinanceira($parametros);
        $tbAvaliacaoFinanceira->setDtAvaliacaoFinanceira(date('Y-m-d h:i:s'));
        $tbAvaliacaoFinanceira->setIdUsuario($arrAuth['usu_codigo']);

        $mapper = new \AvaliacaoResultados_Model_tbAvaliacaoFinanceiraMapper();
        $codigo = $mapper->save($tbAvaliacaoFinanceira);

        if (!$codigo) {
            return $mapper->getMessages();
        }

        return (new \AvaliacaoResultados_Model_DbTable_tbAvaliacaoFinanceira())
            ->findBy([
                'idAvaliacaoFinanceira' => $codigo
            ]);
    }
}

