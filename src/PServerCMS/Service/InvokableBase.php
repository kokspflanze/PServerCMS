<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 18.08.14
 * Time: 22:42
 */

namespace PServerCMS\Service;

use SmallUser\Service\InvokableBase as UserBase;

class InvokableBase extends UserBase {

	/** @var \Zend\Cache\Storage\StorageInterface */
	protected $cachingService;
	/** @var  CachingHelper */
	protected $cachingHelperService;
	/** @var  \GameBackend\DataService\DataServiceInterface */
	protected $gameBackendService;
	/** @var  ConfigRead */
	protected $configReadService;
	/** @var  UserBlock */
	protected $userBlockService;
	/** @var array */
	private $aConfig;

	/**
	 * @return array
	 */
	protected function getConfigData(){
		if(!$this->aConfig){
			$this->aConfig = $this->getServiceManager()->get('Config');
		}
		return $this->aConfig;
	}

	/**
	 * @return \Zend\Cache\Storage\StorageInterface
	 */
	protected function getCachingService(){
		if (!$this->cachingService) {
			$this->cachingService = $this->getServiceManager()->get('pserver_caching_service');
		}

		return $this->cachingService;
	}

	/**
	 * @return CachingHelper
	 */
	protected function getCachingHelperService(){
		if (!$this->cachingHelperService) {
			$this->cachingHelperService = $this->getServiceManager()->get('pserver_cachinghelper_service');
		}

		return $this->cachingHelperService;
	}

	/**
	 * @return \GameBackend\DataService\DataServiceInterface
	 */
	protected function getGameBackendService() {
		if (!$this->gameBackendService) {
			$this->gameBackendService = $this->getServiceManager()->get('gamebackend_dataservice');
		}

		return $this->gameBackendService;
	}

	/**
	 * TODO refactoring
	 * @param $userId
	 *
	 * @return null|\PServerCMS\Entity\Users
	 */
	protected function getUser4Id( $userId ){
		$entityManager = $this->getEntityManager();
		return $entityManager->getRepository('PServerCMS\Entity\Users')->findOneBy(array('usrid' => $userId));
	}

	/**
	 * @return ConfigRead
	 */
	protected function getConfigService() {
		if (!$this->configReadService) {
			$this->configReadService = $this->getServiceManager()->get('pserver_configread_service');
		}

		return $this->configReadService;
	}

	/**
	 * @return UserBlock
	 */
	protected function getUserBlockService() {
		if (!$this->userBlockService) {
			$this->userBlockService = $this->getServiceManager()->get('pserver_user_block_service');
		}

		return $this->userBlockService;
	}

} 