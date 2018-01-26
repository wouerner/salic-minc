CREATE TABLE distribuicao_avaliacao_proposta
(
    id_distribuicao_avaliacao_proposta INT PRIMARY KEY NOT NULL IDENTITY,
    id_preprojeto INT NOT NULL,
    id_orgao_superior INT NOT NULL,
    id_perfil INT NOT NULL,
    data_distribuicao INT NOT NULL,
    CONSTRAINT distribuicao_avaliacao_proposta_PreProjeto_idPreProjeto_fk FOREIGN KEY (id_preprojeto) REFERENCES PreProjeto (idPreProjeto)
);