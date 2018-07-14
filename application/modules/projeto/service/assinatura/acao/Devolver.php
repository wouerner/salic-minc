<?php

namespace Application\Modules\Projeto\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoDevolver;

class Devolver implements IAcaoDevolver
{

    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $documentoAssinaturaDbTable = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $documentoAssinatura = $documentoAssinaturaDbTable->findBy(
            array(
                'IdPRONAC' => $assinatura->modeloTbAssinatura->getIdPronac(),
                'idTipoDoAtoAdministrativo' => $assinatura->modeloTbAtoAdministrativo->getIdTipoDoAto(),
                'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
                'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
            )
        );

        $tbProjetoXParecerDbTable = new \Projeto_Model_DbTable_TbProjetoXParecer();
        $tbProjetoXParecer = $tbProjetoXParecerDbTable->findBy([
            'idParecer' => $documentoAssinatura['idAtoDeGestao']
        ]);

        $this->atualizarSituacaoEncaminhamento($tbProjetoXParecer['idProjeto']);
    }

    private function atualizarSituacaoEncaminhamento($idProjeto)
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
                $siEncaminhamento = \Projeto_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_ENVIADO_ANALISE_TECNICA;
                break;
            case \Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA:
                $siEncaminhamento = \Projeto_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_DEVOLVIDA_AO_COORDENADOR_DE_PARECER_PELO_PRESIDENTE;
                break;
            case \Autenticacao_Model_Grupos::DIRETOR_DEPARTAMENTO:
                $siEncaminhamento = \Projeto_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_DEVOLVIDA_AO_COORDENADOR_PELO_DIRETOR;

                $orgaoDestino = \Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
                if ($dadosOrgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SAV) {
                    $orgaoDestino = \Orgaos::ORGAO_SAV_DAP;
                }
                break;
        }

        if(isset($orgaoDestino)) {
            $objTbProjetos->alterarOrgao($orgaoDestino, $this->assinatura->modeloTbAssinatura->getIdPronac());
        }

        $dados = ['siEncaminhamento' => $siEncaminhamento];
        $where = "idProjeto = {$idProjeto}";
        $tbProjeto = new \Projeto_Model_DbTable_TbProjeto();
        $tbProjeto->update($dados, $where);
    }
}