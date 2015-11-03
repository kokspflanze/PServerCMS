<?php

namespace PServerCMS\Service;

use \Zend\ServiceManager\ServiceLocatorInterface;

class ServiceManager
{

    /** @var ServiceLocatorInterface */
    protected static $_instance;

    /**
     * @return ServiceLocatorInterface
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            throw new \Exception('ServiceManager not defined');
        }

        return self::$_instance;
    }

    /**
     * @param ServiceLocatorInterface $serviceManager
     */
    public static function setInstance(ServiceLocatorInterface $serviceManager)
    {
        self::$_instance = $serviceManager;
    }

} 