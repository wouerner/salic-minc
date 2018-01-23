CREATE TABLE sugestao_enquadramento
(
    id_sugestao_enquadramento INT PRIMARY KEY NOT NULL IDENTITY,
    id_orgao INT NOT NULL,
    id_perfil_usuario INT NOT NULL,
    id_usuario_avaliador INT NOT NULL,
    id_area VARCHAR(4),
    id_segmento VARCHAR(4),
    id_preprojeto INT NOT NULL,
    descricao_motivacao VARCHAR(8000),
    data_avaliacao DATETIME,
    CONSTRAINT sugestao_enquadramento_Area_Codigo_fk FOREIGN KEY (id_area) REFERENCES Area (Codigo),
    CONSTRAINT sugestao_enquadramento_Segmento_Codigo_fk FOREIGN KEY (id_segmento) REFERENCES Segmento (Codigo),
    CONSTRAINT sugestao_enquadramento_id_proposta_cultural_fk FOREIGN KEY (id_preprojeto) REFERENCES PreProjeto (idPreProjeto)
);