-- Adição da coluna 'ultimo_enquadramento' na tabela 'sac.dbo.sugestao_enquadramento'
ALTER TABLE sac.dbo.sugestao_enquadramento ADD ultimo_enquadramento BIT DEFAULT 0 NULL

-- Ajuste de dados antigos da tabela 'sac.dbo.sugestao_enquadramento'

update enquadramento set ultimo_enquadramento = 1
--select count(*)
from sac.dbo.sugestao_enquadramento enquadramento
  inner join (select max(data_avaliacao) as data_avaliacao, id_preprojeto
              from sac.dbo.sugestao_enquadramento
              GROUP BY id_preprojeto
             ) tabela_temporaria
    on enquadramento.id_preprojeto = tabela_temporaria.id_preprojeto
    and enquadramento.data_avaliacao = tabela_temporaria.data_avaliacao
where enquadramento.ultimo_enquadramento is null

update enquadramento set ultimo_enquadramento = 0
from sac.dbo.sugestao_enquadramento enquadramento
where enquadramento.ultimo_enquadramento is null
--COMMIT TRANSACTION ;
--ROLLBACK TRANSACTION ;

-- Definindo coluna id_orgao_superior como obrigatório
ALTER TABLE sac.dbo.sugestao_enquadramento ALTER COLUMN ultimo_enquadramento BIT NOT NULL;