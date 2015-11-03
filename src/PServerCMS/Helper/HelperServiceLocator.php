<?php


namespace PServerCMS\Helper;

use Zend\ServiceManager\ServiceLocatorInterface;

trait HelperServiceLocator
{
    use HelperBasic;

    /**
     * @return ServiceLocatorInterface
     */
    public abstract function getServiceLocator();

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceManager()
    {
        return $this->getServiceLocator();
    }

}