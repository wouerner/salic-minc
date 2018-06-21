<?php

namespace Application\Modules\Admissibilidade\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcao;

class Devolver implements IAcao, IAcaoDevolver
{
    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        $modeloTbAssinatura = $assinatura->modeloTbAssinatura;
        $modeloTbDespacho = $assinatura->modeloTbDespacho;

        $objTbDepacho = new \Proposta_Model_DbTable_TbDespacho();
        $objTbDepacho->devolverProjetoEncaminhadoParaAssinatura($modeloTbAssinatura->getIdPronac(), $modeloTbDespacho->getDespacho());

        $objTbProjetos = new Projeto_Model_DbTable_Projetos();
        $projeto = $objTbProjetos->findBy([ 'IdPRONAC' => $modeloTbAssinatura->getIdPronac() ]);

        $objOrgaos = new Orgaos();
        $orgaoSuperior = $objOrgaos->obterOrgaoSuperior($projeto['Orgao']);

        $orgaoDestino = Orgaos::ORGAO_SAV_DAP;
        if ($orgaoSuperior['Codigo'] == Orgaos::ORGAO_SUPERIOR_SEFIC) {
            $orgaoDestino = Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
        }

        $objTbProjetos = new Projeto_Model_DbTable_Projetos();
        $objTbProjetos->alterarOrgao($orgaoDestino, $modeloTbAssinatura->getIdPronac());
        $objProjetos = new Projetos();
        $objProjetos->alterarSituacao(
            $modeloTbAssinatura->getIdPronac(),
            null,
            Projeto_Model_Situacao::PROJETO_DEVOLVIDO_PARA_ENQUADRAMENTO,
            'Projeto encaminhado para nova avalia&ccedil;&atilde;o do enquadramento'
        );

        $objModelDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();
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

        $objModelDocumentoAssinatura->update($data, $where);
    }
}