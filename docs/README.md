# PServerCMS

This doc provide you every thing for the first start with the PServerCMS

[**Contact - Trail Version**](/info/CONTACT.md)

![ScreenShot](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/screenshots/default_mode.png)

## Features

### General
- News (modification in admin-panel)
- ServerInfo (modification in admin-panel) include PlayerOnline
- ServerTimes (modification in config)
- Download (modification in admin-panel)
- ServerInfoPages (modification in admin-panel, possible to add more dynamic)
- Register (with mail confirmation, 2 pw system [different pws for ingame and web])
- Checkbox at register to confirm terms/rules
- SecretQuestionSystem (possible to enable it in the config, and set the question in the admin panel)
- SecretLogin (you can define different roles, which has to confirm there mail before they can login)
- lost Password
- TicketSystem (with bb-code) change TicketCategories in the Adminpanel
- TicketNotification for Admins via mail
- AccountPanel (to change the web/ingame password and change email with confirmation)
- CharacterPanel (to show current status of a character, set main character[alias for ticket-system])
- Vote4Coins (modification in admin-panel, VotePostBack possible)
- RoleSystem, its possible to add more roles with different permissions
- show current online player as an image for threads `/info/online-player.png`
- easy to change the web, admin and email layout
- resend register mail (user can login and resend the confirmation mail, its also possible in the adminpanel)
- You can change the language of the page, or just change some texts to your custom version, without touch the template
- Theme Layout Switch (Dark/Light mode)
- Captcha System (switch between PHP-Captcha and ReCaptcha v2)
- MultiLanguage Support (beta)

### Donate
- PaymentWall
- PayOP
- Paywant
- Maxigame (E-Pin Provider)
- [HipopoTamya](https://www.hipopoTamya.com/) (E-Pin Provider)
- PayPal-IPN (not recommended)
- Payssion

### VotePostBackProvider
- gamestop100
- xtremetop100
- gtop100
- silkroad-server
- private-server
- topg

### Ranking
- Ranking (TopGuild|TopPlayer) with detail pages
- Char search
- Job ranking (Hunters | Traders | Thieves | Alliance) accessible from the ranking pages
    - for the Alliance ranking please check [item-points-module](/modules/SROItemPoints/README.md)
- Honor ranking accessible from the ranking pages
- see the inventory-avatar of a character `{{ inventoryAvatarViewSro(<character-object>) }}` 
- Blues/Whites of the Set/Avatar [enable](/general-setup/RANKING_ICONS)
- ItemPoints [enable](/modules/SROItemPoints/README.md)
- Unique ranking [enable](/modules/PServerSROUnique/README)
    - kill-history in sidebar
    - kill-history and points information in the character-details-page
- PVP / Job Kill/Death [enable](/modules/SROKill/README)
    - 2 rankings
    - history of last fights in character-details-page
- CustomRanking, you can add own rankings, just add the definition in the config
- Switch between rankings based on navigation and one ranking page.

### Game-Specials
- Unstuck character (Teleport the buggy char back to town, default hotan) accessible from the character panel, (this require the `_OnlineOffline` Table)
- Fortress owners guilds (Can be shown anywhere you want, and for every role) as ViewHelper `fortressGuildViewSro`, default it show only entires with realy winner guilds, you can change that in config `module/PServerSRO//config/module.config.php` to show all entries.
- Job ranking widgets (Can be shown anywhere you want, and for every role) as ViewHelper `rankingJobTraderViewSro`, `rankingJobHunterViewSro`, `rankingJobThievesViewSro`
- Job type to name mapper (For your own customize parts, if you want to show the job of a character) as ViewHelper `jobType2Name`
- player-map (World Map with all online chars, exclude jobs and special accounts), (this require the `_OnlineOffline` Table)

### AdminPanel
- Character options (Ability to view characters in your DB) accessible from admin panel
- Job name history (Ability to view original job names & changed ones) accessible from admin panel
- SMC Log (Shows the GM/SMC logs on your website) accessible from admin panel
- LogEventChar accessible from admin panel
- LogEventItem accessible from admin panel
- UserPanel (edits like email possible)
- DonateStatistic
- view Logs
- BlockHistory 

### Additional-Pay-Features
- Support Online-Counter
- E-PIN System
- TitleSystem
- InGame PIN System
- Monitoring
- Setup (Linux, Windows)
- Cloudflare GET-Attack Firewall
- special modules, what you need