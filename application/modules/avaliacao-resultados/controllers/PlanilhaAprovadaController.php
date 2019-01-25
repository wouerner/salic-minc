<?php

class AvaliacaoResultados_PlanilhaAprovadaController extends MinC_Controller_Rest_Abstract
{

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $profiles = [
            // Autenticacao_Model_Grupos::TECNICO_PRESTACAO_DE_CONTAS,
            // Autenticacao_Model_Grupos::COORDENADOR_PRESTACAO_DE_CONTAS,
            // Autenticacao_Model_Grupos::COORDENADOR_GERAL_PRESTACAO_DE_CONTAS,
        ];

        $permissionsPerMethod  = [
        ];
        $this->setProtectedMethodsProfilesPermission($permissionsPerMethod);

        parent::__construct($request, $response, $invokeArgs);
    }

    public function getAction(){
        $idPronac = $this->getRequest()->getParam('idPronac');
        $data = [];
        $code = 200;

        $planilhaAprovacaoModel = new PlanilhaAprovacao();
        $resposta = $planilhaAprovacaoModel->planilhaAprovada($idPronac);
        /* var_dump(empty($resposta->toArray()));die; */

        $planilhaJSON = null;

        if(!empty($resposta->toArray())) {

            foreach($resposta as $item) {
                if($item->stItemAvaliado){
                    $planilhaJSON
                        [$item->cdProduto]
                        ['etapa']
                        [$item->cdEtapa]
                        ['UF']
                        [$item->cdUF]
                        ['cidade']
                        [$item->cdCidade]
                        ['itens']
                        [$item->stItemAvaliado]
                        [$item->idPlanilhaItens] = [
                            'item' => utf8_encode($item->Item),
                            'valor' => utf8_encode($item->valor),
                            'quantidade' => ($item->quantidade),
                            'numeroOcorrencias' => ($item->numeroOcorrencias),
                            'varlorAprovado' => $item->vlAprovado,
                            'varlorComprovado' => $item->vlComprovado,
                            'comprovacaoValidada' => $item->ComprovacaoValidada,
                            'idPlanilhaAprovacao' => $item->idPlanilhaAprovacao,
                            'idPlanilhaItens' => $item->idPlanilhaItens,
                            'ComprovacaoValidada' => $item->ComprovacaoValidada,
                            'stItemAvaliado' => $item->stItemAvaliado,
                        ];
                }

                $planilhaJSON
                [$item->cdProduto]
                ['etapa']
                [$item->cdEtapa]
                ['UF']
                [$item->cdUF]
                ['cidade']
                [$item->cdCidade]
                ['itens']
                ['todos']
                [$item->idPlanilhaItens] = [
                    'item' => utf8_encode($item->Item),
                    'valor' => utf8_encode($item->valor),
                    'quantidade' => ($item->quantidade),
                    'numeroOcorrencias' => ($item->numeroOcorrencias),
                    'varlorAprovado' => $item->vlAprovado,
                    'varlorComprovado' => $item->vlComprovado,
                    'comprovacaoValidada' => $item->ComprovacaoValidada,
                    'idPlanilhaAprovacao' => $item->idPlanilhaAprovacao,
                    'idPlanilhaItens' => $item->idPlanilhaItens,
                    'ComprovacaoValidada' => $item->ComprovacaoValidada,
                    'stItemAvaliado' => $item->stItemAvaliado,
                ];

                $planilhaJSON[$item->cdProduto] += [
                    'produto' => html_entity_decode(utf8_encode($item->Produto)),
                    'cdProduto' => $item->cdProduto,
                ];

                $planilhaJSON[$item->cdProduto]['etapa'][$item->cdEtapa] += [
                    'etapa' => utf8_encode($item->Etapa),
                    'cdEtapa' =>  $item->cdEtapa
                ];

                $planilhaJSON[$item->cdProduto]['etapa'][$item->cdEtapa]['UF'][$item->cdUF] += [
                    'Uf' => $item->Uf,
                    'cdUF' => $item->cdUF
                ];

                $planilhaJSON[$item->cdProduto]['etapa'][$item->cdEtapa]['UF'][$item->cdUF]['cidade'][$item->cdCidade] += [
                    'cidade' => utf8_encode($item->Cidade),
                    'cdCidade' => $item->cdCidade
                ];
            }
            $data = $planilhaJSON;

        } else {
            $code = 400;
            $data['data']['erro'] = ['message' => 'Não existe planilha para esse projeto!'];
        }

        /* $data = \TratarArray::utf8EncodeArray($data); */

        $this->customRenderJsonResponse($data, $code);
    }

    public function indexAction(){}

    public function headAction(){}

    public function postAction(){}

    public function putAction(){}

    public function deleteAction(){}

}
