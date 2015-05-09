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
    /** @var array  */
    protected $mockedMethods = [];
    /** @var  object */
    protected $class;

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
        if (!$this->class) {
            /** @var \Zend\ServiceManager\ServiceManagerAwareInterface */
            $this->class = new $this->className;
            $this->class->setServiceManager($this->serviceManager);
        }

        return $this->class;
    }

    /**
     * @return array
     */
    protected function getMockedMethods()
    {
        return $this->mockedMethods;
    }
}