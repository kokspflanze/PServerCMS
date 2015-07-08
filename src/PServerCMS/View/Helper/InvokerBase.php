<?php

namespace PServerCMS\View\Helper;

use PServerCMS\Helper\HelperOptions;
use PServerCMS\Helper\HelperService;
use PServerCMS\Helper\HelperServiceLocator;
use PServerRanking\Helper\Service;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvokerBase extends AbstractHelper
{
    use HelperServiceLocator, HelperService, HelperOptions, Service, \GameBackend\Helper\Service;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     */
    public function __construct( ServiceLocatorInterface $serviceLocatorInterface )
    {
        $this->setServiceLocator( $serviceLocatorInterface );
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return $this
     */
    protected function setServiceLocator( ServiceLocatorInterface $serviceLocator )
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    /**
     * @return \Zend\Mvc\Router\Http\TreeRouteStack
     */
    protected function getRouterService()
    {
        return $this->getService('router');
    }

    /**
     * @return \Zend\Http\PhpEnvironment\Request
     */
    protected function getRequestService()
    {
        return $this->getService('request');
    }

} 