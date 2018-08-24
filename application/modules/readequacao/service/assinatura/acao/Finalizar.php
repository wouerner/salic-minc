<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoFinalizar;

class Finalizar implements IAcaoFinalizar
{
    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $tbReadequacaoXParecerDbTable = new \Readequacao_Model_DbTable_TbReadequacaoXParecer();
        $tbReadequacaoXParecer = $tbReadequacaoXParecerDbTable->findBy([
            'idParecer' => $assinatura->modeloTbDocumentoAssinatura->getIdAtoDeGestao()
        ]);

        require_once APPLICATION_PATH . "/modules/readequacao/controllers/ReadequacoesController.php";

        $objReadequacao_ReadequacoesController = new \Readequacao_ReadequacoesController(
            $assinatura->request,
            $assinatura->response
        );
        $objReadequacao_ReadequacoesController->encaminharOuFinalizarReadequacaoChecklist(
            $tbReadequacaoXParecer['idReadequacao']
        );

        $objProjetos = new \Projetos();
        $objProjetos->alterarProvidenciaTomada(
            $this->idPronac,
            'Readequa&ccedil;&atilde;o analisada pela &aacute;rea t&eacute;cnica'
        );

        $idTipoDoAtoAdministrativo = $assinatura->modeloTbDocumentoAssinatura->getIdTipoDoAtoAdministrativo();
        if ((int)$idTipoDoAtoAdministrativo === (int)\Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_READEQUACAO_VINCULADAS) {
            $this->alterarDadosProjetoParecerTecnicoReadequacao($assinatura);
        }
    }

    private function alterarDadosProjetoParecerTecnicoReadequacao(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $objTbProjetos = new \Projeto_Model_DbTable_Projetos();
        $objOrgaos = new \Orgaos();
        $dadosProjeto = $objTbProjetos->findBy(array(
            'IdPRONAC' => $assinatura->modeloTbAssinatura->getIdPronac()
        ));

        $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($dadosProjeto['Orgao']);
        if (count($dadosOrgaoSuperior) > 0) {
            if ((int)$dadosOrgaoSuperior['Codigo'] == (int)\Orgaos::ORGAO_SUPERIOR_SAV) {
                $orgaoDestino = (int)\Orgaos::ORGAO_SAV_DAP;
            } elseif ((int)$dadosOrgaoSuperior['Codigo'] == (int)\Orgaos::ORGAO_SUPERIOR_SEFIC) {
                $orgaoDestino = (int)\Orgaos::ORGAO_GEAR_SACAV;
            }

            if (isset($orgaoDestino)) {
                $objTbProjetos->alterarOrgao(
                    $orgaoDestino,
                    $assinatura->modeloTbAssinatura->getIdPronac()
                );
            }
        }

        $tbReadequacaoXParecerDbTable = new \Readequacao_Model_DbTable_TbReadequacaoXParecer();
        $tbReadequacaoXParecer = $tbReadequacaoXParecerDbTable->findBy([
            'idParecer' => $assinatura->modeloTbDocumentoAssinatura->getIdAtoDeGestao()
        ]);
        $idReadequacao = $tbReadequacaoXParecer['idReadequacao'];

        $dados = [
            'stEstado' => (int)\Readequacao_Model_DbTable_TbReadequacao::ST_ESTADO_FINALIZADO,
            'siEncaminhamento' => (int)\Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_CHECKLIST_PUBLICACAO,
        ];
        $where = "idReadequacao = {$idReadequacao}";
        $tbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $tbReadequacao->update($dados, $where);
    }
}
