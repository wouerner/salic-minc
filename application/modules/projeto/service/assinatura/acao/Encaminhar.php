<?php

namespace Application\Modules\Projeto\Service\Assinatura\Acao;

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

        $tbProjetoXParecerDbTable = new \Projeto_Model_DbTable_TbProjetoXParecer();
        $tbProjetoXParecer = $tbProjetoXParecerDbTable->findBy([
            'idParecer' => $assinatura->modeloTbDocumentoAssinatura->getIdAtoDeGestao()
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
            case \Autenticacao_Model_Grupos::PARECERISTA:
                $siEncaminhamento = \Projeto_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_DEVOLVIDO_ANALISE_TECNICA;
                break;
            case \Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER:
                $siEncaminhamento = \Projeto_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_PRESIDENTE_DA_VINCULADA;
                break;
            case \Autenticacao_Model_Grupos::DIRETOR_DEPARTAMENTO:
                $siEncaminhamento = \Projeto_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_SECRETARIO;

                $orgaoDestino = \Orgaos::ORGAO_SUPERIOR_SEFIC;
                if ($dadosOrgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SAV) {
                    $orgaoDestino = \Orgaos::ORGAO_SUPERIOR_SAV;
                }
                break;
            case \Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA:
                $siEncaminhamento = \Projeto_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_DIRETOR;

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
        $where = "idProjeto = {$idProjeto}";
        $tbProjeto = new \Projeto_Model_DbTable_TbProjeto();
        $tbProjeto->update($dados, $where);
    }
}