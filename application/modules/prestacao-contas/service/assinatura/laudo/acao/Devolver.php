<?php

namespace Application\Modules\PrestacaoContas\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoDevolver;

class Devolver implements IAcaoDevolver
{

    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $idTipoDoAtoAdministrativo = $assinatura->modeloTbDocumentoAssinatura->getIdTipoDoAtoAdministrativo();
        $documentoAssinaturaDbTable = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $documentoAssinatura = $documentoAssinaturaDbTable->findBy(
            array(
                'IdPRONAC' => $assinatura->modeloTbAssinatura->getIdPronac(),
                'idTipoDoAtoAdministrativo' => $assinatura->modeloTbAtoAdministrativo->getIdTipoDoAto(),
                'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
            )
        );

        $tbPrestacaoContasXParecerDbTable = new \PrestacaoContas_Model_DbTable_TbPrestacaoContasXParecer();
        $tbPrestacaoContasXParecer = $tbPrestacaoContasXParecerDbTable->findBy([
            'idParecer' => $documentoAssinatura['idAtoDeGestao']
        ]);

        if ((int)$idTipoDoAtoAdministrativo == (int)\Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_PrestacaoContas_VINCULADAS) {
            $this->tratarDevolucaoParaVinculadas($tbPrestacaoContasXParecer['idPrestacaoContas']);
        } elseif ((int)$idTipoDoAtoAdministrativo == (int)\Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_PARECER_TECNICO_AJUSTE_DE_PROJETO) {
            $this->tratarDevolucaoDeAjustesDoProjeto($tbPrestacaoContasXParecer['idPrestacaoContas']);
        }
    }

    private function tratarDevolucaoParaVinculadas($idPrestacaoContas)
    {
        $atoAdministrativo = $this->assinatura->modeloTbAtoAdministrativo;

        $objTbProjetos = new Projeto_Model_DbTable_Projetos();
        $objOrgaos = new \Orgaos();
        $dadosProjeto = $objTbProjetos->findBy(array(
            'IdPRONAC' => $this->assinatura->modeloTbAssinatura->getIdPronac()
        ));
        $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($dadosProjeto['Orgao']);

        switch ($atoAdministrativo->getIdPerfilDoAssinante()) {
            case \Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER:
                $siEncaminhamento = \PrestacaoContas_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_ENVIADO_ANALISE_TECNICA;
                break;
            case \Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA:
                $siEncaminhamento = \PrestacaoContas_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_DEVOLVIDA_AO_COORDENADOR_DE_PARECER_PELO_PRESIDENTE;
                break;
            case \Autenticacao_Model_Grupos::DIRETOR_DEPARTAMENTO:
                $siEncaminhamento = \PrestacaoContas_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_DEVOLVIDA_AO_COORDENADOR_PELO_DIRETOR;

                $orgaoDestino = \Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
                if ($dadosOrgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SAV) {
                    $orgaoDestino = \Orgaos::ORGAO_SAV_DAP;
                }
                break;
        }

        if (isset($orgaoDestino)) {
            $objTbProjetos->alterarOrgao($orgaoDestino, $this->assinatura->modeloTbAssinatura->getIdPronac());
        }

        if($siEncaminhamento) {
            $dados = ['siEncaminhamento' => $siEncaminhamento];
            $where = "idPrestacaoContas = {$idPrestacaoContas}";
            $tbPrestacaoContas = new \PrestacaoContas_Model_DbTable_TbPrestacaoContas();
            $tbPrestacaoContas->update($dados, $where);
        }
    }

    private function tratarDevolucaoDeAjustesDoProjeto($idPrestacaoContas)
    {
        $atoAdministrativo = $this->assinatura->modeloTbAtoAdministrativo;
        switch ($atoAdministrativo->getIdPerfilDoAssinante()) {
            case \Autenticacao_Model_Grupos::COORDENADOR_ACOMPANHAMENTO:
            case \Autenticacao_Model_Grupos::COORDENADOR_GERAL_ACOMPANHAMENTO:
                $siEncaminhamento = \PrestacaoContas_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_ENVIADO_ANALISE_TECNICA;
                break;
        }

        if ($siEncaminhamento) {
            $dados = ['siEncaminhamento' => $siEncaminhamento];
            $where = "idPrestacaoContas = {$idPrestacaoContas}";
            $tbPrestacaoContas = new \PrestacaoContas_Model_DbTable_TbPrestacaoContas();
            $tbPrestacaoContas->update($dados, $where);
        }
    }
}