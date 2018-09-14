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
        $idPronac = $this->request->getParam('idPronac', null);
        $idPreProjeto = $this->request->getParam('idPreProjeto', null);
        $listarTudo = $this->request->getParam('listarTudo', null);

        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        $where = [];
        if ($idPronac) {
            $where['a.idPronac = ?'] = (int) $idPronac;
        }

        if ($idPreProjeto) {
            $where['a.idProjeto = ?'] = (int) $idPreProjeto;
        }

        //    # Proponente
        //    if (isset($this->usuario['cpf'])) {
        //      $where["(a.idAgente = {$this->idAgente} OR a.idSolicitante = {$this->idUsuario})"] = '';
        //    }

//        # funcionarios do minc
//        if (isset($this->usuario['usu_codigo'])) {
//
//            if (empty($listarTudo)) {
//
//                $tecnicos = (new \Autenticacao_Model_Grupos)->buscarTecnicosPorOrgao($this->grupoAtivo->codOrgao)->toArray();
//
//                if (in_array($this->grupoAtivo->codGrupo, array_column($tecnicos, 'gru_codigo'))) {
//                    $where['a.idTecnico = ?'] = $this->idUsuario;
//                }
//
//                $where['a.idOrgao = ?'] = $this->grupoAtivo->codOrgao;
//                $where['a.siEncaminhamento = ?'] = \Solicitacao_Model_TbSolicitacao::SITUACAO_ENCAMINHAMENTO_ENCAMINHADA_AO_MINC;
//            }
//        }

        $obterSolicitacoes = new \Solicitacao_Model_DbTable_TbSolicitacao();
        $solicitacoes = $obterSolicitacoes->obterSolicitacoes($where)->toArray();

        foreach ($solicitacoes as $key => $solicitacao) {
            $objDateTimeSolicitacao = new \DateTime($solicitacao['dtSolicitacao']);
            $objDateTimeResposta = new \DateTime($solicitacao['dtResposta']);

            $solicitacoes[$key]['dtSolicitacao'] = $objDateTimeSolicitacao->format('d/m/Y H:i:s');
            $solicitacoes[$key]['dtResposta'] = $objDateTimeResposta->format('d/m/Y H:i:s');
            $solicitacoes[$key]['dsSolicitacao'] = $this->removerHtmlTags($solicitacao['dsSolicitacao']);
            $solicitacoes[$key]['dsResposta'] = $this->removerHtmlTags($solicitacao['dsResposta']);
        }

        array_walk($solicitacoes, function (&$value) {
            $value = array_map('utf8_encode', $value);
        });

        return $solicitacoes;
    }

    private function removerHtmlTags($string)
    {
        $result = strip_tags($string);
        return $this->stringReplace($result);
    }

    private function stringReplace($string)
    {
        return str_replace('&nbsp;', '', $string);
    }
}
