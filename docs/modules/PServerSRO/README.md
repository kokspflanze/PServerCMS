# PSeverSRO extension for PServerCMS

## How to add a View-Helper

First of all you need your own template files, a guide you can find [here](/general-setup/CUSTOMIZE.md#how-to-change-the-layout).

Than you have to add in a twig template file something like `{{ fortressGuildViewSro() }}` as example for the fortress-war information.
In a phtml file it will looks like `<?= $this->fortressGuildViewSro() ?>`. You can add it every where, in the sidebar, or directly in the layout. 

## Features

This fancy extension provides a lot of helpful tools for your system such as: 

- Job ranking (Hunters | Traders | Thieves | Alliance) accessible from the ranking pages
    - for the Alliance ranking please check [item-points-module](/modules/SROItemPoints/README.md)

- Honor ranking accessible from the ranking pages

- Unstuck character (Teleport the buggy char back to town, default hotan) accessible from the character panel

- Character options (Ability to view characters in your DB) accessible from admin panel

- Job name history (Ability to view original job names & changed ones) accessible from admin panel

- SMC Log (Shows the GM/SMC logs on your website) accessible from admin panel 

- Fortress owners guilds (Can be shown anywhere you want, and for every role) as ViewHelper `fortressGuildViewSro`, default it show only entires with realy winner guilds, you can change that in config `module/PServerSRO//config/module.config.php` to show all entries.

- Job ranking widgets (Can be shown anywhere you want, and for every role) as ViewHelper `rankingJobTraderViewSro`, `rankingJobHunterViewSro`, `rankingJobThievesViewSro`

- Job type to name mapper (For your own customize parts, if you want to show the job of a character) as ViewHelper `jobType2Name`

- see the inventory-avatar of a character `{{ inventoryAvatarViewSro(<character-object>) }}` 
