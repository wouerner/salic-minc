-- Adição da coluna 'id_orgao_superior' na tabela 'sac.dbo.sugestao_enquadramento'
ALTER TABLE sac.dbo.sugestao_enquadramento ADD id_orgao_superior INT NULL;

-- Ajuste de dados antigos da tabela 'sac.dbo.sugestao_enquadramento'
update enquadramento set id_orgao_superior = tabela_temporaria.id_orgao_superior
  from sac.dbo.sugestao_enquadramento enquadramento
 inner join (select idPreProjeto as id_preprojeto,
                    case AreaAbrangencia when '0' then '251'
                    else '160' end as id_orgao_superior
             from sac.dbo.PreProjeto) tabela_temporaria on enquadramento.id_preprojeto = tabela_temporaria.id_preprojeto
 where enquadramento.id_orgao_superior is null

ALTER TABLE sac.dbo.sugestao_enquadramento ALTER COLUMN id_orgao_superior INT NOT NULL