<?php

return [
    'router' => [
        'routes' => [
            'PServerCMS'  => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller'	=> 'PServerCMS\Controller\Index',
                        'action'		=> 'index'
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'site-detail' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => 'detail-[:type].html',
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
                            'route'    => 'download.html',
                            'defaults' => [
                                'controller'	=> 'PServerCMS\Controller\Site',
                                'action'		=> 'download'
                            ],
                        ],
                    ],
                    'user' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => 'panel/account[/:action].html',
                            'constraints' => [
                                'action'     => '[a-zA-Z-]+',
                            ],
                            'defaults' => [
                                'controller'	=> 'PServerCMS\Controller\Account',
                                'action'		=> 'index',
                            ],
                        ],
                    ],
                    'panel_donate' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => 'panel/donate[/:action].html',
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
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
		'factories' => [
			'pserver_caching_service' => function(){
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
            'pserver_log_service'	    		=> 'PServerCMS\Service\Logs',
            'pserver_user_panel_service'	    => 'PServerCMS\Service\UserPanel',
            'pserver_user_role_service'	        => 'PServerCMS\Service\UserRole',
            'pserver_login_history_service'	    => 'PServerCMS\Service\LoginHistory',
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
            'helper/formNoLabelWidget'		=> __DIR__ . '/../view/helper/form-no-label.phtml',
			'zfc-ticket-system/new'			=> __DIR__ . '/../view/zfc-ticket-system/ticket-system/new.twig',
			'zfc-ticket-system/view'		=> __DIR__ . '/../view/zfc-ticket-system/ticket-system/view.twig',
			'zfc-ticket-system/index'		=> __DIR__ . '/../view/zfc-ticket-system/ticket-system/index.twig',
			'small-user/login'				=> __DIR__ . '/../view/p-server-cms/auth/login.twig',
			'small-user/logout-page'		=> __DIR__ . '/../view/p-server-cms/auth/logout-page.twig',
            'p-server-cms/paginator'        => __DIR__ . '/../view/helper/paginator.phtml',
            'p-server-cms/navigation'       => __DIR__ . '/../view/helper/navigation.phtml',
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
                    'SmallUser\Entity' => null,
                    'ZfcTicketSystem\Entity' => null
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
             * WARNING for pw lost|country, we need a valid mail
             */
            'mail_confirmation' => false
		],
		'mail' => [
			'from' => 'abcd@example.com',
			'from_name' => 'team',
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
            ],
            /**
             * for more security we can check if the user login from a allowed country
             * WARNING YOU HAVE TO FILL THE "available_countries" TABLE WITH IP COUNTRY MAPPING
             * That is the reason why its default disabled
             */
            'country-check' => false
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
			'country_list'        => 'PServerCMS\Entity\CountryList',
			'donate_log'          => 'PServerCMS\Entity\DonateLog',
			'download_list'       => 'PServerCMS\Entity\DownloadList',
			'ip_block'            => 'PServerCMS\Entity\IpBlock',
			'login_failed'        => 'PServerCMS\Entity\LoginFailed',
			'login_history'       => 'PServerCMS\Entity\LoginHistory',
			'logs'                => 'PServerCMS\Entity\Logs',
			'news'                => 'PServerCMS\Entity\News',
			'page_info'           => 'PServerCMS\Entity\PageInfo',
			'player_history'      => 'PServerCMS\Entity\PlayerHistory',
			'secret_answer'       => 'PServerCMS\Entity\SecretAnswer',
			'secret_question'     => 'PServerCMS\Entity\SecretQuestion',
			'server_info'         => 'PServerCMS\Entity\ServerInfo',
            'user'                => 'PServerCMS\Entity\User',
			'user_block'          => 'PServerCMS\Entity\UserBlock',
			'user_codes'          => 'PServerCMS\Entity\UserCodes',
			'user_extension'      => 'PServerCMS\Entity\UserExtension',
			'user_role'           => 'PServerCMS\Entity\UserRole',
		],
        'navigation' => [
            'home' => [
                'name' => 'Home',
                'route' => [
                    'name' => 'PServerCMS',
                ],
            ],
            'download' => [
                'name' => 'Download',
                'route' => [
                    'name' => 'PServerCMS/site-download',
                ],
            ],
            'ranking' => [
                'name' => 'Ranking',
                'route' => [
                    'name' => 'PServerRanking/ranking',
                ],
                'children' => [
                    '1_position' => [
                        'name'  => 'TopPlayer',
                        'route' => [
                            'name' => 'PServerRanking/ranking',
                            'params' => [
                                'action' => 'top-player',
                            ]
                        ],
                    ],
                    '2_position' => [
                        'name'  => 'TopGuild',
                        'route' => [
                            'name' => 'PServerRanking/ranking',
                            'params' => [
                                'action' => 'top-guild',
                            ]
                        ],
                    ],
                ],
            ],
            'server-info' => [
                'name' => 'ServerInfo',
                'route' => [
                    'name' => 'PServerCMS/site-detail',
                ],
                'children' => [
                    '1_position' => [
                        'name'  => 'FAQ',
                        'route' => [
                            'name' => 'PServerCMS/site-detail',
                            'params' => [
                                'type' => 'faq',
                            ]
                        ],
                    ],
                    '2_position' => [
                        'name'  => 'Rules',
                        'route' => [
                            'name' => 'PServerCMS/site-detail',
                            'params' => [
                                'type' => 'rules',
                            ]
                        ],
                    ],
                    '3_position' => [
                        'name'  => 'Guides',
                        'route' => [
                            'name' => 'PServerCMS/site-detail',
                            'params' => [
                                'type' => 'guides',
                            ]
                        ],
                    ],
                    '4_position' => [
                        'name'  => 'Events',
                        'route' => [
                            'name' => 'PServerCMS/site-detail',
                            'params' => [
                                'type' => 'events',
                            ]
                        ],
                    ],
                ],
            ],
        ],
	],
	'authenticationadapter' => [
		'odm_default' => [
			'objectManager' => 'doctrine.documentmanager.odm_default',
			'identityClass' => 'PServerCMS\Entity\User',
			'identityProperty' => 'username',
			'credentialProperty' => 'password',
			'credentialCallable' => 'PServerCMS\Entity\User::hashPassword'
		],
	],
	'small-user' => [
		'user_entity' => [
			'class' => 'PServerCMS\Entity\User'
		],
        'login' => [
            'route' => 'PServerCMS'
        ]
	],
	'payment-api' => [
		'ban-time' => '946681200',
	],
    'zfc-ticket-system' => [
        'entity' => [
            'ticket_category' => 'PServerCMS\Entity\TicketSystem\TicketCategory',
            'ticket_entry' => 'PServerCMS\Entity\TicketSystem\TicketEntry',
            'ticket_subject' => 'PServerCMS\Entity\TicketSystem\TicketSubject',
            'user' => 'PServerCMS\Entity\User',
        ],
    ],
];
