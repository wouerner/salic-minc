<?php

/**
 * View para painel de avaliação das propostas e tranformação em projetos.
 *
 * @link http://salic.cultura.gov.br
 */
class Admissibilidade_Model_DbTable_VwPainelAvaliarPropostas extends MinC_Db_Table_Abstract
{
    protected $_schema = 'sac';
    protected $_name = 'vwPainelAvaliarPropostas';
    protected $_primary = 'idProjeto';

    public function propostas($where = array(), $order = array(), $start = 0, $limit = 10, $search = null)
    {
        $db = $this->getAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);

        $sql = $db->select()
            ->from('vwPainelAvaliarPropostas', '*', $this->_schema);

        foreach ($where as $coluna => $valor) {
            $sql->where($coluna, $valor);
        }

        if (!empty($search['value'])) {
            $sql->where('idProjeto like ? OR NomeProposta like ? OR Tecnico like ?', '%' . $search['value'] . '%');
        }

        $sql->order($order);

        if (!is_null($start) && $limit) {
            $start = (int)$start;
            $limit = (int)$limit;
            $sql->limitPage($start, $limit);
        }

        return $db->fetchAll($sql);
    }

    public function obterPropostasParaAvaliacao(
        $where = [],
        $order = [],
        $start = 0,
        $limit = 10,
        $search = null,
        Admissibilidade_Model_DistribuicaoAvaliacaoProposta $distribuicaoAvaliacaoProposta = null
    )
    {
        $db = $this->getAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);

        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from('vwPainelAvaliarPropostas',
            ['*'],
            $this->_schema);

        if (!is_null($start) && $limit) {
            $start = (int)$start;
            $limit = (int)$limit;
            $select->limitPage($start, $limit);
        }

        $sqlPerfisDistribuicao = '';
        $perfisDistribuicao = $this->obterPerfisDistribuicao($distribuicaoAvaliacaoProposta);
        if ($perfisDistribuicao) {
            $sqlPerfisDistribuicao = " and distribuicao_avaliacao_proposta.id_perfil in ({$perfisDistribuicao}) ";
        }

        $select->joinLeft(
            ['distribuicao_avaliacao_proposta']
            , "distribuicao_avaliacao_proposta.id_preprojeto = vwPainelAvaliarPropostas.idProjeto
                    {$sqlPerfisDistribuicao}
                    and distribuicao_avaliacao_proposta.id_orgao_superior = {$distribuicaoAvaliacaoProposta->getIdOrgaoSuperior()}"
            ,
            [
                'avaliacao_atual' => "coalesce(distribuicao_avaliacao_proposta.avaliacao_atual, '0')",
                'quantidade_distribuicoes' => "coalesce(distribuicao_avaliacao_proposta.id_distribuicao_avaliacao_proposta, '0')"
            ]
            , $this->getSchema('sac')
        );

        if ($distribuicaoAvaliacaoProposta->getIdPerfil() == Autenticacao_Model_Grupos::COORDENADOR_ADMISSIBILIDADE
            || $distribuicaoAvaliacaoProposta->getIdPerfil() == Autenticacao_Model_Grupos::COMPONENTE_COMISSAO) {
            $select->joinLeft(
                ['sugestao_enquadramento']
//                , "sugestao_enquadramento.id_distribuicao_avaliacao_proposta = distribuicao_avaliacao_proposta.id_distribuicao_avaliacao_proposta"
                , "sugestao_enquadramento.id_preprojeto = vwPainelAvaliarPropostas.idProjeto
                        and sugestao_enquadramento.id_orgao_superior = {$distribuicaoAvaliacaoProposta->getIdOrgaoSuperior()}
                        and sugestao_enquadramento.id_perfil_usuario = {$distribuicaoAvaliacaoProposta->getIdPerfil()}"
                , [
                    'sugestao_enquadramento.id_area',
                    'sugestao_enquadramento.id_sugestao_enquadramento',
                ]
                , $this->getSchema('sac')
            );

            if ($distribuicaoAvaliacaoProposta->getIdPerfil() == Autenticacao_Model_Grupos::COMPONENTE_COMISSAO) {

                $subSelectPenultimaDistribuicao = $this->select();
                $subSelectPenultimaDistribuicao->setIntegrityCheck(false);
                $subSelectPenultimaDistribuicao->from(
                    ['sub_select_distribuicao_avaliacao' => 'distribuicao_avaliacao_proposta'],
                    [
                        new Zend_Db_Expr('*')
                    ],
                    $this->getSchema('sac')
                );
                $subSelectPenultimaDistribuicao->limit(1);
                $subSelectPenultimaDistribuicao->order('data_distribuicao desc');
                $subSelectPenultimaDistribuicao->where('id_preprojeto = vwPainelAvaliarPropostas.idProjeto');
                $subSelectPenultimaDistribuicao->where('avaliacao_atual = ?', 0);

                $selectPenultimaDistribuicao = $this->select();
                $selectPenultimaDistribuicao->setIntegrityCheck(false);
                $selectPenultimaDistribuicao->isUseSchema(false);
                $selectPenultimaDistribuicao->from(
                    $subSelectPenultimaDistribuicao,
                    ['id_distribuicao_avaliacao_proposta']
                );

                $select->isUseSchema(false);
                $select->joinLeft(
                    ['penultima_distribuicao' => 'distribuicao_avaliacao_proposta'],
                    "vwPainelAvaliarPropostas.idProjeto = penultima_distribuicao.id_preprojeto
                    and penultima_distribuicao.id_distribuicao_avaliacao_proposta = ({$selectPenultimaDistribuicao})",
                    []
                );
                $select->isUseSchema(true);

                $select->joinLeft(
                    ['sugestao_distribuida' => 'sugestao_enquadramento']
                    , "sugestao_distribuida.id_distribuicao_avaliacao_proposta = penultima_distribuicao.id_distribuicao_avaliacao_proposta"
                    , []
                    , $this->getSchema('sac')
                );

                $auth = Zend_Auth::getInstance();
                $tblAgente = new Agente_Model_DbTable_Agentes();
                $rsAgente = $tblAgente->buscarAgenteENome(
                    ['CNPJCPF = ?' => $auth->getIdentity()->usu_identificacao]
                );
                if ($rsAgente && count($rsAgente->current()->toArray()) > 0) {
                    $select->joinLeft(
                        ['tbtitulacaoconselheiro']
                        , "
                        tbtitulacaoconselheiro.cdArea = sugestao_distribuida.id_area
                        and tbtitulacaoconselheiro.stTitular = 1
                        and tbtitulacaoconselheiro.stConselheiro = 'A'
                    "
                        , []
                        , $this->getSchema('agentes')
                    );
                    $agente = $rsAgente->current()->toArray();
                    $select->where('tbtitulacaoconselheiro.idAgente = ?', $agente['idAgente']);
                }
            }
        }

        foreach ($where as $coluna => $valor) {
            $select->where($coluna, $valor);
        }

        if (!empty($search['value'])) {
            $select->where('idProjeto like ? OR NomeProposta like ? OR Tecnico like ?', "%{$search['value']}%");
        }

        $restricaoPropostasParaAvaliacao = $this->obterRestricaoPropostasParaAvaliacao($distribuicaoAvaliacaoProposta);
        if ($restricaoPropostasParaAvaliacao) {
            $select->where($restricaoPropostasParaAvaliacao);
        }

        if ($order) {
            $select->order($order);
        }
