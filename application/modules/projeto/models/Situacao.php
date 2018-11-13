<?php

class Projeto_Model_Situacao extends MinC_Db_Table_Abstract
{
    protected $_name = 'Situacao';
    protected $_schema = 'sac';
    protected $_primary = 'Codigo';

    const PROPOSTA_TRANSFORMADA_EM_PROJETO = 'B01';
    const PROJETO_ENQUADRADO_COM_RECURSO = 'B03';
    const PROJETO_EM_AVALIACAO_DOCUMENTAL = 'B04';
    const PROJETO_DEVOLVIDO_PARA_ENQUADRAMENTO = 'B05';
    const ENCAMINHADO_PARA_ANALISE_TECNICA = 'B11';
    const PROJETO_ADEQUADO_A_REALIDADE_DE_EXECUCAO = 'B20';
    const AGUARDANDO_ELABORACAO_DE_PORTARIA_DE_PRORROGACAO = 'D22';
    const PROJETO_APROVADO_AGUARDANDO_ANALISE_DOCUMENTAL = 'D03';
    const PROJETO_ENCAMINHADO_PARA_INCLUSAO_EM_PORTARIA = 'D27';
    const ENCAMINHADO_PARA_INCLUSAO_EM_PORTARIA_COMPLEMENTACAO = 'D28';
    const ENCAMINHADO_PARA_INCLUSAO_EM_PORTARIA_REDUCAO = 'D29';
    const PARECER_TECNICO_EMITIDO = 'C20';
    const PROJETO_LIBERADO_PARA_AJUSTES = 'E90';
    const ANALISE_TECNICA = 'D51';
    const PROJETO_ENCAMINHADO_PARA_HOMOLOGACAO = 'D52';
    const PROJETO_APRECIADO_PELA_CNIC = 'D50';
    const INDEFERIDO_NAO_ENQUADRAMENTO_NOS_OBJETIVOS = 'A14';
    const INDEFERIDO_PROJETO_JA_REALIZADO = 'A16';
    const INDEFERIDO_NAO_ATENDIMENTO_A_DILIGENCIA = 'A17';
    const INDEFERIDO_PROJETO_EM_DUPLICIDADE = 'A20';
    const INDEFERIDO_SOMATORIO_DOS_PROJETOS_EXCEDE_O_LIMITE_PESSOA_FISICA = 'A23';
    const INDEFERIDO_SOMATORIO_DOS_PROJETOS_EXCEDE_O_LIMITE_PESSOA_JURIDICA = 'A24';
    const INDEFERIDO_50_PORCENTO_DE_CORTE_VALOR_SOLICITADO = 'A41';
    const PROJETO_ENQUADRADO = 'B02';
    const READEQUACAO_DO_PROJETO_APROVADA_AGUARDANDO_ANALISE_DOCUMENTAL = 'D02';
    const PROJETO_INDEFERIDO = 'D14';
    const AUTORIZADA_CAPTACAO_RESIDUAL_DOS_RECURSOS = 'E12';
    const ARQUIVADO_SOLICITACAO_DE_DESISTENCIA_DO_PROPONENTE = 'A13';
    const ARQUIVADO_INSUFICIENCIA_DE_RECURSOS_2 = 'A18';
    const ARQUIVADO_NAO_ENQUADRAMENTO_NO_AMBITO_DA_SMAC = 'A26';
    const ARQUIVADO_PROJETO_ACIMA_DO_TETO_ADOTADO_PELA_CNIC = 'A40';
    const PROJETO_ARQUIVADO_NAO_ATENDIMENTO_A_DILIGENCIA_TECNICA = 'A42';
    const ARQUIVADO_ART_14_DECRETO_LEI_200 = 'E04';
    const PROJETO_ENCERRADO_POR_EXCESSO_DE_PRAZO_SEM_CAPTACAO = 'E16';
    const ARQUIVADO_POR_TER_24_MESES_APROVACAO_SEM_CAPTACAO_DE_RECURSOS = 'E36';
    const PROJETO_ARQUIVADO_RECURSOS_TRANSFERIDOS_FUNARTE = 'E47';
    const PROJETO_ARQUIVADO_RECURSOS_TRANSFERIDOS = 'E49';
    const PROJETO_ARQUIVADO_POR_EXCESSO_DE_PRAZO_SEM_CAPTACAO = 'E63';
    const PROJETO_ARQUIVADO_CAPTACAO_EXECUCAO_ENCERRADAS = 'E64';
    const PROJETO_ARQUIVADO_SOLICITACAO_DE_ARQUIVAMENTO_DE_PROJETO_DE_INCENTIVO_FISCAL_FEITO_PELO_PROPONENTE = 'E65';
    const AGUARDA_REVISAO_DA_DIRETORIA = 'E93';
    const ARQUIVADO_NAO_CUMPRIMENTO_DE_DILIGENCIA = 'G16';
    const SOLICITACAO_DE_ARQUIVAMENTO_FEITO_PELO_PROPONENTE = 'G17';
    const PROJETO_ARQUIVADO_DECURSO_DE_PRAZO = 'G25';
    const PROJETO_ARQUIVADO_NAO_ATENDIMENTO_DOCUMENTAL = 'G26';
    const ARQUIVADO_NAO_ENQUADRADO_NAS_PRIORIDADES_DO_FNC = 'G29';
    const ARQUIVADO_INSUFICIENCIA_DE_RECURSOS_1 = 'G30';
    const PROJETO_ARQUIVADO_SOLICITACAO_DE_ARQUIVAMENTO_DE_PROJETO_DE_EDITAL_FNC_FEITA_PELO_PROPONENTE = 'G56';
    const PROJETO_ARQUIVADO = 'K00';
    const ARQUIVADO_POR_EXCESSO_DE_PROJETOS_APRESENTADOS = 'K01';
    const ARQUIVADO_POR_INCAPACIDADE_TECNICA_DO_PROPONENTE = 'K02';
    const BOLSA_VIRTUOSE_ARQUIVADO_ANALISE_DOCUMENTAL = 'K04';
    const BOLSA_VIRTUOSE_ARQUIVADO_ANALISE_DO_MERITO = 'K05';
    const PROJETO_HOMOLOGADO = 'D51';

