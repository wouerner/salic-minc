<?php

namespace Application\Modules\Solicitacao\Service\Solicitacao;

class Mensagem
{
    const OBJECT_KEYS = [
        'idProjeto' => 'N&uacute;mero',
        'NomeProjeto' => 'Proposta/Projeto',
        'dsSolicitacao' => 'Solicita&ccedil;&atilde;o',
        'dsEncaminhamento' => 'Estado',
        'dtSolicitacao' => 'Dt. Solicita&ccedil;&atilde;o',
        'dtResposta' => 'Dt. Resposta',
    ];

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

        # Proponente
        if (isset($this->usuario['cpf'])) {
            $where["(a.idAgente = {$this->idAgente} OR a.idSolicitante = {$this->idUsuario})"] = '';
        }

        # funcionarios do minc
        if (isset($this->usuario['usu_codigo'])) {

            if (empty($listarTudo)) {

                $tecnicos = (new \Autenticacao_Model_Grupos)->buscarTecnicosPorOrgao($this->grupoAtivo->codOrgao)->toArray();

                if (in_array($this->grupoAtivo->codGrupo, array_column($tecnicos, 'gru_codigo'))) {
                    $where['a.idTecnico = ?'] = $this->idUsuario;
                }

                $where['a.idOrgao = ?'] = $this->grupoAtivo->codOrgao;
                $where['a.siEncaminhamento = ?'] = \Solicitacao_Model_TbSolicitacao::SITUACAO_ENCAMINHAMENTO_ENCAMINHADA_AO_MINC;
            }
        }

        $obterSolicitacoes = new \Solicitacao_Model_DbTable_TbSolicitacao();
        $solicitacoes = $obterSolicitacoes->obterSolicitacoes($where);

        $data = $this->montarHistoricoSolicitacoes($solicitacoes);

        return $data;
    }
    private function montarHistoricoSolicitacoes($solicitacoes): array
    {
        $resultado = [];
        $resultado['class'] = 'bordered striped';
        $resultado['cols'] = $this->montarHistoricoSolicitacoesColunas();
        $resultado['lines'] = $this->montarHistoricoSolicitacoesLinhas($solicitacoes);

        return $resultado;
    }

    private function montarHistoricoSolicitacoesColunas(): array
    {
        $colunas = [];

        foreach (self::OBJECT_KEYS as $key => $value) {
            $colunas[$key]['name'] = html_entity_decode($value);
        }

        return $colunas;
    }

    private function montarHistoricoSolicitacoesLinhas($solicitacoes): array
    {
        $lines = [];

        foreach ($solicitacoes as $solicitacao) {
            $result = $this->montarHistoricoSolicitacao($solicitacao);
            array_push($lines, $result);
        }

        return $lines;
    }

    private function montarHistoricoSolicitacao($solicitacao) : array
    {
        $current_object = [];

        foreach (self::OBJECT_KEYS as $key => $value) {
            $current_object[$key] = html_entity_decode(utf8_encode($solicitacao[$key]));
        }

        return $current_object;
    }
}
