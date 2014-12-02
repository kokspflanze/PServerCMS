<?php

namespace PServerCMS;

use PServerCMS\Keys\Entity;
use PServerCMS\Service\ServiceManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\AbstractPluginManager;

class Module {
	public function onBootstrap( MvcEvent $e ) {
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach( $eventManager );

		ServiceManager::setInstance($e->getApplication()->getServiceManager());
	}

	public function getConfig() {
		return include __DIR__ . '/../../config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getViewHelperConfig(){
		return array(
			'invokables' => array(
				'pserverformerrors' => 'PServerCMS\View\Helper\FormError'
			),
			'factories' => array(
				'sidebarWidget' => function(AbstractPluginManager $pluginManager){
					return new View\Helper\SideBarWidget($pluginManager->getServiceLocator());
				},
				'formWidget' => function(AbstractPluginManager $pluginManager){
					return new View\Helper\FormWidget($pluginManager->getServiceLocator());
				},
				'playerHistory' => function(AbstractPluginManager $pluginManager){
					return new View\Helper\PlayerHistory($pluginManager->getServiceLocator());
				},
                'active' => function(AbstractPluginManager $pluginManager){
                    return new View\Helper\Active($pluginManager->getServiceLocator());
                }
			)
		);
	}

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getServiceConfig() {
		return array(
			'factories' => array(
				'pserver_user_register_form' => function($sm){
					/** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
					$form = new Form\Register($sm);
					$form->setInputFilter(new Form\RegisterFilter($sm));
					return $form;
				},
				'pserver_user_password_form' => function($sm){
					/** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
					$form = new Form\Password($sm);
					$form->setInputFilter(new Form\PasswordFilter(
						new Validator\SimilarText( $sm->get('pserver_secret_question') )
					));
					return $form;
				},
				'pserver_user_pwlost_form' => function($sm){
					/** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
					/** @var $repositoryUser \Doctrine\Common\Persistence\ObjectRepository */
					$repositoryUser = $sm->get('Doctrine\ORM\EntityManager')->getRepository(Entity::Users);
					$form = new Form\PwLost();
					$form->setInputFilter(new Form\PwLostFilter(
						new Validator\RecordExists( $repositoryUser, 'username' )
					));
					return $form;
				},
                'pserver_user_changepwd_form' => function(){
					$form = new Form\ChangePwd();
					$form->setInputFilter(new Form\ChangePwdFilter());
					return $form;
                },
			),
		);
	}

}
