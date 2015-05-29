<?php


namespace PServerCMSTest\Validator;


use PServerCMSTest\Util\TestBase;

class UserNameBackendNotExistsTest extends TestBase
{
    /** @var string */
    protected $className = '\PServerCMS\Validator\UserNameBackendNotExists';

    public function testIsValid()
    {
        $gameMock = $this->getMockBuilder('\GameBackend\DataService\Mocking')
            ->disableOriginalConstructor()
            ->setMethods(['isUserNameExists'])
            ->getMock();

        $gameMock->expects($this->any())
            ->method('isUserNameExists')
            ->willReturn(false);

        $this->serviceManager->setService('gamebackend_dataservice', $gameMock);
        $class = $this->getClass();

        $result = $class->isValid('foobar');
        $this->assertTrue($result);
        $this->assertEmpty($class->getMessages());
    }

    public function testIsValidFalse()
    {
        $gameMock = $this->getMockBuilder('\GameBackend\DataService\Mocking')
            ->disableOriginalConstructor()
            ->setMethods(['isUserNameExists'])
            ->getMock();

        $gameMock->expects($this->any())
            ->method('isUserNameExists')
            ->willReturn(true);

        $this->serviceManager->setService('gamebackend_dataservice', $gameMock);
        $class = $this->getClass();

        $result = $class->isValid('foobar');

        $this->assertFalse($result);
        $this->assertNotEmpty($class->getMessages());
    }

    /**
     * @return \PServerCMS\Validator\UserNameBackendNotExists|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getClass()
    {
        if (!$this->class) {
            /** @var \Zend\ServiceManager\ServiceManagerAwareInterface $class */
            $class = $this->getMockBuilder($this->className)
                ->setConstructorArgs([$this->serviceManager])
                ->setMethods($this->getMockedMethodList())
                ->getMock();

            $this->class = $class;
        }

        return $this->class;
    }
}
