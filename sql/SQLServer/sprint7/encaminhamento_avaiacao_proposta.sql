CREATE TABLE sac.dbo.distribuicao_avaliacao_proposta
(
    id_distribuicao_avaliacao_proposta INT NOT NULL IDENTITY,
    id_preprojeto INT NOT NULL,
    id_orgao_superior INT NOT NULL,
    id_perfil INT NOT NULL,
    data_distribuicao INT NOT NULL
);