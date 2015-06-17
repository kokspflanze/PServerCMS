<?php


namespace PServerCMS\Helper;

use Zend\ServiceManager\ServiceLocatorInterface;

trait HelperBasic
{
    /** @var  array */
    protected $serviceCache;

    /**
     * @return ServiceLocatorInterface
     */
    abstract public function getServiceManager();

    /**
     * @param $serviceName
     *
     * @return array|object
     */
    protected function getService( $serviceName )
    {
        if (!isset( $this->serviceCache[$serviceName] )) {
            $this->serviceCache[$serviceName] = $this->getServiceManager()->get( $serviceName );
        }

        return $this->serviceCache[$serviceName];
    }

}