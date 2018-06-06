<?php

namespace MinC\Assinatura\Servico;

use Mockery\Exception;

class DocumentoAssinatura implements IServico
{

    public function registrarDocumentoAssinatura(\Assinatura_Model_TbDocumentoAssinatura $objModelDocumentoAssinatura)
    {
        if (!$objModelDocumentoAssinatura->getIdPRONAC()) {
            throw new Exception("Identificador do Projeto n&atilde;o informado.");
        }

        $objTbProjetos = new \Projeto_Model_DbTable_Projetos();
        $dadosProjeto = $objTbProjetos->findBy([
            'IdPRONAC' => $objModelDocumentoAssinatura->getIdPRONAC()
        ]);

        if (!$dadosProjeto) {
            throw new Exception("Projeto n&atilde;o encontrado.");
        }

        $objModelDocumentoAssinatura = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $isProjetoDisponivelParaAssinatura = $objModelDocumentoAssinatura->isProjetoDisponivelParaAssinatura(
            $objModelDocumentoAssinatura->getIdPRONAC(),
            $objModelDocumentoAssinatura->getIdTipoDoAtoAdministrativo()
        );

        if ($isProjetoDisponivelParaAssinatura) {
            throw new Exception("Atualmente o Projeto Cultural j&aacute; est&aacute; dispon&iacute;vel para assinatura");
        }

        $objDocumentoAssinaturaMapper = new \Assinatura_Model_TbDocumentoAssinaturaMapper();
        $objDocumentoAssinaturaMapper->save($objModelDocumentoAssinatura);
    }
}