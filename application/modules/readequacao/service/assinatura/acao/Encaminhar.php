<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoEncaminhar;

class Encaminhar implements IAcaoEncaminhar
{
    /**
     * @var \MinC\Assinatura\Model\Assinatura $assinatura
     */
    private $assinatura;

    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $this->assinatura = $assinatura;

        $tbReadequacaoXParecerDbTable = new \Readequacao_Model_DbTable_TbReadequacaoXParecer();
        $tbReadequacaoXParecer = $tbReadequacaoXParecerDbTable->findBy([
            'idParecer' => $assinatura->modeloTbDocumentoAssinatura->getIdAtoDeGestao()
        ]);

        $idTipoDoAtoAdministrativo = $assinatura->modeloTbDocumentoAssinatura->getIdTipoDoAtoAdministrativo();
        if ((int)$idTipoDoAtoAdministrativo == (int)\Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_READEQUACAO_VINCULADAS) {
            $this->atualizarSituacaoEncaminhamentoVinculadas($tbReadequacaoXParecer['idReadequacao']);
        } elseif ((int)$idTipoDoAtoAdministrativo == (int)\Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_AJUSTE_DE_PROJETO) {
            $this->atualizarSituacaoEncaminhamentoAjusteProjeto($tbReadequacaoXParecer['idReadequacao']);
        }
    }

    private function atualizarSituacaoEncaminhamentoVinculadas($idReadequacao)
    {
        $atoAdministrativo = $this->assinatura->modeloTbAtoAdministrativo;
        $objTbProjetos = new Projeto_Model_DbTable_Projetos();
        $objOrgaos = new \Orgaos();
        $dadosProjeto = $objTbProjetos->findBy(array(
            'IdPRONAC' => $this->assinatura->modeloTbAssinatura->getIdPronac()
        ));
        $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($dadosProjeto['Orgao']);

        switch ($atoAdministrativo->getIdPerfilDoAssinante()) {
            case \Autenticacao_Model_Grupos::PARECERISTA:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_DEVOLVIDO_ANALISE_TECNICA;
                break;
            case \Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_PRESIDENTE_DA_VINCULADA;
                break;
            case \Autenticacao_Model_Grupos::DIRETOR_DEPARTAMENTO:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_SECRETARIO;

                $orgaoDestino = \Orgaos::ORGAO_SUPERIOR_SEFIC;
                if ($dadosOrgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SAV) {
                    $orgaoDestino = \Orgaos::ORGAO_SUPERIOR_SAV;
                }
                break;
            case \Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_DIRETOR;

                $orgaoDestino = \Orgaos::ORGAO_SEFIC_DIC;
                if ($dadosOrgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SAV) {
                    $orgaoDestino = 682;
                }

                break;
        }

        if (isset($orgaoDestino)) {
            $objTbProjetos->alterarOrgao($orgaoDestino, $this->assinatura->modeloTbAssinatura->getIdPronac());
        }

        $dados = ['siEncaminhamento' => $siEncaminhamento];
        $where = "idReadequacao = {$idReadequacao}";
        $tbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $tbReadequacao->update($dados, $where);
    }

    private function atualizarSituacaoEncaminhamentoAjusteProjeto($idReadequacao)
    {
        $dados = [];
        $atoAdministrativo = $this->assinatura->modeloTbAtoAdministrativo;
        $objTbProjetos = new Projeto_Model_DbTable_Projetos();
        $objOrgaos = new \Orgaos();
        $dadosProjeto = $objTbProjetos->findBy(array(
            'IdPRONAC' => $this->assinatura->modeloTbAssinatura->getIdPronac()
        ));
//        $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($dadosProjeto['Orgao']);

        switch ($atoAdministrativo->getIdPerfilDoAssinante()) {
            case \Autenticacao_Model_Grupos::TECNICO_ACOMPANHAMENTO:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_DEVOLVIDA_COORDENADOR_TECNICO;
                break;
            case \Autenticacao_Model_Grupos::COORDENADOR_ACOMPANHAMENTO:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_COORDENADOR_GERAL;

                $objReadequacao_ReadequacoesController = new \Readequacao_ReadequacoesController();
                $objReadequacao_ReadequacoesController->encaminharOuFinalizarReadequacaoChecklist(
                    $idReadequacao
                );

                break;
            case \Autenticacao_Model_Grupos::COORDENADOR_GERAL_ACOMPANHAMENTO:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_FINALIZADA_SEM_PORTARIA;
                $dados['stEstado'] = \Readequacao_Model_DbTable_TbReadequacao::ST_ESTADO_FINALIZADO;
                break;
        }

        if (isset($orgaoDestino)) {
            $objTbProjetos->alterarOrgao(
                $orgaoDestino,
                $this->assinatura->modeloTbAssinatura->getIdPronac()
            );
        }

        $dados['siEncaminhamento'] = $siEncaminhamento;
        $where = "idReadequacao = {$idReadequacao}";

        $tbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $tbReadequacao->update($dados, $where);
    }
}