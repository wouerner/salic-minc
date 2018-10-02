<?php

namespace Application\Modules\AvaliacaoResultados\Service\ParecerTecnico;


class RevisaoAvaliacaoFinanceira
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;


    function __construct(\Zend_Controller_Request_Abstract $request, \Zend_Controller_Response_Abstract $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarRevisoes() {

        $tbAvaliacaoFinanceira = new \AvaliacaoResultados_Model_DbTable_tbAvaliacaoFinanceiraRevisao();
        $where = [
            'idAvaliacaoFinanceiraRevisao' => $this->request->idAvaliacaoFinanceiraRevisao
        ];
        $dadosRevisao = $tbAvaliacaoFinanceira->findBy($where);
        $dadosRevisao = ($dadosRevisao) ?: new \stdClass();

        return [
            'revisao' => $dadosRevisao
        ];
    }

    public function salvar()
    {
        $authInstance = \Zend_Auth::getInstance();
        $arrAuth = array_change_key_case((array)$authInstance->getIdentity());

        $parametros = $this->request->getParams();
        $tbAvaliacaoFinanceiraRevisao = new \AvaliacaoResultados_Model_tbAvaliacaoFinanceiraRevisao($parametros);
        $tbAvaliacaoFinanceiraRevisao->setDtRevisao(date('Y-m-d h:i:s'));
        $tbAvaliacaoFinanceiraRevisao->setIdUsuario($arrAuth['usu_codigo']);
        $tbAvaliacaoFinanceiraRevisao->setDsRevisao();
        $tbAvaliacaoFinanceiraRevisao->setSiStattus();
        $tbAvaliacaoFinanceiraRevisao->setIdGrupoAtivo();
        $tbAvaliacaoFinanceiraRevisao->setIdParecerAvaliacaoFinanceira();

        $mapper = new \AvaliacaoResultados_Model_tbAvaliacaoFinanceiraMapper();
        $codigo = $mapper->save($tbAvaliacaoFinanceiraRevisao);

        $this->request->setParam('idAvaliacaoFinanceiraRevisao', $codigo);

        if (!$codigo) {
            return $mapper->getMessages();
        }

        return $this->buscarRevisao();

    }

    public function buscarRevisao()
    {
        $tbRevisao = new \AvaliacaoResultados_Model_DbTable_tbAvaliacaoFinanceiraRevisao();
        $where = [
            $tbRevisao->getPrimary() => $this->request->idAvaliacaoFinanceiraRevisao
        ];

        return $tbRevisao->findBy($where);
    }
}
