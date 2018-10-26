-- ==========================================================================================================
-- Autor: R�mulo Menh� Barbosa
-- Data de Cria��o: 29/08/2016
-- Descri��o: Verifica os limites or�ament�rios permitidos para Custo Administrativos, Remunera��o para
--            Capta��o e Divulga��o na Readequa��o Or�ament�ra
-- ==========================================================================================================
-- Data de Altera��o: 15/03/2018
-- Motivo : Incluir a tabela tbReadequa��o nas restri��es, uma vez que o proponente pode solicitar a reade-
--          qua��o v�rias vezes.
-- ==========================================================================================================
IF OBJECT_ID ( 'dbo.spChecarLimitesOrcamentarioReadequacao', 'P' ) IS NOT NULL 
    DROP PROCEDURE dbo.spChecarLimitesOrcamentarioReadequacao;
GO

CREATE PROCEDURE dbo.spChecarLimitesOrcamentarioReadequacao @idPronac int
AS 

SET NOCOUNT ON    
    
DECLARE @Rows                 INT
DECLARE @Flag                 INT
DECLARE @TotalSemCustoAdm     DECIMAL(18,2)
DECLARE @CustoAdm             DECIMAL(18,2)
DECLARE @vlCorretoCustoAdm    DECIMAL(18,2)
DECLARE @ResultadoPercentual  DECIMAL(18,2)
DECLARE @PercTotalProjeto     DECIMAL(18,2)
DECLARE @RemuneracaoCaptacao  DECIMAL(18,2)
DECLARE @TotalSemRemuneracao  DECIMAL(18,2)
DECLARE @Divulgacao           DECIMAL(18,2)
DECLARE @TotalSemDivulgacao   DECIMAL(18,2)
DECLARE @vlCorretoDivulgacao  DECIMAL(18,2)
DECLARE @vlDiferenca          DECIMAL(18,2)
DECLARE @vlCorretoRemuneracao DECIMAL(18,2)

SET @Flag = 0

--============================================================================================================
-- Tabela tempor�ria
--============================================================================================================

CREATE TABLE #Verificacao
       (
        idPronac    INT,
		Tipo        VARCHAR(50),
        Descricao   VARCHAR (250),
        vlDiferenca DECIMAL(18,2),
        Observacao  VARCHAR (100)
       )
       
--============================================================================================================
 --MONTAR O CUSTO TOTAL DO PROJETO E O CUSTO ADMINISTRATIVO
--============================================================================================================
SET @TotalSemCustoAdm = ISNULL((SELECT SUM(a.qtItem * a.nrOcorrencia * a.vlUnitario) 
                                       FROM sac.dbo.tbPlanilhaAprovacao a
									   INNER JOIN tbReadequacao         b on (a.idReadequacao = b.idReadequacao) 
                                       WHERE     a.idPronac          = @idPronac 
									         AND a.idEtapa          <> 4 
											 AND a.nrFonteRecurso    = 109 
											 AND a.tpPlanilha        = 'SR' 
											 AND a.tpAcao           <> 'E'
											 AND a.stAtivo           = 'N'
											 AND b.idTipoReadequacao = 2 
                                             AND b.siEncaminhamento <> 15
		                                     AND b.stEstado          = 0),0)

SET @CustoAdm = ISNULL((SELECT SUM(a.qtItem * a.nrOcorrencia * a.vlUnitario) 
                               FROM sac.dbo.tbPlanilhaAprovacao a
							   INNER JOIN tbReadequacao         b on (a.idReadequacao = b.idReadequacao)
                               WHERE     a.idPronac          = @idPronac 
							         AND a.idEtapa           = 4 
									 AND a.idPlanilhaItem   <> 5249 
									 AND a.nrFonteRecurso    = 109 
									 AND a.tpPlanilha        = 'SR' 
									 AND a.tpAcao           <> 'E'
									 AND a.stAtivo           = 'N'
									 AND b.idTipoReadequacao = 2 
                                     AND b.siEncaminhamento <> 15
		                             AND b.stEstado          = 0),0)

