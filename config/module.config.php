<?php

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'PServerCMS\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
			'site-detail' => [
				'type' => 'segment',
				'options' => [
					'route'    => '/detail-[:type].html',
					'constraints' => [
						'type'     => '[a-zA-Z]+',
					],
					'defaults' => [
						'controller'	=> 'PServerCMS\Controller\Site',
						'action'		=> 'page'
					],
				],
			],
			'site-download' => [
				'type' => 'segment',
				'options' => [
					'route'    => '/download.html',
					'defaults' => [
						'controller'	=> 'PServerCMS\Controller\Site',
						'action'		=> 'download'
					],
				],
			],
            'user' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/panel/account[/:action].html',
                    'constraints' => [
                        'action'     => '[a-zA-Z-]+',
                    ],
                    'defaults' => [
                        'controller'	=> 'PServerCMS\Controller\Account',
                        'action'		=> 'index',
                    ],
                ],
            ],
            'ranking' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/ranking[/:action[-:page]].html',
                    'constraints' => [
                        'action'     => '[a-zA-Z-]+',
                        'page'       => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller'	=> 'PServerCMS\Controller\Ranking',
                        'action'		=> 'top-player',
                        'page'		    => '1',
                    ],
                ],
            ],
            'character' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/character[/:action][-:id].html',
                    'constraints' => [
                        'action'    => '[a-zA-Z-]+',
                        'id'        => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller'	=> 'PServerCMS\Controller\Character',
                        'action'		=> 'index',
                    ],
                ],
            ],
            'guild' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/guild[/:action][-:id][/page/:page].html',
                    'constraints' => [
                        'action'    => '[a-zA-Z-]+',
                        'id'        => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller'	=> 'PServerCMS\Controller\Guild',
                        'action'		=> 'detail',
                    ],
                ],
            ],
            'panel_donate' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/panel/donate[/:action].html',
                    'constraints' => [
                        'action'    => '[a-zA-Z-]+',
                    ],
                    'defaults' => [
                        'controller'	=> 'PServerCMS\Controller\Donate',
                        'action'		=> 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
		'factories' => [
			'pserver_caching_service' => function($sm){
				$cache = \Zend\Cache\StorageFactory::factory([
					'adapter' => 'filesystem',
					'options' => [
						'cache_dir' => __DIR__ . '/../../../../data/cache',
						'ttl' => 86400
					],
					'plugins' => [
						'exception_handler' => [
							'throw_exceptions' => false
						],
						'serializer'
					]
				]);
				return $cache;
			},
		],
		'invokables' => [
			'small_user_service'				=> 'PServerCMS\Service\User',
			'pserver_mail_service'				=> 'PServerCMS\Service\Mail',
			'pserver_download_service'			=> 'PServerCMS\Service\Download',
			'pserver_server_info_service'		=> 'PServerCMS\Service\ServerInfo',
			'pserver_news_service'				=> 'PServerCMS\Service\News',
			'pserver_usercodes_service'			=> 'PServerCMS\Service\UserCodes',
			'pserver_configread_service'		=> 'PServerCMS\Service\ConfigRead',
			'pserver_pageinfo_service'			=> 'PServerCMS\Service\PageInfo',
			'pserver_playerhistory_service'		=> 'PServerCMS\Service\PlayerHistory',
			'pserver_donate_service'			=> 'PServerCMS\Service\Donate',
			'pserver_cachinghelper_service'		=> 'PServerCMS\Service\CachingHelper',
			'payment_api_log_service'			=> 'PServerCMS\Service\PaymentNotify',
			'pserver_user_block_service'		=> 'PServerCMS\Service\UserBlock',
            'pserver_secret_question'			=> 'PServerCMS\Service\SecretQuestion',
            'pserver_ranking_service'			=> 'PServerCMS\Service\Ranking',
            'pserver_character_service'			=> 'PServerCMS\Service\Character',
            'pserver_guild_service'	    		=> 'PServerCMS\Service\Guild',
            'pserver_log_service'	    		=> 'PServerCMS\Service\Logs',
		],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'controllers' => [
        'invokables' => [
			'PServerCMS\Controller\Index' => 'PServerCMS\Controller\IndexController',
			'SmallUser\Controller\Auth' => 'PServerCMS\Controller\AuthController',
			'PServerCMS\Controller\Auth' => 'PServerCMS\Controller\AuthController',
			'PServerCMS\Controller\Site' => 'PServerCMS\Controller\SiteController',
            'PServerCMS\Controller\Account' => 'PServerCMS\Controller\AccountController',
            'PServerCMS\Controller\Ranking' => 'PServerCMS\Controller\RankingController',
            'PServerCMS\Controller\Character' => 'PServerCMS\Controller\CharacterController',
            'PServerCMS\Controller\Guild' => 'PServerCMS\Controller\GuildController',
            'PServerCMS\Controller\Donate' => 'PServerCMS\Controller\DonateController',
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'					=> __DIR__ . '/../view/layout/layout.twig',
            'p-server-cms/index/index'		=> __DIR__ . '/../view/p-server-cms/index/index.phtml',
            'error/404'						=> __DIR__ . '/../view/error/404.phtml',
            'error/index'					=> __DIR__ . '/../view/error/index.phtml',
			'email/tpl/register'			=> __DIR__ . '/../view/email/tpl/register.phtml',
			'email/tpl/password'			=> __DIR__ . '/../view/email/tpl/password.phtml',
            'email/tpl/country' 			=> __DIR__ . '/../view/email/tpl/country.phtml',
			'helper/sidebarWidget'			=> __DIR__ . '/../view/helper/sidebar.phtml',
			'helper/sidebarLoggedInWidget'	=> __DIR__ . '/../view/helper/logged-in.phtml',
            'helper/formWidget'		        => __DIR__ . '/../view/helper/form.phtml',
			'zfc-ticket-system/new'			=> __DIR__ . '/../view/zfc-ticket-system/ticket-system/new.twig',
			'zfc-ticket-system/view'		=> __DIR__ . '/../view/zfc-ticket-system/ticket-system/view.twig',
			'zfc-ticket-system/index'		=> __DIR__ . '/../view/zfc-ticket-system/ticket-system/index.twig',
			'small-user/login'				=> __DIR__ . '/../view/p-server-cms/auth/login.twig',
			'small-user/logout-page'		=> __DIR__ . '/../view/p-server-cms/auth/logout-page.twig',
            'p-server-cms/paginator'        => __DIR__ . '/../view/helper/paginator.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],

	'doctrine' => [
		'connection' => [
			'orm_default' => [
				'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => [
					'host'     => 'localhost',
					'port'     => '3306',
					'user'     => 'username',
					'password' => 'password',
					'dbname'   => 'dbname',
				],
				'doctrine_type_mappings' => [
					'enum' => 'string'
				],
			],
		],
		'entitymanager' => [
			'orm_default' => [
				'connection'    => 'orm_default',
				'configuration' => 'orm_default'
			],
		],
		'driver' => [
			'application_entities' => [
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [__DIR__ . '/../src/PServerCMS/Entity']
			],
			'orm_default' => [
				'drivers' => [
					'PServerCMS\Entity' => 'application_entities',
					'SmallUser\Entity' => null
				],
			],
		],
        'configuration' => [
            'orm_default' => [
                'datetime_functions' => [
                    'DATE' => 'DoctrineExtensions\Query\Mysql\Date'
                ]
            ]
        ]
	],
	'pserver' => [
		'register' => [
            /**
             * role after register
             */
			'role' => 'user',
            /**
             * mail confirmation after register?
             * WARNING for pw lost, we need a valid mail
             */
            'mail_confirmation' => false
		],
		'mail' => [
			'from' => 'abcd@example.com',
			'fromName' => 'team',
			'subject' => [
				'register' => 'RegisterMail',
				'password' => 'LostPasswordMail',
				'country' => 'LoginIpMail',
			],
			'basic' => [
				'name' => 'localhost',
				'host' => 'smtp.example.com',
				'port'=> 587,
				'connection_class' => 'login',
				'connection_config' => [
					'username' => 'put your username',
					'password' => 'put your password',
					'ssl'=> 'tls',
				],
			],
		],
        'login' => [
            'exploit' => [
                'time' => 900, //in seconds
                'try' => 5
            ]
        ],
		'password' => [
			/*
			 * set other pw for web as ingame
			 */
			'different-passwords' => true,
            /**
             * work with secret pw system, there is atm no admin view to handle the question =[
             */
            'secret_question' => false,
		],
		'news' => [
			'limit' => 5
		],
		'pageinfotype' => [
			'faq',
			'rules',
			'guides',
			'events'
		],
		'blacklisted' => [
			'email' => []
		],
		'entity' => [
			'available_countries' => 'PServerCMS\Entity\AvailableCountries',
			'country_list'        => 'PServerCMS\Entity\Countrylist',
			'donate_log'          => 'PServerCMS\Entity\Donatelog',
			'download_list'       => 'PServerCMS\Entity\Downloadlist',
			'ip_block'            => 'PServerCMS\Entity\Ipblock',
			'login_failed'        => 'PServerCMS\Entity\Loginfaild',
			'login_history'       => 'PServerCMS\Entity\Loginhistory',
			'logs'                => 'PServerCMS\Entity\Logs',
			'news'                => 'PServerCMS\Entity\News',
			'page_info'           => 'PServerCMS\Entity\PageInfo',
			'player_history'      => 'PServerCMS\Entity\PlayerHistory',
			'secret_answer'       => 'PServerCMS\Entity\SecretAnswer',
			'secret_question'     => 'PServerCMS\Entity\SecretQuestion',
			'server_info'         => 'PServerCMS\Entity\ServerInfo',
			'user_block'          => 'PServerCMS\Entity\Userblock',
			'user_codes'          => 'PServerCMS\Entity\Usercodes',
			'user_extension'      => 'PServerCMS\Entity\Userexstension',
			'user_role'           => 'PServerCMS\Entity\UserRole',
			'users'               => 'PServerCMS\Entity\Users'
		]
	],
	'authenticationadapter' => [
		'odm_default' => [
			'objectManager' => 'doctrine.documentmanager.odm_default',
			'identityClass' => 'PServerCMS\Entity\Users',
			'identityProperty' => 'username',
			'credentialProperty' => 'password',
			'credentialCallable' => 'PServerCMS\Entity\Users::hashPassword'
		],
	],
	'small-user' => [
		'user_entity' => [
			'class' => 'PServerCMS\Entity\Users'
		]
	],
	'payment-api' => [
		'ban-time' => '946681200',
	]
];
