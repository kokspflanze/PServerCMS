<?php


namespace PServerCMSTest\Util;

use PHPUnit_Framework_TestCase as TestCase;
use PServerCMS\Service\ServiceManager;

class TestBase extends TestCase
{
    /** @var  \Zend\ServiceManager\ServiceManager */
    protected $serviceManager;
    /** @var  string */
    protected $className;

    public function setUp()
    {
        parent::setUp();
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
        ServiceManager::setInstance($this->serviceManager);
    }

    /**
     * @param $methodName
     * @return \ReflectionMethod
     */
    protected function getMethod($methodName) {
        $reflection = new \ReflectionClass($this->getClass());
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManagerAwareInterface
     */
    protected function getClass()
    {
        /** @var \Zend\ServiceManager\ServiceManagerAwareInterface $class */
        $class = new $this->className;
        $class->setServiceManager($this->serviceManager);

        return $class;
    }
}