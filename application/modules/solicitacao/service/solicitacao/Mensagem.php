<?php

namespace Application\Modules\Solicitacao\Service\Solicitacao;

class Mensagem
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

    public function historicoSolicitacoes()
    {
        $idPreProjeto = $this->request->getParam('idPreProjeto');
        $idPronac = $this->request->getParam('idPronac');

        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        $where = [];
        if ($idPronac) {
            $where['a.idPronac = ?'] = (int)$idPronac;
        }

        if ($idPreProjeto) {
            $where['a.idProjeto = ?'] = (int)$idPreProjeto;
        }

        # Proponente
        if (isset($this->usuario['cpf'])) {
            $where["(a.idAgente = {$this->idAgente} OR a.idSolicitante = {$this->idUsuario})"] = '';
        }

        $obterSolicitacoes = new \Solicitacao_Model_DbTable_TbSolicitacao();
        $solicitacoes = $obterSolicitacoes->obterSolicitacoes($where)->toArray();

        array_walk($solicitacoes, function (&$value) {
            $value = array_map('utf8_encode', $value);
        });

        return $solicitacoes;
    }
}
