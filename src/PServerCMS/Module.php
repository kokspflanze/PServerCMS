<?php

namespace PServerCMS;

use PServerCMS\Service\ServiceManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\AbstractPluginManager;

class Module
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap( MvcEvent $e )
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach( $eventManager );

        ServiceManager::setInstance( $e->getApplication()->getServiceManager() );
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'pserverformerrors' => 'PServerCMS\View\Helper\FormError'
            ],
            'factories'  => [
                'sidebarWidget' => function ( AbstractPluginManager $pluginManager ) {
                    return new View\Helper\SideBarWidget( $pluginManager->getServiceLocator() );
                },
                'formWidget'    => function ( AbstractPluginManager $pluginManager ) {
                    return new View\Helper\FormWidget( $pluginManager->getServiceLocator() );
                },
                'playerHistory' => function ( AbstractPluginManager $pluginManager ) {
                    return new View\Helper\PlayerHistory( $pluginManager->getServiceLocator() );
                },
                'active'        => function ( AbstractPluginManager $pluginManager ) {
                    return new View\Helper\Active( $pluginManager->getServiceLocator() );
                },
                'donateSum'     => function ( AbstractPluginManager $pluginManager ) {
                    return new View\Helper\DonateSum( $pluginManager->getServiceLocator() );
                },
                'donateCounter' => function ( AbstractPluginManager $pluginManager ) {
                    return new View\Helper\DonateCounter( $pluginManager->getServiceLocator() );
                },
                'navigationWidgetPServerCMS' => function ( AbstractPluginManager $pluginManager ) {
                    return new View\Helper\NavigationWidget( $pluginManager->getServiceLocator() );
                },
            ]
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'pserver_user_register_form'  => function ( $sm ) {
                    /** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
                    $form = new Form\Register( $sm );
                    $form->setInputFilter( new Form\RegisterFilter( $sm ) );
                    return $form;
                },
                'pserver_user_password_form'  => function ( $sm ) {
                    /** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
                    $form = new Form\Password( $sm );
                    $form->setInputFilter(
                        new Form\PasswordFilter( $sm )
                    );
                    return $form;
                },
                'pserver_user_pwlost_form'    => function ( $sm ) {
                    /** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
                    /** @var $repositoryUser \Doctrine\Common\Persistence\ObjectRepository */
                    /** @var Options\EntityOptions $entityOptions */
                    $entityOptions = $sm->get( 'pserver_entity_options' );
                    $repositoryUser = $sm->get( 'Doctrine\ORM\EntityManager' )->getRepository( $entityOptions->getUser() );
                    $form           = new Form\PwLost( $sm );
                    $form->setInputFilter(
                        new Form\PwLostFilter(
                            new Validator\ValidUserExists( $repositoryUser )
                        )
                    );
                    return $form;
                },
                'pserver_user_changepwd_form' => function () {
                    $form = new Form\ChangePwd();
                    $form->setInputFilter( new Form\ChangePwdFilter() );
                    return $form;
                },
                'pserver_entity_options'      => function ( $sm ) {
                    /** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
                    $config = $sm->get( 'Configuration' );
                    return new Options\EntityOptions( $config['pserver']['entity'] );
                },
                'pserver_mail_options'         => function ( $sm ) {
                    /** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
                    $config = $sm->get( 'Configuration' );
                    return new Options\MailOptions( $config['pserver']['mail'] );
                },
                'zfcticketsystem_ticketsystem_new_form'   => function ( $sm ) {
                    /** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
                    $form = new \ZfcTicketSystem\Form\TicketSystem( $sm );
                    $form->setInputFilter( new Form\TicketSystemFilter( $sm ) );
                    return $form;
                },
                'zfcticketsystem_ticketsystem_entry_form' => function ( $sm ) {
                    /** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
                    $form = new \ZfcTicketSystem\Form\TicketEntry();
                    $form->setInputFilter( new Form\TicketEntryFilter( $sm ) );
                    return $form;
                },
            ],
        ];
    }

}
