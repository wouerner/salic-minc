<?php

namespace Application\Modules\PrestacaoContas\Service\RelatorioCumprimentoObjeto;


class RelatorioCumprimentoObjeto implements \MinC\Servico\IServicoRestZend
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

    public function listarRelatorioCumprimentoObjeto()
    {
        $idPronac = $this->request->idPronac;
        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        $projetos = new \Projetos();
        $dadosProjeto = $projetos->dadosProjeto(array('idPronac = ?' => $idPronac))->current();
//        $this->view->DadosProjeto = $dadosProjeto;
//        $this->view->idPronac = $idpronac;
        $tbCumprimentoObjeto = new \ComprovacaoObjeto_Model_DbTable_TbCumprimentoObjeto();
        $DadosRelatorio = $tbCumprimentoObjeto->buscarCumprimentoObjeto(array('idPronac = ?' => $idPronac))->toArray();

        if (!empty($DadosRelatorio)) {
//            $this->view->DadosRelatorio = $DadosRelatorio;
            $LocaisDeRealizacao = $projetos->buscarLocaisDeRealizacao($idPronac);
//            $this->view->LocaisDeRealizacao = $LocaisDeRealizacao;
            $PlanoDeDivulgacao = $projetos->buscarPlanoDeDivulgacao($idPronac);
//            $this->view->PlanoDeDivulgacao = $PlanoDeDivulgacao;

            $PlanoDistribuicaoProduto = new \Proposta_Model_DbTable_PlanoDistribuicaoProduto();
            $PlanoDeDistribuicao = $PlanoDistribuicaoProduto->buscarPlanoDeDistribuicao($idPronac);
//            $this->view->PlanoDeDistribuicao = $PlanoDeDistribuicao;

            $tbBeneficiarioProdutoCultural = new \tbBeneficiarioProdutoCultural();
            $PlanosCadastrados = $tbBeneficiarioProdutoCultural->buscarPlanosCadastrados($idPronac);
//            $this->view->PlanosCadastrados = $PlanosCadastrados;

            $DadosCompMetas = $projetos->buscarMetasComprovadas($idPronac);
//            $this->view->DadosCompMetas = $DadosCompMetas;

            $DadosItensOrcam = $projetos->buscarItensComprovados($idPronac);
//            $this->view->DadosItensOrcam = $DadosItensOrcam;

            $Arquivo = new \Arquivo();
            $dadosComprovantes = $Arquivo->buscarComprovantesExecucao($idPronac);
//            $this->view->DadosComprovantes = $dadosComprovantes;

            $tbTermoAceiteObra = new \ComprovacaoObjeto_Model_DbTable_TbTermoAceiteObra();
            $AceiteObras = $tbTermoAceiteObra->buscarTermoAceiteObraArquivos(array('idPronac=?'=>$idPronac));
//            $this->view->AceiteObras = $AceiteObras;

            $tbBensDoados = new \ComprovacaoObjeto_Model_DbTable_TbBensDoados();
            $BensCadastrados = $tbBensDoados->buscarBensCadastrados(array('a.idPronac=?'=>$idPronac), array('b.Descricao'));
//            $this->view->BensCadastrados = $BensCadastrados;

            if ($DadosRelatorio->siCumprimentoObjeto == 6) {
                $Usuario = new \UsuarioDAO();
                $nmUsuarioCadastrador = $Usuario->buscarUsuario($DadosRelatorio->idTecnicoAvaliador);
//                $this->view->TecnicoAvaliador = $nmUsuarioCadastrador;

                if ($DadosRelatorio->idChefiaImediata) {
                    $nmChefiaImediata = $Usuario->buscarUsuario($DadosRelatorio->idChefiaImediata);
//                    $this->view->ChefiaImediata = $nmChefiaImediata;
                }
            }

            return $DadosRelatorio;

            $isPermitidoVisualizarRelatorio = $this->view->usuarioInterno || in_array(
                    $dadosProjeto->situacao,
                    Projeto_Model_Situacao::obterSituacoesPermitidoVisualizarPrestacaoContas()
                );

            $auth = Zend_Auth::getInstance();
            $this->view->visualizarRelatorio =  isset($auth->getIdentity()->usu_codigo) ? true : $isPermitidoVisualizarRelatorio;

        }

    }
}
