<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoDevolver;

class Devolver implements IAcaoDevolver
{

    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $tbReadequacaoXParecerDbTable = new \Readequacao_Model_DbTable_TbReadequacaoXParecer();
        $tbReadequacaoXParecer = $tbReadequacaoXParecerDbTable->findBy([
            'idParecer' => $assinatura->modeloTbAtoAdministrativo->getIdTipoDoAto()
        ]);

        $this->atualizarSituacaoEncaminhamento($tbReadequacaoXParecer['idReadequacao']);
    }

    private function atualizarSituacaoEncaminhamento($idReadequacao)
    {
        $atoAdministrativo = $this->assinatura->modeloTbAtoAdministrativo;
        switch ($atoAdministrativo->getIdPerfilDoAssinante()) {
            case \Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_ENVIADO_ANALISE_TECNICA;
                break;
            case \Autenticacao_Model_Grupos::PRESIDENTE_DE_VINCULADA:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_SOLICITACAO_DEVOLVIDA_AO_COORDENADOR_DE_PARECER_PELO_PRESIDENTE;
                break;
        }
        $dados = ['siEncaminhamento' => $siEncaminhamento];
        $where = "idReadequacao = {$idReadequacao}";
        $tbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $tbReadequacao->update($dados, $where);
    }
}