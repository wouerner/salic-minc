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

    public function buscarRevisoes($data) {

        $tbAvaliacaoFinanceira = new \AvaliacaoResultados_Model_DbTable_tbAvaliacaoFinanceiraRevisao();
        $where = [
            'idAvaliacaoFinanceira' => $data
        ];
        $dadosRevisao = $tbAvaliacaoFinanceira->findByAvaliacaoFinanceira($where)->toArray();
        return $dadosRevisao;
    }

    public function salvar()
    {
        $authInstance = \Zend_Auth::getInstance();
        $arrAuth = array_change_key_case((array)$authInstance->getIdentity());
        $parametros = $this->request->getParams();
        $tbAvaliacaoFinanceiraRevisao = new \AvaliacaoResultados_Model_tbAvaliacaoFinanceiraRevisao($parametros);
        if(!isset($parametros->idAvaliacaoFinanceiraRevisao)){
            $tbAvaliacaoFinanceiraRevisao->setDtAtualizacao(date('Y-m-d h:i:s'));
        }else{
            $tbAvaliacaoFinanceiraRevisao->setDtRevisao(date('Y-m-d h:i:s'));
        }
        $tbAvaliacaoFinanceiraRevisao->setIdAgente($arrAuth['usu_codigo']);
        $mapper = new \AvaliacaoResultados_Model_tbAvaliacaoFinanceiraRevisaoMapper();
        $codigo = $mapper->save($tbAvaliacaoFinanceiraRevisao);
        $this->request->setParam('idAvaliacaoFinanceiraRevisao', $codigo);
        if (!$codigo) {
            return $mapper->getMessages();
        }
        return $this->buscarRevisao($codigo);
    }

    public function buscarRevisao()
    {
        $tbAvaliacaoFinanceira = new \AvaliacaoResultados_Model_DbTable_tbAvaliacaoFinanceiraRevisao();
        $where = [
            'idAvaliacaoFinanceiraRevisao' => $this->request->idAvaliacaoFinanceiraRevisao
        ];
        $dadosRevisao = $tbAvaliacaoFinanceira->findOneRevisao($where)->toArray();

        return $dadosRevisao;
    }
}
