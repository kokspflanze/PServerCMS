<?php


namespace PServerCMSTest\View\Helper;

use PServerCMSTest\Util\TestBase;

class TimerWidgetTest extends TestBase
{
    /** @var string */
    protected $className = 'PServerCMS\View\Helper\TimerWidget';

    public function testInvoke()
    {
        $this->mockedMethodList = [
            'getView'
        ];
        /** @var \PServerCMS\View\Helper\TimerWidget|\PHPUnit_Framework_MockObject_MockObject $class */
        $class = $this->getClass();

        $phpRenderer = $this->getMockBuilder('\Zend\View\Renderer\PhpRenderer')
            ->setMethods([])
            ->getMock();

        $class->expects($this->any())
            ->method('getView')
            ->willReturn($phpRenderer);

        $result = $class->__invoke();

        $this->assertNull($result);
    }

    /**
     * @return \Zend\ServiceManager\ServiceManagerAwareInterface
     */
    protected function getClass()
    {
        /** @var \Zend\ServiceManager\ServiceManagerAwareInterface $class */
        $class = $this->getMockBuilder($this->className)
            ->setConstructorArgs([$this->serviceManager])
            ->setMethods($this->getMockedMethodList())
            ->getMock();

        return $class;
    }
}
