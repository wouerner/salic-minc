<?php

namespace Application\Modules\Readequacao\Service\Assinatura;

use MinC\Servico\IServico;

class ReadequacaoAssinatura implements IServico
{
    private $grupoAtivo;
    private $auth;
    private $idTipoDoAto;

    private $idTiposAtoAdministrativos = [
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_PLANILHA_ORCAMENTARIA => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_PLANILHA_ORCAMENTARIA,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_RAZAO_SOCIAL => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_ALTERACAO_RAZAO_SOCIAL,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_AGENCIA_BANCARIA => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_AGENCIA_BANCARIA,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_SINOPSE_OBRA => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_SINOPSE_OBRA,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_IMPACTO_AMBIENTAL => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_IMPACTO_AMBIENTAL,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_ESPECIFICACAO_TECNICA => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_ESPECIFICACAO_TECNICA,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_ESTRATEGIA_EXECUCAO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_ESTRATEGIA_EXECUCAO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_LOCAL_REALIZACAO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_LOCAL_REALIZACAO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_ALTERACAO_PROPONENTE => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_ALTERACAO_PROPONENTE,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_PLANO_DISTRIBUICAO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_PLANO_DISTRIBUICAO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_NOME_PROJETO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_NOME_PROJETO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_PERIODO_EXECUCAO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_PERIODO_EXECUCAO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_PLANO_DIVULGACAO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_PLANO_DIVULGACAO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_RESUMO_PROJETO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_RESUMO_PROJETO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_OBJETIVOS => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_OBJETIVOS,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_JUSTIFICATIVA => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_JUSTIFICATIVA,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_ACESSIBILIDADE => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_ACESSIBILIDADE,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_DEMOCRATIZACAO_ACESSO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_DEMOCRATIZACAO_ACESSO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_ETAPAS_TRABALHO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_ETAPAS_TRABALHO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_FICHA_TECNICA => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_FICHA_TECNICA,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_SALDO_APLICACAO => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_SALDO_APLICACAO,
        \Readequacao_Model_DbTable_TbReadequacao::TIPO_READEQUACAO_TRANSFERENCIA_RECURSOS => \Assinatura_Model_DbTable_TbAssinatura::TIPO_ATO_READEQUACAO_TRANSFERENCIA_RECURSOS
    ];
    
    public function __construct(
        $grupoAtivo,
        $auth
    ) {
        $this->grupoAtivo = $grupoAtivo;
        $this->auth = $auth;
    }    
    
    public function obterAssinaturas()
    {
        $tbAssinaturaDbTable = new \Assinatura_Model_DbTable_TbAssinatura();
        $tbAssinaturaDbTable->preencherModeloAtoAdministrativo([
            'idOrgaoDoAssinante' => $this->grupoAtivo->codOrgao,
            'idPerfilDoAssinante' => $this->grupoAtivo->codGrupo,
            'idOrgaoSuperiorDoAssinante' => $this->auth->getIdentity()->usu_org_max_superior,
            'idTipoDoAto' => array_values($this->idTiposAtoAdministrativos)
        ]);

        $tbReadequacaoDbTable = new \Readequacao_Model_DbTable_TbReadequacao();
        
        return $tbReadequacaoDbTable->obterAssinaturasReadequacaoDisponiveis($tbAssinaturaDbTable);
    }

    public function obterAtoAdministrativoPorTipoReadequacao($idTipoReadequacao)
    {
        if (array_key_exists($idTipoReadequacao, $this->idTiposAtoAdministrativos)) {
            return $this->idTiposAtoAdministrativos[$idTipoReadequacao];
        }
    }

    public function obterAtosAdministativos()
    {
        return $this->idTiposAtoAdministrativos;
    }
}
