<?php

namespace Application\Modules\Projeto\Service\Proponente;

class Proponente
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

    public function buscar($idPronac)
    {
        $tabelaDbTabela = new \Foo_Model_DbTable_Tabela();
        $where = [
            'Codigo' => $idPronac
        ];

        return $tabelaDbTabela->findBy($where);
    }
    
    public function buscarDadosAgenteProponente()
    {
        $parametros = $this->request->getParams();
        if (isset($params['idPronac'])) {

            $idPronac = $params['idPronac'];
            if (strlen($idPronac) > 7) {
                $idPronac = Seguranca::dencrypt($idPronac);
            }

            $dados = [];
            $proponente = [];
            $dados['idPronac'] = (int) $idPronac;
            if (is_numeric($dados['idPronac'])) {
                if (isset($dados['idPronac'])) {
                    $idPronac = $dados['idPronac'];
                    //UC 13 - MANTER MENSAGENS (Habilitar o menu superior)
                   $proponente['idPronac'] = $idPronac;
                   $proponente['menumsg'] = 'true';
                }
                $rst = ConsultarDadosProjetoDAO::obterDadosProjeto($dados);
                if (count($rst) > 0) {
                   $proponente['projeto'] = $rst[0];
                   $proponente['idpronac'] = $idPronac;
                   $proponente['idprojeto'] = $rst[0]->idProjeto;
                    if ($rst[0]->codSituacao == 'E12' || $rst[0]->codSituacao == 'E13' || 
                        $rst[0]->codSituacao == 'E15' || $rst[0]->codSituacao == 'E50' || 
                        $rst[0]->codSituacao == 'E59' || $rst[0]->codSituacao == 'E61' || 
                        $rst[0]->codSituacao == 'E62') {
                       $proponente['menuCompExec'] = 'true';
                    }

                    $geral = new ProponenteDAO();
                    $tblProjetos = new Projetos();

                    $arrBusca['IdPronac = ?']=$idPronac;
                    $rsProjeto = $tblProjetos->buscar($arrBusca)->current();
                    $idPreProjeto = 0;

                    if (!empty($rsProjeto->idProjeto)) {
                        $idPreProjeto = $rsProjeto->idProjeto;
                    }

                    $pronac = $rsProjeto->AnoProjeto.$rsProjeto->Sequencial;
                    $dadosProjeto = $geral->execPaProponente($idPronac);
                   $proponente['dados'] = $dadosProjeto;

                    $verificarHabilitado = $geral->verificarHabilitado($pronac);
                    if (count($verificarHabilitado)>0) {
                       $proponente['ProponenteInabilitado'] = 1;
                    }

                    $tbemail = $geral->buscarEmail($idPronac);
                   $proponente['email'] = $tbemail;

                    $tbtelefone = $geral->buscarTelefone($idPronac);
                   $proponente['telefone'] = $tbtelefone;

                    $tblAgente = new Agente_Model_DbTable_Agentes();
                    $rsAgente = $tblAgente->buscar(array('CNPJCPF=?'=>$dadosProjeto[0]->CNPJCPF))->current();

                    $rsDirigentes = $tblAgente->buscarDirigentes(array('v.idVinculoPrincipal =?'=>$rsAgente->idAgente,'n.Status =?'=>0), array('n.Descricao ASC'));
                   $proponente['dirigentes'] = $rsDirigentes;

                    $tbProcuradorProjeto = new tbProcuradorProjeto();
                   $proponente['procuradores'] = $tbProcuradorProjeto->buscarProcuradorDoProjeto($idPronac);

                    //========== inicio codigo mandato dirigente ================
                    $arrMandatos = array();

                    if (!empty($this->idPreProjeto)) {
                        $preProjeto = new Proposta_Model_DbTable_PreProjeto();
                        $Empresa = $preProjeto->buscar(array('idPreProjeto = ?' => $this->idPreProjeto))->current();
                        $idEmpresa = $Empresa->idAgente;

                        $tbDirigenteMandato = new tbAgentesxVerificacao();
                        foreach ($rsDirigentes as $dirigente) {
                            $rsMandato = $tbDirigenteMandato->listarMandato(array('idEmpresa = ?' => $idEmpresa, 'idDirigente = ?' => $dirigente->idAgente,'stMandato = ?' => 0));
                            $arrMandatos[$dirigente->NomeDirigente] = $rsMandato;
                        }
                    }
                   $proponente['mandatos'] = $arrMandatos;
                   return $proponente;
                } else {
                    // parent::message("Nenhum projeto encontrado com o n&uacute;mero de Pronac informado.", "listarprojetos/listarprojetos", "ERROR");
                }
            } else {
                // parent::message("N&uacute;mero Pronac inv&aacute;lido!", "listarprojetos/listarprojetos", "ERROR");
            }
        } else {
            // parent::message("N&uacute;mero Pronac inv&aacute;lido!", "listarprojetos/listarprojetos", "ERROR");
        }
    }
}