<?php

namespace Application\Modules\Analise\Service\AnaliseAprovacao;

use Seguranca;

class Recurso implements \MinC\Servico\IServicoRestZend
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

    public function buscarRecursos()
    {
        $idPronac = $this->request->idPronac;

        $mapperArea = new \Agente_Model_AreaMapper();

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }
        if (!empty($idPronac)) {
            $Projetos = new \Projetos();
            $rsProjeto = $Projetos->buscar(array("IdPronac=?"=>$idPronac))->current();

            // verifica se ha pedidos de reconsideracao e de recurso
            $tbRecurso = new \tbRecurso();
            $recursos = $tbRecurso->buscar(array('IdPRONAC = ?'=> $idPronac));
            $pedidoReconsideracao = 0;
            $pedidoRecurso = 0;

            $data= [];
            if (count($recursos)>0) {
                foreach ($recursos as $r) {
                    if ($r->tpRecurso == 1) {
                        $pedidoReconsideracao = $r->idRecurso;
                        $dados = $tbRecurso->buscarDadosRecursos(array('idRecurso = ?'=> $r->idRecurso))->current()->toArray();
                        $data['dadosReconsideracao'] = $dados;

                        $data['desistenciaReconsideracao'] = false;
                        if ($r->siRecurso == 0) {
                            $data['desistenciaReconsideracao'] = true;
                        }


                        if ($dados['siFaseProjeto'] == 2) {
                            if ($dados['tpSolicitacao'] == 'PI' || $dados['tpSolicitacao'] == 'EO' || $dados['tpSolicitacao'] == 'OR') {

                                $PlanoDistribuicaoProduto = new \Proposta_Model_DbTable_PlanoDistribuicaoProduto();
                                $dadosProdutos = $PlanoDistribuicaoProduto->buscarProdutosProjeto($dados['IdPRONAC'])->toArray();
                                $data['produtosReconsideracao'] = $dadosProdutos;

                                $tipoDaPlanilha = 3; // 3=Planilha Orcamentaria Aprovada Ativa

//                                $spPlanilhaOrcamentaria = new \spPlanilhaOrcamentaria();
//                                $planilhaOrcamentaria = $spPlanilhaOrcamentaria->exec($dados['IdPRONAC'], $tipoDaPlanilha);
//                                $data['planilhaReconsideracao'] = $this->montarPlanilhaOrcamentaria($planilhaOrcamentaria, $tipoDaPlanilha);
                            }
                        }

                        if ($dados['tpSolicitacao'] == 'EN' || $dados['tpSolicitacao'] == 'EO' || $dados['tpSolicitacao'] == 'OR' || $dados['tpSolicitacao'] == 'PI') {
                            $data['projetosENReconsideracao'] = $Projetos->buscaAreaSegmentoProjeto($dados['IdPRONAC'])->toArray();

                            $data['projetosENReconsideracao']['artigo'] = $this->obterArtigoEnquadramento(
                                $data['projetosENReconsideracao']['cdSegmento']
                            );
                            $data['comboareasculturaisReconsideracao']= $mapperArea->fetchPairs('codigo', 'descricao');

//                            $objSegmentocultural = new \Segmentocultural();
//                            $data['combosegmentosculturaisReconsideracao'] = $objSegmentocultural->buscarSegmento($data['projetosENReconsideracao']['cdArea']);

                            $parecer = new \Parecer();

                            $parecer = $parecer->buscar(array('IdPRONAC = ?' => $dados['IdPRONAC'], 'TipoParecer in (?)' => array(1,7), 'stAtivo = ?' => 1));
                            $data['ParecerReconsideracao'] = $parecer ? $parecer->toArray() : [];
                        }
                    }


//                    if ($r->tpRecurso == 2) {
//                        $pedidoRecurso = $r->idRecurso;
//                        $dados = $tbRecurso->buscarDadosRecursos(array('idRecurso = ?'=>$r->idRecurso))->toArray();
//                        $data['dadosRecurso'] = $dados;
//
//                        $data['desistenciaRecurso'] = false;
//                        if ($r->siRecurso == 0) {
//                            $data['desistenciaRecurso'] = true;
//                        }
//
//                        if ($dados['siFaseProjeto'] == 2) {
//                            if ($dados['tpSolicitacao'] == 'PI' || $dados['tpSolicitacao'] == 'EO' || $dados['tpSolicitacao'] == 'OR') {
//                                $PlanoDistribuicaoProduto = new \Proposta_Model_DbTable_PlanoDistribuicaoProduto();
//                                $dadosProdutos = $PlanoDistribuicaoProduto->buscarProdutosProjeto($dados['IdPRONAC'])->toArray();
//                                $data['produtosRecurso'] = $dadosProdutos;
//
//                                $tipoDaPlanilha = 2; // 2=Planilha Aprovada Parecerista
//                                    if ($data['tpSolicitacao'] == 'EO' || $data['tpSolicitacao'] == 'OR') {
//                                    $tipoDaPlanilha = 4; // 4=Cortes Or�ament�rios Aprovados
//                                }
////                                $spPlanilhaOrcamentaria = new \spPlanilhaOrcamentaria();
////
////                                $planilhaOrcamentaria = $spPlanilhaOrcamentaria->exec($dados['IdPRONAC'], $tipoDaPlanilha);
////                                $data['planilhaRecurso'] = $this->montarPlanilhaOrcamentaria($planilhaOrcamentaria, $tipoDaPlanilha);
//                            }
//                        }
//                        if ($dados['tpSolicitacao'] == 'EN' || $dados['tpSolicitacao'] == 'EO' || $dados['tpSolicitacao'] == 'OR' || $dados['tpSolicitacao'] == 'PI') {
//                            $data['projetosENRecurso'] = $Projetos->buscaAreaSegmentoProjeto($dados['IdPRONAC']);
//
////                            $this->view->comboareasculturais = $mapperArea->fetchPairs('codigo', 'descricao');
////                            $objSegmentocultural = new Segmentocultural();
////                            $this->view->combosegmentosculturaisRecurso = $objSegmentocultural->buscarSegmento($this->view->projetosENRecurso->cdArea);
//
//                            $parecer = new \Parecer();
//
//                            $parecer = $parecer->buscar(array('IdPRONAC = ?' => $dados['IdPRONAC'], 'TipoParecer in (?)' => 7, 'stAtivo = ?' => 1));
//                            $data['ParecerReconsideracao'] = $parecer ? $parecer->toArray() : [];
//
//                        }
//
//                    }
                }
        return $data;
            }

//            $this->view->pedidoReconsideracao = $pedidoReconsideracao;
//            $this->view->pedidoRecurso = $pedidoRecurso;
        }
    }

    private function obterArtigoEnquadramento($segmento) {
        return in_array($segmento, \Segmento::SEGMENTOS_ARTIGO_18) ? 'Artigo 18' : 'Artigo 16';
    }
}