//        xdnb($select->assemble());
        return $db->fetchAll($select);
    }

    private function obterRestricaoPropostasParaAvaliacao(Admissibilidade_Model_DistribuicaoAvaliacaoProposta $distribuicaoAvaliacaoProposta)
    {
        if ($distribuicaoAvaliacaoProposta->getIdPerfil()) {
            $restricaoPropostasParaAvaliacao = '( ';
            if ($distribuicaoAvaliacaoProposta->getIdPerfil() == Autenticacao_Model_Grupos::TECNICO_ADMISSIBILIDADE
                || $distribuicaoAvaliacaoProposta->getIdPerfil() == Autenticacao_Model_Grupos::COORDENADOR_ADMISSIBILIDADE) {
                $restricaoPropostasParaAvaliacao .= ' distribuicao_avaliacao_proposta.avaliacao_atual is null ';
                $restricaoPropostasParaAvaliacao .= ' AND distribuicao_avaliacao_proposta.id_distribuicao_avaliacao_proposta is null ';
                $restricaoPropostasParaAvaliacao .= ' AND sugestao_enquadramento.id_area is null';
                $restricaoPropostasParaAvaliacao .= ' AND sugestao_enquadramento.id_sugestao_enquadramento is null ';
            }
            if ($distribuicaoAvaliacaoProposta->getIdPerfil() != Autenticacao_Model_Grupos::TECNICO_ADMISSIBILIDADE) {
                if (!empty($restricaoPropostasParaAvaliacao) && $restricaoPropostasParaAvaliacao != '( ') {
                    $restricaoPropostasParaAvaliacao .= ' OR ';
                }
                $restricaoPropostasParaAvaliacao .= 'distribuicao_avaliacao_proposta.avaliacao_atual = 1 and distribuicao_avaliacao_proposta.id_distribuicao_avaliacao_proposta > 0';
            }
            $restricaoPropostasParaAvaliacao .= ' )';
            return $restricaoPropostasParaAvaliacao;
        }
    }


    private function obterPerfisDistribuicao(Admissibilidade_Model_DistribuicaoAvaliacaoProposta $distribuicaoAvaliacaoProposta)
    {
        if ($distribuicaoAvaliacaoProposta->getIdPerfil() != Autenticacao_Model_Grupos::TECNICO_ADMISSIBILIDADE) {
            $perfis = [
                $distribuicaoAvaliacaoProposta->getIdPerfil()
            ];

            if ($distribuicaoAvaliacaoProposta->getIdPerfil() == Autenticacao_Model_Grupos::COORDENADOR_ADMISSIBILIDADE) {
                $perfis[] = Autenticacao_Model_Grupos::TECNICO_ADMISSIBILIDADE;
            }
            return implode(',', $perfis);
        }
    }

    public function propostasTotal($where = array(), $order = array(), $start = null, $limit = null, $search = null)
    {
        $db = $this->getAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);

        $sql = $db->select()
            ->from('vwPainelAvaliarPropostas', 'count(*) as total', $this->_schema);

        foreach ($where as $coluna => $valor) {
            $sql->where($coluna, $valor);
        }

        if (!empty($search['value'])) {
            $sql->where('idProjeto like ? OR NomeProposta like ? OR Tecnico like ?', '%' . $search['value'] . '%');
        }

        $sql->order($order);

        if (!is_null($start) && $limit) {
            $start = (int)$start;
            $limit = (int)$limit;
            $sql->limitPage($start, $limit);
        }
        //echo $sql;

        return $db->fetchRow($sql);
    }
}
