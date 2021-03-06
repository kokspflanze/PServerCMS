# How to show icons in ranking

if you go to the ranking page and select a character you should see on the button smth like

![ScreenShot](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/RANKING_DEFAULT.png)

## Copy your icons

You will get a basic icon list, but its recommended to use your icons from your media.
You have to copy your own icons to the `public` directory. They must be on the same postion like in the path written, expected the public directory, that is added automatically.

## DB Changes

````sql
ALTER TABLE dbo._RefObjCommon ADD webName varchar(255) NOT NULL DEFAULT 'ItemName';
````

Hint you can use [File](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/help/itemname.txt) for the basic ItemNames of your items, but dont miss, you could have other names and/or additional Items.


## Config

Now you can enable `'SROItemDetails',` in `config/application.config.php`.
Than you can see the Items of a character with blues/whites.

![ScreenShot](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/blues_whites.png)

If you still see the old version, you have to delete the cache. You can delete the cache with your Terminal or the Git-Bash (you have to stay in the directory of the cms).
```bash
rm -rf data/cache/laminas*
```