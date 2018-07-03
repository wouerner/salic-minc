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

        $idDocumentoAssinatura = $this->assinatura->modeloTbAssinatura->getIdDocumentoAssinatura();
        $documentoAssinaturaDbTable = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $documentoAssinatura = $documentoAssinaturaDbTable->findBy([
            'idDocumentoAssinatura' => $idDocumentoAssinatura
        ]);

        $tbReadequacaoXParecerDbTable = new \Readequacao_Model_DbTable_TbReadequacaoXParecer();
        $tbReadequacaoXParecer = $tbReadequacaoXParecerDbTable->findBy([
            'idParecer' => $documentoAssinatura['idAtoDeGestao']
        ]);
        $this->atualizarSituacaoEncaminhamento($tbReadequacaoXParecer['idReadequacao']);
    }

    private function atualizarSituacaoEncaminhamento($idReadequacao) {

        $atoAdministrativo = $this->assinatura->modeloTbAtoAdministrativo;
        switch ($atoAdministrativo->getIdPerfilDoAssinante()) {
            case \Autenticacao_Model_Grupos::PARECERISTA:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_DEVOLVIDO_ANALISE_TECNICA;
                break;
            case \Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_PRESIDENTE_DA_VINCULADA;
                break;
            case \Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_ENCAMINHADA_AO_DIRETOR;

                $objOrgaos = new \Orgaos();
                $objTbProjetos = new Projeto_Model_DbTable_Projetos();
                $dadosProjeto = $objTbProjetos->findBy(array(
                    'IdPRONAC' => $this->assinatura->modeloTbAssinatura->getIdPronac()
                ));
                $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($dadosProjeto['Orgao']);
                $orgaoDestino = \Orgaos::ORGAO_SEFIC_DIC;
                if ($dadosOrgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SAV) {
                    $orgaoDestino = 682;
                }
                $objTbProjetos->alterarOrgao($orgaoDestino, $this->assinatura->modeloTbAssinatura->getIdPronac());
                break;
        }
        $dados = ['siEncaminhamento' => $siEncaminhamento];
        $where = "idReadequacao = {$idReadequacao}";
        $tbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $tbReadequacao->update($dados, $where);
    }
}