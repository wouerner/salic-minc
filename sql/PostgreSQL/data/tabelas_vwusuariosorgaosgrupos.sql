
DROP VIEW tabelas.vwUsuariosOrgaosGrupos;
CREATE VIEW tabelas.vwUsuariosOrgaosGrupos AS
  SELECT usu_codigo, usu_identificacao, usu_nome,
    usu_orgao, (org_superior || ' - ' || org_sigla) usu_orgaolotacao,
    usu_telefone
--     , 'Tabelas.dbo.fnCodigoOrgaoEstrutura(uog_orgao,1)' as org_superior
    , uog_orgao as org_superior
    , uog_orgao
--     , 'Tabelas.dbo.fnEstruturaOrgao(uog_orgao, 0)' as org_siglaautorizado,
    , uog_orgao as org_siglaautorizado,
               pid_identificacao as org_nomeautorizado,
    sis_codigo, sis_sigla, sis_nome,
    gru_codigo, gru_nome, uog_status
    , 'usu_pessoa || uog_orgao || uog_grupo' AS id_unico
  FROM tabelas.usuariosxorgaosxgrupos
    INNER JOIN tabelas.Grupos ON uog_grupo = gru_codigo
    INNER JOIN tabelas.Sistemas ON gru_sistema = sis_codigo
    INNER JOIN tabelas.Orgaos ON uog_orgao = org_codigo
    INNER JOIN tabelas.Pessoa_Identificacoes ON pid_pessoa = org_pessoa and
                                                pid_meta_dado = 1 and
                                                pid_sequencia = 1
    INNER JOIN tabelas.Usuarios ON uog_usuario = usu_codigo
  WHERE gru_status > 0;


-- CREATE VIEW tabelas.vwUsuariosOrgaosGrupos AS
--   SELECT usu_codigo, usu_identificacao, usu_nome,
--          usu_orgao, Tabelas.dbo.fnEstruturaOrgao(usu_orgao, 0) usu_orgaolotacao,
--          usu_telefone, Tabelas.dbo.fnCodigoOrgaoEstrutura(uog_orgao,1) org_superior,
--          uog_orgao, Tabelas.dbo.fnEstruturaOrgao(uog_orgao, 0) org_siglaautorizado,
--          pid_identificacao org_nomeautorizado,
--          sis_codigo, sis_sigla, sis_nome,
--          gru_codigo, gru_nome, uog_status,
--          CAST(LTRIM(RTRIM(STR(usu_pessoa)))+LTRIM(RTRIM(STR(uog_orgao)))+LTRIM(RTRIM(STR(uog_grupo))) AS BIGINT) id_unico
--   FROM Tabelas.dbo.UsuariosxOrgaosxGrupos
--        INNER JOIN tabelas.Grupos ON uog_grupo = gru_codigo
--        INNER JOIN tabelas.Sistemas ON gru_sistema = sis_codigo
--        INNER JOIN tabelas.Orgaos ON uog_orgao = org_codigo
--        INNER JOIN tabelas.Pessoa_Identificacoes ON pid_pessoa = org_pessoa and
--                     pid_meta_dado = 1 and
--                     pid_sequencia = 1
--        INNER JOIN tabelas.Usuarios ON uog_usuario = usu_codigo
--   WHERE gru_status > 0