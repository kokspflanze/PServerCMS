<?php

namespace PServerCMS\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvokerBase extends AbstractHelper {
	/** @var ServiceLocatorInterface */
	protected $serviceLocator;
	/** @var \Zend\Authentication\AuthenticationService */
	protected $authService;
	/** @var array */
	protected $configService;
	/** @var \Doctrine\ORM\EntityManager */
	protected $entityManager;
	/** @var \Zend\Cache\Storage\StorageInterface */
	protected $cachingService;
	/** @var \PServerCMS\Service\ServerInfo */
	protected $serverInfoService;
	/** @var \Zend\Mvc\Router\Http\TreeRouteStack */
	protected $routerService;
	/** @var \Zend\Http\PhpEnvironment\Request */
	protected $requestService;
	/** @var \PServerCMS\Service\PlayerHistory */
	protected $playerHistoryService;

	/**
	 * @param ServiceLocatorInterface $serviceLocatorInterface
	 */
	public function __construct(ServiceLocatorInterface $serviceLocatorInterface){
		$this->setServiceLocator($serviceLocatorInterface);
	}

	/**
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator(){
		return $this->serviceLocator;
	}

	/**
	 * @param ServiceLocatorInterface $serviceLocator
	 *
	 * @return $this
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator){
		$this->serviceLocator = $serviceLocator;

		return $this;
	}

	/**
	 * @return \Zend\Authentication\AuthenticationService
	 */
	protected function getAuthService() {
		if (!$this->authService) {
			$this->authService = $this->getServiceLocator()->get('small_user_auth_service');
		}

		return $this->authService;
	}

	/**
	 * @return array
	 */
	protected function getConfigService(){
		if (!$this->configService) {
			$this->configService = $this->getServiceLocator()->get('Config');
		}

		return $this->configService;
	}

	/**
	 * @return \PServerCMS\Service\ServerInfo
	 */
	protected function getServerInfo(){
		if (!$this->serverInfoService) {
			$this->serverInfoService = $this->getServiceLocator()->get('pserver_server_info_service');
		}

		return $this->serverInfoService;
	}

	/**
	 * @return \PServerCMS\Service\PlayerHistory
	 */
	protected function getPlayerHistory(){
		if (!$this->playerHistoryService) {
			$this->playerHistoryService = $this->getServiceLocator()->get('pserver_playerhistory_service');
		}

		return $this->playerHistoryService;
	}

	/**
	 * @return \Zend\Cache\Storage\StorageInterface
	 */
	protected function getCachingService(){
		if (!$this->cachingService) {
			$this->cachingService = $this->getServiceLocator()->get('pserver_caching_service');
		}

		return $this->cachingService;
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	protected function getEntityManager() {
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->entityManager;
	}

	/**
	 * @return \Zend\Mvc\Router\Http\TreeRouteStack
	 */
	protected function getRouterService(){
		if(!$this->routerService){
			$this->routerService = $this->getServiceLocator()->get('router');
		}
		return $this->routerService;
	}

	/**
	 * @return \Zend\Http\PhpEnvironment\Request
	 */
	protected function getRequestService(){
		if(!$this->requestService){
			$this->requestService = $this->getServiceLocator()->get('request');
		}
		return $this->requestService;
	}
} 