<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 20.08.14
 * Time: 18:24
 */

namespace PServerCMS\Service;

use \Zend\ServiceManager\ServiceLocatorInterface;

class ServiceManager {

	/** @var ServiceLocatorInterface */
	protected static $_instance;

	/**
	 * @return ServiceLocatorInterface
	 * @throws \Exception
	 */
	public static function getInstance() {
		if( null === self::$_instance ) {
			throw new \Exception('ServiceManager not defined');
		}

		return self::$_instance;
	}

	/**
	 * @param ServiceLocatorInterface $serviceManager
	 */
	public static function setInstance( ServiceLocatorInterface $serviceManager ){
		self::$_instance = $serviceManager;
	}

} 