    const AGUARDA_ANALISE_FINANCEIRA = 'E68';
    const APRESENTOU_PRESTACAO_DE_CONTAS = 'E24';
    const AGUARDANDO_LAUDO_FINAL = 'E77';
    const AGUARDANDO_REVISAO_DE_RESULTADOS = 'E92';

    const PC_APROVADA_COM_CERTIFICACAO_DE_QUALIDADE_GESTAO = "L01";
    const PC_APROVADA_SEM_CERTIFICACAO_DE_QUALIDADE_GESTAO = "L02";
    const PC_APROVADA_COM_RESSALVA_FORMAL_E_SEM_PREJUIZO = "L03";
    const PC_APROVADA_COM_RESSALVA_MATERIAL_OU_PREJUIZO = "L04";
    const PC_DESAPROVADA_COM_NOTIFICACAO_DE_COBRANCA = "L05";
    const PC_DESAPROVADA_COM_INDICATIVO_PARA_TCE = "L06";
    const RECOLHIMENTO_INTEGRAL_DOS_RECURSOS = "L07";
    const PC_APROVADA_APOS_RESSARCIMENTO_AO_ERARIO = "L08";
    const DEBITO_PARCELADO = "L09";
    const PC_REPROVADA_INABILITACAO_PRESCRITA = "L10";
    const PC_REPROVADA_INABILITACAO_SUSPENSA = "L11";

    public static function obterSituacoesProjetoArquivado()
    {
        return [
            self::ARQUIVADO_SOLICITACAO_DE_DESISTENCIA_DO_PROPONENTE,
            self::PROJETO_ARQUIVADO_NAO_ATENDIMENTO_A_DILIGENCIA_TECNICA,
            self::PROJETO_ENCERRADO_POR_EXCESSO_DE_PRAZO_SEM_CAPTACAO,
            self::ARQUIVADO_POR_TER_24_MESES_APROVACAO_SEM_CAPTACAO_DE_RECURSOS,
            self::PROJETO_ARQUIVADO_POR_EXCESSO_DE_PRAZO_SEM_CAPTACAO,
            self::PROJETO_ARQUIVADO_CAPTACAO_EXECUCAO_ENCERRADAS,
            self::PROJETO_ARQUIVADO_SOLICITACAO_DE_ARQUIVAMENTO_DE_PROJETO_DE_INCENTIVO_FISCAL_FEITO_PELO_PROPONENTE,
            self::ARQUIVADO_NAO_CUMPRIMENTO_DE_DILIGENCIA,
            self::SOLICITACAO_DE_ARQUIVAMENTO_FEITO_PELO_PROPONENTE,
            self::PROJETO_ARQUIVADO,
            self::ARQUIVADO_POR_EXCESSO_DE_PROJETOS_APRESENTADOS
        ];
    }

    public static function obterSituacoesPermitidoVisualizarPrestacaoContas()
    {
        return [
            self::AGUARDA_REVISAO_DA_DIRETORIA,
        ];
    }
}
