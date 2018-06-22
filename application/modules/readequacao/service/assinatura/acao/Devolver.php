<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcao;
use MinC\Assinatura\Acao\IAcaoDevolver;

class Devolver implements IAcao, IAcaoDevolver
{
    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        // public function devolverProjeto($motivoDevolucao)
//        $objProjetosDbTable = new \Projeto_Model_DbTable_Projetos();
//        $projeto = $objProjetosDbTable->findBy(array(
//            'IdPRONAC' => $this->idPronac
//        ));
//
//        $objTbDepacho = new \Proposta_Model_DbTable_TbDespacho();
//        $objTbDepacho->devolverProjetoEncaminhadoParaAssinatura($this->idPronac, $motivoDevolucao);
//
//        $objOrgaos = new \Orgaos();
//        $orgaoSuperior = $objOrgaos->obterOrgaoSuperior($projeto['Orgao']);
//
//        $orgaoDestino = \Orgaos::ORGAO_SAV_DAP;
//        if ($orgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SEFIC) {
//            $orgaoDestino = \Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
//        }
//
//        $objProjetosDbTable->alterarOrgao($orgaoDestino, $this->idPronac);
//        $objProjetos = new \Projetos();
//        $objProjetos->alterarSituacao(
//            $this->idPronac,
//            null,
//            \Projeto_Model_Situacao::PROJETO_DEVOLVIDO_PARA_ENQUADRAMENTO,
//            'Projeto encaminhado para nova avalia&ccedil;&atilde;o do readequacao'
//        );
//
//        $objModelDocumentoAssinatura = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
//        $data = array(
//            'cdSituacao' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_FECHADO_PARA_ASSINATURA,
//            'stEstado' => \Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_INATIVO
//        );
//        $where = array(
//            'IdPRONAC = ?' => $this->idPronac,
//            'idTipoDoAtoAdministrativo = ?' => $this->idTipoDoAtoAdministrativo,
//            'cdSituacao = ?' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
//            'stEstado = ?' => \Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
//        );
//
//        $objModelDocumentoAssinatura->update($data, $where);
    }
}