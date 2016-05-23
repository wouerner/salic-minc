-- =========================================================================================
-- Autor: Rômulo Menhô Barbosa
-- Data de Criação: 05/05/2016
-- Descrição: Checar se todos os pareceres SECUNDÁRIOS estão concluídos.
-- =========================================================================================

IF OBJECT_ID(N'dbo.fnchecarValidacaoProdutoSecundario') IS NOT NULL
    DROP FUNCTION dbo.fnchecarValidacaoProdutoSecundario;
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS OFF 
GO

CREATE FUNCTION dbo.fnchecarValidacaoProdutoSecundario (@idPronac int) 
RETURNS BIT
AS  
BEGIN 
    DECLARE @QtdeConcluido int
    DECLARE @Mensagem      bit 
	
	SET @QtdeConcluido = 0
    
	SELECT @QtdeConcluido = count(*) FROM tbDistribuirParecer 
           WHERE stEstado = 0 AND FecharAnalise <> 1 AND	stPrincipal = 0 AND idPronac = @idPronac

     IF @QtdeConcluido = 0
        SET @Mensagem = 1 -- Pronto para consolidar
	 ELSE
        SET @Mensagem = 0

    RETURN(@Mensagem)
END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

GRANT  EXECUTE  ON dbo.fnchecarValidacaoProdutoSecundario  TO usuarios_internet
GO
