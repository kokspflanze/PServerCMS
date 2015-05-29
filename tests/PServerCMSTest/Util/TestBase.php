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
    /** @var array|null  */
    protected $mockedMethodList = null;
    /** @var  \PHPUnit_Framework_MockObject_MockObject */
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
     * @return \Zend\ServiceManager\ServiceManagerAwareInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getClass()
    {
        if (!$this->class) {
            /** @var \Zend\ServiceManager\ServiceManagerAwareInterface $class */
            $class = $this->getMockBuilder($this->className)
                ->disableOriginalConstructor()
                ->setMethods($this->getMockedMethodList())
                ->getMock();

            $class->setServiceManager($this->serviceManager);

            $this->class = $class;
        }

        return $this->class;
    }

    /**
     * @return array|null
     */
    protected function getMockedMethodList()
    {
        return $this->mockedMethodList;
    }
}