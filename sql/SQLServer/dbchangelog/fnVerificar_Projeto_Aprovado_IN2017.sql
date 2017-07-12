-- =========================================================================================
-- Autor: Rômulo Menhô Barbosa
-- Data de Criação: 11/07/2017
-- Descrição: Identificar os projetos aprovados segundo as regras da IN 1/2017.
-- =========================================================================================

IF OBJECT_ID(N'dbo.fnVerificar_Projeto_Aprovado_IN2017') IS NOT NULL
    DROP FUNCTION dbo.fnVerificar_Projeto_Aprovado_IN2017;
GO

CREATE FUNCTION dbo.fnVerificar_Projeto_Aprovado_IN2017 (@p_idPronac INT)
RETURNS BIT
AS

BEGIN
  DECLARE @p_Resultado BIT
   
  IF EXISTS(SELECT b.IdPRONAC
              FROM       sac.dbo.tbDocumentoAssinatura a
              INNER JOIN sac.dbo.Projetos              b on (a.IdPRONAC = b.IdPRONAC)
              INNER JOIN sac.dbo.Aprovacao             c on (a.IdPRONAC = c.IdPRONAC)
              WHERE     a.idTipoDoAtoAdministrativo = 626
                    AND a.cdSituacao = 2
                    AND a.stEstado = 1
	                AND c.TipoAprovacao = '1'
	                AND b.IdPRONAC = @p_idPronac)
     SET @p_Resultado = 1 -- PROJETO APROVADO NA INSTRUÇÃO NORMATIVA Nº 1 DE 20 DE MARÇO DE 2017
  ELSE
     SET @p_Resultado = 0

  RETURN @p_Resultado
 
END
GO

GRANT  EXECUTE  ON dbo.fnVerificar_Projeto_Aprovado_IN2017 TO usuarios_internet
GO
