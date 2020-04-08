# SROItemPoints
Add ItemPoints feature for top-char, top-guild amd top-alliance ranking

## FEATURES

- ItemPoints in top-char ranking
- ItemPoints in top-guild ranking
- ItemPoints in top-alliance ranking
- Character and Guild Object has now a ItemPoints property to use it everywhere

## INSTALLATION

### DB Changes

go to your `Shard` database and execute following query, to add 2 new cols.


````sql
ALTER TABLE dbo._Char ADD ItemPoints int NOT NULL DEFAULT 0;
ALTER TABLE dbo._Guild ADD ItemPoints int NOT NULL DEFAULT 0;
````

### Config

Now you can enable `'PServerCMS\SROItemPoints',` in `config/application.config.php`.

### Custom logic

Now you have 2 new cols, but empty. Your todo is now to fill these cols with data.

As example a character logout, than you check the inventory and add the `ReqLevel` + `OptValue` for each item and put it in the `ItemPoints` col of the player.
After this you update the guild (if exists) for the player.

Maybe ppl will post there examples in the issue tracker, so we can share it with other ppl.

### Example

these is an example with the current tables and cols, to help beginners

#### How to set ItemPoints for current data

set ItemPoints for all characters (maybe you have to rename the database in the query)
````sql
  UPDATE [SRO_VT_SHARD].[dbo]._Char 
  set ItemPoints = (
  SELECT
	ISNULL((sum(ISNULL(Binding.nOptValue, 0)) + sum(ISNULL(OptLevel, 0)) + sum(ISNULL(Common.ReqLevel1, 0))), 0) as ItemPoints
	FROM [SRO_VT_SHARD].[dbo].[_Inventory] as inventory
	join [SRO_VT_SHARD].[dbo]._Items as Items on Items.ID64  = inventory.ItemID
	join [SRO_VT_SHARD].[dbo]._RefObjCommon as Common on Items.RefItemId  = Common.ID
	left join [SRO_VT_SHARD].[dbo]._BindingOptionWithItem as Binding on Binding.nItemDBID = Items.ID64 AND Binding.nOptValue > 0 and Binding.bOptType = 2
	where
		inventory.slot < 13 and
		inventory.slot != 8 and
		inventory.slot != 7 and
		inventory.CharID = _Char.CharID
)
````

set ItemPoints for all guilds (maybe you have to rename the database in the query)
````sql

  UPDATE [SRO_VT_SHARD].[dbo]._Guild 
  set ItemPoints = (
  SELECT
	ISNULL(SUM(Char.ItemPoints), 0) as ItemPoints
	FROM [SRO_VT_SHARD].[dbo]._Char as Char
	where
		Char.GuildID = _Guild.ID
)
````

#### Update ItemPoints based on events

add following in the `_AddLogChar` procedure, that you can find in your `LOG` database
````SQL
	IF (@EventID = 6)
    BEGIN
        UPDATE [SRO_VT_SHARD].[dbo]._Char 
			set ItemPoints = (
			SELECT
			ISNULL((sum(ISNULL(Binding.nOptValue, 0)) + sum(ISNULL(OptLevel, 0)) + sum(ISNULL(Common.ReqLevel1, 0))), 0) as ItemPoints
			FROM [SRO_VT_SHARD].[dbo].[_Inventory] as inventory
			join [SRO_VT_SHARD].[dbo]._Items as Items on Items.ID64  = inventory.ItemID
			join [SRO_VT_SHARD].[dbo]._RefObjCommon as Common on Items.RefItemId  = Common.ID
			left join [SRO_VT_SHARD].[dbo]._BindingOptionWithItem as Binding on Binding.nItemDBID = Items.ID64 AND Binding.nOptValue > 0 and Binding.bOptType = 2
			where
				inventory.slot < 13 and
				inventory.slot != 8 and
				inventory.slot != 7 and
				inventory.CharID = _Char.CharID
		) WHERE _Char.CharID = @CharID

		Declare @GuildID int;
		SELECT @GuildID = GuildID FROM [SRO_VT_SHARD].[dbo]._Char WHERE _Char.CharID = @CharID

		IF (@GuildID > 0)
		BEGIN
			UPDATE [SRO_VT_SHARD].[dbo]._Guild 
			  set ItemPoints = (
			  SELECT
				SUM(Char.ItemPoints) as ItemPoints
				FROM [SRO_VT_SHARD].[dbo]._Char as Char
				where
					Char.GuildID = _Guild.ID
			) WHERE _Guild.ID = @GuildID
		END
    END
````
