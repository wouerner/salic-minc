<?php

namespace Application\Modules\Readequacao\Service\Assinatura\Acao;

use MinC\Assinatura\Acao\IAcaoFinalizar;

class Finalizar implements IAcaoFinalizar
{
    public function executar(\MinC\Assinatura\Model\Assinatura $assinatura)
    {
        //        $objProjetos = new \Projetos();
//        $objProjetos->alterarSituacao(
//            $this->idPronac,
//            null,
//            \Projeto_Model_Situacao::PROJETO_APROVADO_AGUARDANDO_ANALISE_DOCUMENTAL,
//            'Projeto aprovado - aguardando an&aacute;lise documental'
//        );
//
//        $objTbProjetos = new \Projeto_Model_DbTable_Projetos();
//        $dadosProjeto = $objTbProjetos->findBy(array(
//            'IdPRONAC' => $this->idPronac
//        ));
//
//        $orgaoDestino = \Orgaos::ORGAO_SAV_DAP;
//        $objOrgaos = new \Orgaos();
//        $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($dadosProjeto['Orgao']);
//
//        if ($dadosOrgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SEFIC) {
//            $orgaoDestino = \Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
//        }
//        $objTbProjetos->alterarOrgao($orgaoDestino, $this->idPronac);
//
//        $enquadramento = new \Admissibilidade_Model_Enquadramento();
//        $dadosEnquadramento = $enquadramento->obterEnquadramentoPorProjeto($this->idPronac, $dadosProjeto['AnoProjeto'], $dadosProjeto['Sequencial']);
//
//        $objModelDocumentoAssinatura = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
//        $data = [
//            'cdSituacao' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_FECHADO_PARA_ASSINATURA
//        ];
//        $where = [
//            'IdPRONAC = ?' => $this->idPronac,
//            'idTipoDoAtoAdministrativo = ?' => $this->idTipoDoAtoAdministrativo,
//            'idAtoDeGestao = ?' => $dadosEnquadramento['IdEnquadramento'],
//            'cdSituacao = ?' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
//            'stEstado = ?' => \Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
//        ];
//        $objModelDocumentoAssinatura->update($data, $where);
//
//        $valoresProjeto = $objTbProjetos->obterValoresProjeto($this->idPronac);
//        $auth = \Zend_Auth::getInstance();
//        $objAprovacao = new \Aprovacao();
//        $idAprovacao = $objAprovacao->inserir([
//            'IdPRONAC' => $this->idPronac,
//            'AnoProjeto' => $dadosProjeto['AnoProjeto'],
//            'Sequencial' => $dadosProjeto['Sequencial'],
//            'TipoAprovacao' => 1,
//            'dtAprovacao' => $objTbProjetos->getExpressionDate(),
//            'ResumoAprovacao' => $dadosEnquadramento['Observacao'],
//            'AprovadoReal' => $valoresProjeto['ValorProposta'],
//            'Logon' => $auth->getIdentity()->usu_codigo,
//        ]);
//
//        $idTecnico = new \Zend_Db_Expr("sac.dbo.fnPegarTecnico(110, {$orgaoDestino}, 3)");
//
//        $tblVerificaProjeto = new \tbVerificaProjeto();
//        $dadosVP['idPronac'] = $this->idPronac;
//        $dadosVP['idOrgao'] = $orgaoDestino;
//        $dadosVP['idAprovacao'] = $idAprovacao;
//        $dadosVP['idUsuario'] = $idTecnico;
//        $dadosVP['stAnaliseProjeto'] = 1;
//        $dadosVP['dtRecebido'] = $tblVerificaProjeto->getExpressionDate();
//        $dadosVP['stAtivo'] = 1;
//        $tblVerificaProjeto->inserir($dadosVP);
    }

}