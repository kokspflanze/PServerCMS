# SROKill
SRO module for PVP/Job Kills

## INSTALLATION

### DB UPDATE

Tables creation: 

Please execute the following query in your `LOG DB` in order to create _KillDeathCounter/_KillHistory table successfully 

````sql
CREATE TABLE [dbo].[_KillDeathCounter](
	[CharId] [int] NULL,
	[death] [int] NULL,
	[kill] [int] NULL,
	[code] [varchar](50) NULL
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[_KillHistory](
	[CharId] [int] NOT NULL,
	[DeathCharId] [int] NOT NULL,
	[CharLevel] [smallint] NOT NULL,
	[DeathCharLevel] [smallint] NOT NULL,
	[isJob] [tinyint] NOT NULL,
	[created] [datetime] NOT NULL
) ON [PRIMARY]
GO
````

````sql
-- =============================================
-- Author:		KoKsPflaNzE
-- =============================================
CREATE PROCEDURE [dbo].[_AddKillDeathCounterTableData]
	@CharID		int,
	@Code		varchar(255),
	@Kill		tinyint,
	@Death		tinyint
AS
BEGIN
	SET NOCOUNT ON;

	IF not exists (SELECT CharID FROM _KillDeathCounter WHERE CharID = @CharID and code = @Code)
	BEGIN
		INSERT INTO _KillDeathCounter VALUES (@CharID, @Death, @Kill, @Code)
	END
	ELSE
	BEGIN
		UPDATE _KillDeathCounter SET [death] += @Death, [kill] += @Kill WHERE CharID = @CharID and code = @Code
	END
END
GO

-- =============================================
-- Author:		KoKsPflaNzE
-- =============================================
CREATE PROCEDURE [dbo].[_AddKillHistoryTableData]
	@CharID			int,
	@DeathCharID	int,
	@CharLevel		tinyint,
	@DeathLevel		tinyint,
	@isJob			tinyint
AS
BEGIN
	SET NOCOUNT ON;
	INSERT INTO _KillHistory VALUES (@CharID, @DeathCharID, @CharLevel, @DeathLevel, @isJob, GETDATE())
END
GO

````

Now you have to add following in you `_AddLogChar` Procedure. Maybe you have to rename `SRO_VT_SHARD` to your custom name.

````sql
IF(@EventID = 20)
BEGIN
    declare @sKillChar	varchar(64)
    declare @iKillCharId int
    declare @iKillCharLevel tinyint
    declare @iCharLevel tinyint

    -- PVP KILL
    IF (((SELECT CHARINDEX('My: no job, Neutral,',@Desc)) > 0) AND ((SELECT CHARINDEX('): no job, Neutral, ',@Desc)) > 0))
    BEGIN
        SELECT @sKillChar = SUBSTRING(@Desc,
                CHARINDEX('(',@Desc)+1,
                CHARINDEX(')',@Desc) - CHARINDEX('(',@Desc)-1
            )
        SELECT @iKillCharId = CharID, @iKillCharLevel = CurLevel FROM [SRO_VT_SHARD].[dbo].[_Char] WHERE CharName16 = @sKillChar
        SELECT @iCharLevel = CurLevel FROM [SRO_VT_SHARD].[dbo].[_Char] WHERE CharID = @CharID

        exec _AddKillDeathCounterTableData @iKillCharId, 'pvp', 1, 0
        exec _AddKillDeathCounterTableData @CharID, 'pvp', 0, 1
        exec _AddKillHistoryTableData @iKillCharId, @CharID, @iKillCharLevel, @iCharLevel, 0
    END
    -- JOB KILL
    ELSE IF (((SELECT CHARINDEX(', Neutral, no freebattle team',@Desc)) > 0) AND ((SELECT CHARINDEX(', Neutral, no freebattle team',@Desc, CHARINDEX(', Neutral, no freebattle team',@Desc) + 1)) > 0))
    BEGIN
        SELECT @sKillChar = SUBSTRING(@Desc,
                CHARINDEX('(',@Desc)+1,
                CHARINDEX(')',@Desc) - CHARINDEX('(',@Desc)-1
            )
        SELECT @iKillCharId = CharID, @iKillCharLevel = CurLevel FROM [LEG_SHD].[dbo].[_Char] WHERE CharName16 = @sKillChar
        SELECT @iCharLevel = CurLevel FROM [LEG_SHD].[dbo].[_Char] WHERE CharID = @CharID

        exec _AddKillDeathCounterTableData @iKillCharId, 'job', 1, 0
        exec _AddKillDeathCounterTableData @CharID, 'job', 0, 1
        exec _AddKillHistoryTableData @iKillCharId, @CharID, @iKillCharLevel, @iCharLevel, 1
    END
END
````

### Config

Now you can enable `'PServerCMS\SROKill',` in `config/application.config.php`.
