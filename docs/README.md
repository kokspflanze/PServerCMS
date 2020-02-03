# PServerCMSFull

This repository provide you every thing for the first start with the PServerCMS
  
## General information

![ScreenShot](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/screenshots/news.png)

### Features

- News (modification in admin-panel)
- ServerInfo (modification in admin-panel) include PlayerOnline
- ServerTimes (modification in config)
- Download (modification in admin-panel)
- Ranking (TopGuild|TopPlayer) with detail pages
- Char search
- ServerInfoPages (modification in admin-panel, possible to add more dynamic)
- Register (with mail confirmation, 2 pw system [different pws for ingame and web])
- SecretQuestionSystem (possible to enable it in the config, and set the question in the admin panel)
- SecretLogin (you can define different roles, which has to confirm there mail before they can login)
- lost Password
- Donate ([PaymentWall](https://www.paymentwall.com), [xsolla](http://xsolla.com/) and PayPal-IPN, in [PayOP](https://payop.com))
- TicketSystem (with bb-code) change TicketCategories in the Adminpanel
- AccountPanel (to change the web/ingame password)
- CharacterPanel (to show current status of a character, set main character[alias for ticket-system])
- AdminPanel with UserPanel, DonateStatistic, view Logs, edit different parts in page
- BlockHistory in AdminPanel + little widget in UserDetail
- Vote4Coins (modification in admin-panel)
- RoleSystem, its possible to add more roles with different permissions
- show current online player as an image for threads `/info/online-player.png`
- easy to change the web, admin and email layout

## SRO-Specials

- Job ranking (Hunters | Traders | Thieves | Alliance) accessible from the ranking pages
    - for the Alliance ranking please check [item-points-module](/modules/SROItemPoints/README.md)
- Honor ranking accessible from the ranking pages
- Unstuck character (Teleport the buggy char back to town, default hotan) accessible from the character panel, (this require the `_OnlineOffline` Table)
- Character options (Ability to view characters in your DB) accessible from admin panel
- Job name history (Ability to view original job names & changed ones) accessible from admin panel
- SMC Log (Shows the GM/SMC logs on your website) accessible from admin panel 
- Fortress owners guilds (Can be shown anywhere you want, and for every role) as ViewHelper `fortressGuildViewSro`, default it show only entires with realy winner guilds, you can change that in config `module/PServerSRO//config/module.config.php` to show all entries.
- Job ranking widgets (Can be shown anywhere you want, and for every role) as ViewHelper `rankingJobTraderViewSro`, `rankingJobHunterViewSro`, `rankingJobThievesViewSro`
- Job type to name mapper (For your own customize parts, if you want to show the job of a character) as ViewHelper `jobType2Name`
- see the inventory-avatar of a character `{{ inventoryAvatarViewSro(<character-object>) }}` 
- Blues/Whites of the Set/Avatar [enable](/general-setup/RANKING_ICONS)
- ItemPoints [enable](/modules/SROItemPoints/README.md)