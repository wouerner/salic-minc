<?php
/**
 * Helper para verificar se projeto já foi assinado
 */

class Zend_View_Helper_IsProjetoJaAssinado
{
	/**
	 * Método para verificar se projeto já foi assinado na fase atual
	 * @access public
	 * @param integer $idPronac
	 * @param integer $idTipoDoAtoAdministrativo
	 * @param integer $quantidadeMinimaAssinaturas
	 * @return string
	 */
	public function IsProjetoJaAssinado($idPronac, $idTipoDoAtoAdministrativo, $idPerfilDoAssinante)
	{
        $objAssinatura = new Assinatura_Model_DbTable_TbAssinatura();
        $objDocumentoAssinatura = new Assinatura_Model_DbTable_TbDocumentoAssinatura();

        $documentoAssinatura = $objDocumentoAssinatura->isProjetoDisponivelParaAssinatura($idPronac, $idTipoDoAtoAdministrativo);
        
        if (!$documentoAssinatura) {
            return false;
        }
        
        $assinaturas = $objAssinatura->obterAssinaturas($idPronac, $idTipoDoAtoAdministrativo);
        // verificar quantidade de assinaturas, verificar se idOrdemAssinatura
        $GrupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
        $idOrgaoDoAssinante = $GrupoAtivo->codOrgao;
        $idPerfilDoAssinante = $GrupoAtivo->codGrupo;
        
        $orgao = new Orgaos();
        $codOrgaoSuperior = $orgao->obterOrgaoSuperior($idOrgaoDoAssinante)['Codigo'];
        
        $tbAtoAdministrativo = new Assinatura_Model_DbTable_TbAtoAdministrativo();
        $assinaturasNecessarias = $tbAtoAdministrativo->buscar(
            array(
                'idTipoDoAto = ?' => Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_ANALISE_INICIAL,
                'idOrgaoSuperiorDoAssinante = ?' => $codOrgaoSuperior
            )
        );
        
        $idUltimaAssinatura = (end($assinaturas)->idOrdemDaAssinatura) ? end($assinaturas)->idOrdemDaAssinatura : 0;
        
        if ($idUltimaAssinatura <= count($assinaturasNecessarias)) {
            $idProximaAssinatura = $idUltimaAssinatura + 1;
        } else {
            return true;
        }
        
        $dadosAssinaturaAtual = $assinaturasNecessarias[$idUltimaAssinatura];
        
        if ($dadosAssinaturaAtual['idOrgaoDoAssinante'] == $idOrgaoDoAssinante
            && $dadosAssinaturaAtual['idPerfilDoAssinante'] == $idPerfilDoAssinante) {
            return false;
        } else {
            return true;
        }
    }
}