<?php

namespace Application\Modules\Readequacao\Service\Readequacao;

use MinC\Servico\IServicoRestZend;

class Readequacao implements IServicoRestZend
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscar($idReadequacao)
    {
        $modelTbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $where = [
            'idReadequacao' => $idReadequacao
        ];

        return $modelTbReadequacao->findBy($where);
    }

    public function buscarReadequacoes($idPronac, $idTipoReadequacao = '', $stEstagioAtual = '')
    {
        $modelTbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $where = [
            'idPronac = ?' => $idPronac
        ];

        if ($idTipoReadequacao != '') {
            $where['idTipoReadequacao = ?'] = $idTipoReadequacao;
        }
        
        switch ($stEstagioAtual) {
            case 'proponente':
                $where['siEncaminhamento = ?'] = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_CADASTRADA_PROPONENTE;
                $where['stEstado = ?'] = \Readequacao_Model_DbTable_TbReadequacao::ST_ESTADO_EM_ANDAMENTO;
                break;
            case 'analise':
                $where['siEncaminhamento != ?'] = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_CADASTRADA_PROPONENTE;
                $where['stEstado = ?'] = \Readequacao_Model_DbTable_TbReadequacao::ST_ESTADO_EM_ANDAMENTO;
                break;
            case 'finalizadas':
                $where['stEstado = ?'] = \Readequacao_Model_DbTable_TbReadequacao::ST_ESTADO_FINALIZADO;
                break;
                
            default:
                break;
        }
        
        $resultArray = $modelTbReadequacao->buscar($where)->toArray();
        $resultArray = \TratarArray::utf8EncodeArray($resultArray);
        
        return $resultArray;
    }

    public function buscarReadequacoesPorPronacTipo($idPronac, $idTipoReadequacao)
    {
        $modelTbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $where = [
            'idPronac' => $idPronac,
            'idTipoReadequacao' => $idTipoReadequacao,
        ];
        
        return $modelTbReadequacao->findBy($where);
    }    

    public function buscarReadequacaoDocumento($idReadequacao, $idDocumento)
    {
        return [];
    }
    
    public function salvar()
    {
        $parametros = $this->request->getParams();
        
        $dados = [];
        $dados['idReadequacao'] = $parametros['idReadequacao'];
        $dados['idPronac'] = $parametros['idPronac'];
        $dados['dsJustificativa'] = $parametros['dsJustificativa'];
        $dados['dsSolicitacao'] = $parametros['dsSolicitacao'];
        $dados['dtSolicitacao'] = $parametros['dtSolicitacao'];
        $dados['stAtendimento'] = $parametros['stAtendimento'];
        $dados['idDocumento'] = $parametros['idDocumento'];

        $mapper = new \Readequacao_Model_TbReadequacaoMapper();
        $idReadequacao = $mapper->salvarSolicitacaoReadequacao($dados);
        
        return $this->buscar($idReadequacao);
    }
}
