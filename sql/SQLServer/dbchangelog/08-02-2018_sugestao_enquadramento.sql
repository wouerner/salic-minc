-- Adição da coluna 'ultima_sugestao' na tabela 'sac.dbo.sugestao_enquadramento'
ALTER TABLE sac.dbo.sugestao_enquadramento ADD ultima_sugestao BIT DEFAULT 0 NULL

-- Ajuste de dados antigos da tabela 'sac.dbo.sugestao_enquadramento'

update enquadramento set ultima_sugestao = 1
--select count(*)
from sac.dbo.sugestao_enquadramento enquadramento
  inner join (select max(data_avaliacao) as data_avaliacao, id_preprojeto
              from sac.dbo.sugestao_enquadramento
              GROUP BY id_preprojeto
             ) tabela_temporaria
    on enquadramento.id_preprojeto = tabela_temporaria.id_preprojeto
    and enquadramento.data_avaliacao = tabela_temporaria.data_avaliacao
where enquadramento.ultima_sugestao is null

update enquadramento set ultima_sugestao = 0
from sac.dbo.sugestao_enquadramento enquadramento
where enquadramento.ultima_sugestao is null
--COMMIT TRANSACTION ;
--ROLLBACK TRANSACTION ;

-- Definindo coluna id_orgao_superior como obrigatório
ALTER TABLE sac.dbo.sugestao_enquadramento ALTER COLUMN ultima_sugestao BIT NOT NULL;