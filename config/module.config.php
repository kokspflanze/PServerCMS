<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'PServerCMS\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
			'site-detail' => array(
				'type' => 'segment',
				'options' => array(
					'route'    => '/detail-[:type].html',
					'constraints' => array(
						'type'     => '[a-zA-Z]+',
					),
					'defaults' => array(
						'controller'	=> 'PServerCMS\Controller\Site',
						'action'		=> 'page'
					),
				),
			),
			'site-download' => array(
				'type' => 'segment',
				'options' => array(
					'route'    => '/download.html',
					'defaults' => array(
						'controller'	=> 'PServerCMS\Controller\Site',
						'action'		=> 'download'
					),
				),
			),
			'user' => array(
				'type' => 'segment',
				'options' => array(
					'route'    => '/panel/account[/:action].html',
					'constraints' => array(
						'action'     => '[a-zA-Z-]+',
					),
					'defaults' => array(
						'controller'	=> 'PServerCMS\Controller\Account',
						'action'		=> 'index',
					),
				),
			),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /p-server-cms/:controller/:action
			/*
            'p-server-cms' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/p-server-cms',
                    'defaults' => array(
                        '__NAMESPACE__' => 'PServerCMS\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),*/
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
		'factories' => array(
			'pserver_caching_service' => function($sm){
				$cache = \Zend\Cache\StorageFactory::factory(array(
					'adapter' => 'filesystem',
					'options' => array(
						'cache_dir' => __DIR__ . '/../../../../data/cache',
						'ttl' => 86400
					),
					'plugins' => array(
						'exception_handler' => array(
							'throw_exceptions' => false
						),
						'serializer'
					)
				));
				return $cache;
			},
		),
		'invokables' => array(
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
		)
    ),
    'controllers' => array(
        'invokables' => array(
			'PServerCMS\Controller\Index' => 'PServerCMS\Controller\IndexController',
			'SmallUser\Controller\Auth' => 'PServerCMS\Controller\AuthController',
			'PServerCMS\Controller\Auth' => 'PServerCMS\Controller\AuthController',
			'PServerCMS\Controller\Site' => 'PServerCMS\Controller\SiteController',
			'PServerCMS\Controller\Account' => 'PServerCMS\Controller\AccountController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
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
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

	'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
				'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => array(
					'host'     => 'localhost',
					'port'     => '3306',
					'user'     => 'username',
					'password' => 'password',
					'dbname'   => 'dbname',
				),
				'doctrine_type_mappings' => array(
					'enum' => 'string'
				),
			),
		),
		'entitymanager' => array(
			'orm_default' => array(
				'connection'    => 'orm_default',
				'configuration' => 'orm_default'
			),
		),
		'driver' => array(
			'application_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/PServerCMS/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					'PServerCMS\Entity' => 'application_entities'
				),
			),
		),
	),
	'pserver' => array(
		'register' => array(
			'role' => 'user'
		),
		'mail' => array(
			'from' => 'abcd@example.com',
			'fromName' => 'team',
			'subject' => array(
				'register' => 'RegisterMail',
				'password' => 'LostPasswordMail',
				'country' => 'LoginIpMail',
			),
			'basic' => array(
				'name' => 'localhost',
				'host' => 'smtp.example.com',
				'port'=> 587,
				'connection_class' => 'login',
				'connection_config' => array(
					'username' => 'put your username',
					'password' => 'put your password',
					'ssl'=> 'tls',
				),
			),
		),
        'login' => array(
            'exploit' => array(
                'time' => 900, //in seconds
                'try' => 5
            )
        ),
		'password' => array(
			/*
			 * set other pw for web as ingame
			 */
			'different-passwords' => true
		),
		'news' => array(
			'limit' => 5
		),
		'pageinfotype' => array(
			'faq',
			'rules',
			'guides',
			'events'
		),
		'blacklisted' => array(
			'email' => array()
		)
	),
	'authenticationadapter' => array(
		'odm_default' => array(
			'objectManager' => 'doctrine.documentmanager.odm_default',
			'identityClass' => 'PServerCMS\Entity\Users',
			'identityProperty' => 'username',
			'credentialProperty' => 'password',
			'credentialCallable' => 'PServerCMS\Entity\Users::hashPassword'
		),
	),
	'small-user' => array(
		'user_entity' => array(
			'class' => 'PServerCMS\Entity\Users'
		)
	),
	'payment-api' => array(
		'ban-time' => '946681200',
	)
);