SET @TotalSemRemuneracao = ISNULL((SELECT SUM(a.qtItem * a.nrOcorrencia * a.vlUnitario) 
                                          FROM sac.dbo.tbPlanilhaAprovacao a
							              INNER JOIN tbReadequacao         b on (a.idReadequacao = b.idReadequacao)
                                          WHERE     a.idPronac          = @idPronac 
										        AND a.idPlanilhaItem   <> 5249 
												AND a.nrFonteRecurso    = 109 
												AND a.tpPlanilha        = 'SR' 
											    AND a.tpAcao           <> 'E'
												AND a.stAtivo           = 'N'
									            AND b.idTipoReadequacao = 2 
                                                AND b.siEncaminhamento <> 15
		                                        AND b.stEstado          = 0),0)

SET @RemuneracaoCaptacao = ISNULL((SELECT SUM(a.qtItem * a.nrOcorrencia * a.vlUnitario) 
                                          FROM sac.dbo.tbPlanilhaAprovacao a
							              INNER JOIN tbReadequacao         b on (a.idReadequacao = b.idReadequacao)
                                          WHERE     a.idPronac          = @idPronac 
										        AND a.idPlanilhaItem    = 5249 
												AND a.nrFonteRecurso    = 109 
												AND a.tpPlanilha        = 'SR' 
											    AND a.tpAcao           <> 'E'
												AND a.stAtivo           = 'N'
									            AND b.idTipoReadequacao = 2 
                                                AND b.siEncaminhamento <> 15
		                                        AND b.stEstado          = 0),0)

SET @TotalSemDivulgacao = ISNULL((SELECT SUM(a.qtItem * a.nrOcorrencia * a.vlUnitario) 
                                         FROM sac.dbo.tbPlanilhaAprovacao a
							             INNER JOIN tbReadequacao         b on (a.idReadequacao = b.idReadequacao) 
                                         WHERE     a.idPronac          = @idPronac  
										       AND a.idEtapa          <> 3 
											   AND a.nrFonteRecurso    = 109 
											   AND a.tpPlanilha        = 'SR'
											   AND a.tpAcao           <> 'E'
											   AND a.stAtivo           = 'N'
									           AND b.idTipoReadequacao = 2 
                                               AND b.siEncaminhamento <> 15
		                                       AND b.stEstado          = 0),0)

SET @Divulgacao = ISNULL((SELECT SUM(a.qtItem * a.nrOcorrencia * a.vlUnitario) 
                                 FROM sac.dbo.tbPlanilhaAprovacao a
							     INNER JOIN tbReadequacao         b on (a.idReadequacao = b.idReadequacao) 
                                 WHERE     a.idPronac          = @idPronac 
								       AND a.idEtapa           = 3 
									   AND a.nrFonteRecurso    = 109 
									   AND a.tpPlanilha        = 'SR'
									   AND a.tpAcao           <> 'E'
									   AND a.stAtivo           = 'N'
									   AND b.idTipoReadequacao = 2 
                                       AND b.siEncaminhamento <> 15
		                               AND b.stEstado          = 0),0)

--============================================================================================================
-- VERIFICAR O PERCENTUAL DOS CUSTOS ADMINISTRATIVOS
--============================================================================================================
IF (@TotalSemCustoAdm <> 0 AND @CustoAdm <> 0)
   BEGIN  
     -- CALCULA EM REAIS O CUSTO ADMINISTRATIVO
     SET @vlCorretoCustoAdm = @TotalSemCustoAdm * 0.15
     SET @vlDiferenca =  @custoAdm - @vlCorretoCustoAdm  
     --calcula o percentual
     SET @ResultadoPercentual =  @custoAdm / @TotalSemCustoAdm * 100
     --verifica se � superior a 15
     IF (@ResultadoPercentual > 15)
        BEGIN
          INSERT INTO #Verificacao       
                       VALUES (@idPronac,'custo_administrativo','Custo administrativo superior a 15% do valor total do projeto, para corrigir reduza o valor da etapa em R$ ' ,@vlDiferenca,'PENDENTE')
           SET @Flag = 1     
        END
     ELSE
        BEGIN
          INSERT INTO #Verificacao       
                       VALUES (@idPronac,'custo_administrativo','Custo administrativo inferior a 15% do valor total do projeto.',0,'OK')
          END
     END   
