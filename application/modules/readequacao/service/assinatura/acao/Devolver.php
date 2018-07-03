<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoDevolver;

class Devolver implements IAcaoDevolver
{

    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $modeloTbAssinatura = $assinatura->modeloTbAssinatura;
        $modeloTbDespacho = $assinatura->modeloTbDespacho;

        $objTbDepacho = new \Proposta_Model_DbTable_TbDespacho();
        $objTbDepacho->devolverProjetoEncaminhadoParaAssinatura($modeloTbAssinatura->getIdPronac(), $modeloTbDespacho->getDespacho());

        $objDbTableDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $data = array(
            'cdSituacao' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_FECHADO_PARA_ASSINATURA,
            'stEstado' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_INATIVO
        );
        $where = array(
            'IdPRONAC = ?' => $modeloTbAssinatura->getIdPronac(),
            'idTipoDoAtoAdministrativo = ?' => $this->idTipoDoAtoAdministrativo,
            'cdSituacao = ?' => Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
            'stEstado = ?' => Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
        );

        $objDbTableDocumentoAssinatura->update($data, $where);


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

    private function atualizarSituacaoEncaminhamento($idReadequacao)
    {
        $atoAdministrativo = $this->assinatura->modeloTbAtoAdministrativo;
        switch ($atoAdministrativo->getIdPerfilDoAssinante()) {
            case \Autenticacao_Model_Grupos::COORDENADOR_DE_PARECER:
                $siEncaminhamento = \Readequacao_Model_tbTipoEncaminhamento::SI_ENCAMINHAMENTO_ENVIADO_ANALISE_TECNICA;
                break;
        }
        $dados = ['siEncaminhamento' => $siEncaminhamento];
        $where = "idReadequacao = {$idReadequacao}";
        $tbReadequacao = new \Readequacao_Model_DbTable_TbReadequacao();
        $tbReadequacao->update($dados, $where);
    }
}