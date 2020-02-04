# SROUnique
SRO module for unique

## INSTALLATION

### DB UPDATE

Tables creation: 

Please execute the following query in your SHARD DB in order to create _UniqueKillList table successfully 

````sql
CREATE TABLE [dbo].[_UniqueKillList](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CharID] [int] NOT NULL,
	[CodeName128] [varchar](128) NOT NULL,
	[time] [datetime] NOT NULL,
 CONSTRAINT [PK___UniqueK__3214EC27198BD5AA] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

ALTER TABLE [dbo].[_UniqueKillList] ADD  CONSTRAINT [DF__UniqueKillList_time]  DEFAULT (getdate()) FOR [time]
GO
````

Please execute the following query in your SHARD DB in order to create _UniqueInfo table successfully

````sql
CREATE TABLE [dbo].[_UniqueInfo](
	[CodeName128] [varchar](128) NOT NULL,
	[Name] [varchar](128) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[CodeName128] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
````

The `_UniqueKillList` is for the kill history, there you have to store, if a player kill a unique.


Please execute the following query in your SHARD DB in order to create _UniqueRanking table successfully

````sql
CREATE TABLE [dbo].[_UniqueRanking](
    [CharID] [int] NOT NULL,
	[CodeName128] [varchar](128) NOT NULL,
    [points] [int] NOT NULL
) ON [PRIMARY]

GO
````

example
````sql
INSERT INTO _UniqueKillList ([CharID], [CodeName128]) VALUES (1, 'MOB_SPECIAL');
````

In the `_UniqueInfo` you have to store the CodeName128 to Name mapping.

example
````sql
INSERT INTO _UniqueInfo ([CodeName128], [Name]) VALUES ('MOB_SPECIAL', 'SPECIAL');
````

### Config

Now you can enable `'PServerCMS\SROUnique',` in `config/application.config.php`.

## How to use

### Trigger

You need to migrate your current unique-history to the new tables for the website.

### View-Helper

These view-helper are out of the box added.

This mean if you enable the module, than you can see directly the changes in the sidebar and in the character-details.

This list just show you , how to add it also on other positions, for your custom design.

````php
<?= $this->uniqueKillListPServerSROUnique(10) ?>
````

````php
<?= $this->uniqueKillHistoryCharacterPServerSROUnique([Character], [limit]) ?>
````

````php
<?= $this->characterEachUniquePointsPServerSROUnique([Character], [limit]) ?>
````