--============================================================================================================
-- VERIFICAR O PERCENTUAL DA REMUNERA��O PARA CAPTA��O DE RECURSOS
--============================================================================================================
IF (@TotalSemRemuneracao <> 0 AND @RemuneracaoCaptacao <> 0)
    BEGIN
      -- Valor Correto
      SET @vlCorretoRemuneracao =   @TotalSemRemuneracao * 0.10
      --calcula o percentual
      SET @ResultadoPercentual =  @RemuneracaoCaptacao / @TotalSemRemuneracao * 100
      --verifica se � superior a 10
      IF (@RemuneracaoCaptacao > 150000)
         BEGIN
		    SET @vlCorretoRemuneracao = 150000
            INSERT INTO #Verificacao       
                        VALUES (@idPronac,'remuneracao','Remunera��o para capta��o de recursos superior a 10% do valor do projeto, ou superior a  R$ 150.000,00.',@vlCorretoRemuneracao,'PENDENTE')
               SET @Flag = 1     
         END
      ELSE
      IF (@ResultadoPercentual > 10)
         BEGIN
            INSERT INTO #Verificacao       
                        VALUES (@idPronac,'remuneracao','Remunera��o para capta��o de recursos superior a 10% do valor do projeto, ou superior a  R$ 150.000,00. O valor correto �: R$',@vlCorretoRemuneracao,'PENDENTE')
               SET @Flag = 1     
         END
      ELSE 
         BEGIN
           INSERT INTO #Verificacao       
                        VALUES (@idPronac,'remuneracao','Remunera��o para capta��o de recursos est� dentro dos par�metros permitidos.',0,'OK')
        END
END 
--============================================================================================================
-- VERIFICAR O PERCENTUAL DA DIVULGA��O E COMERCIALIZA��O
--============================================================================================================
IF (@TotalSemDivulgacao <> 0 AND @Divulgacao <> 0)
   BEGIN
     -- CALCULA EM REAIS O CUSTO DA DIVULGA��O
     SET @vlCorretoDivulgacao = @TotalSemDivulgacao * 0.20
     SET @vlDiferenca =  @Divulgacao - @vlCorretoDivulgacao  
     --calcula o percentual
     SET @ResultadoPercentual =  @Divulgacao / @TotalSemDivulgacao * 100
     --verifica se � superior a 20
     IF @ResultadoPercentual > 20 
        BEGIN
          INSERT INTO #Verificacao       
                      VALUES (@idPronac,'divulgacao','Divulga��o / Comercializa��o superior a 20%, para corrigir reduza o valor da etapa em R$',@vlDiferenca ,'PENDENTE')
                 SET @Flag = 1     
        END
     ELSE
        BEGIN
          INSERT INTO #Verificacao       
                 VALUES (@idPronac,'divulgacao','Divulga��o / Comercializa��o est� dentro dos par�metros permitidos.',0,'OK')
        END
   END
   
--============================================================================================================
-- VERIFICAR SE O CORTE � SUPERIOR A 50%
--============================================================================================================
  IF @PercTotalProjeto > 50
     BEGIN
       INSERT INTO #Verificacao       
              VALUES (@idPronac,'corte_superior','Corte superior a 50%.',0,'OK')
     END
--============================================================================================================
-- RESULTADO
--============================================================================================================
         
 SELECT * FROM #Verificacao
 
GO

GRANT  EXECUTE ON dbo.spChecarLimitesOrcamentarioReadequacao  TO usuarios_internet
GO

SET NOCOUNT OFF
GO   
 