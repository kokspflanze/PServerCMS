# CustomRanking
Add you own rankings

## Config

Go to the `config/autoload` directory and create `custom_ranking.local.php` with the following content.
 
````php
<?php

return [
    'p-server-sro' => [
        'custom-ranking' => [
            'character' => [
                'label' => 'TOP Character',
                'count_query' => 'SELECT COUNT(C.CharID) as number FROM SRO_VT_SHARD.._Char C WHERE C.CharID > 0',
                'data_query' => 'SELECT C.Charname16, C.CharID, G.[Name] AS GuildName
FROM SRO_VT_SHARD.._Char C WITH(NOLOCK) 
LEFT JOIN SRO_VT_SHARD.._GuildMember GM WITH(NOLOCK) ON C.CharID = GM.CharID
LEFT JOIN SRO_VT_SHARD.._Guild G WITH(NOLOCK) ON G.ID = GM.GuildID
WHERE C.CharID > 0
ORDER BY C.CurLevel DESC, C.ExpOffset DESC
OFFSET :offset: ROWS 
FETCH NEXT :limit: ROWS ONLY;',
                'result_row_settings' => [
                    [
                        'label' => 'Charname',
                        'col' => 'Charname16',
                        'type' => 'link',
                        'route' => 'PServerRanking/character',
                        'typeCol' => 'CharID',
                    ],
                    [
                        'label' => 'Guild',
                        'col' => 'GuildName',
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            'ranking' => [
                'pages' => [
                    'foo_bar' => [
                        'label'  => 'TOP Character',
                        'route' => 'PServerRanking/sro_custom_ranking',
                        'params' => [
                            'type' => 'character',
                        ],
                        'resource' => 'PServerRanking/sro_custom_ranking',
                    ],
                ],
            ],
        ],
    ],
    'pserver' => [
        'ranking' => [
            'foo_bar' => [
                'label'  => 'TOP Character',
                'route' => 'PServerRanking/sro_custom_ranking',
                'resource' => 'PServerRanking/sro_custom_ranking',
                'params' => [
                    'type' => 'character',
                ],
            ],
        ],
    ],
];
```` 

If you use the ranking one page, than remove the `navigation` config-part.

## Explain

You need for each ranking, a query for the number of items (for the paginator) that give `number` as return and a query for the data.
For the DataQuery you have to define the `result_row_settings` for the output.
`Navigation` and `pserver-ranking` are just for the link generation on the ranking pages or in the navigation of the page.



## Own Ranking

to define your own ranking, pages you have to overwrite or null the following parts.

````php
<?php

return [
    'pserver' => [
	'ranking-main' => [
            'default' => 'character', // overwrite default ranking
        ],
        'ranking' => [
		'top_player' => null,
		'top_guild' => null,
		'top_trader' => null,
		'top_hunter' => null,
		'top_thieves' => null,
		'top_honor' => null,
		'top_alliance' => null,
		'sro_kill_pvp' => null,
		'sro_kill_job' => null,
		'top_unique' => null,
        ],
    ],
];
````
