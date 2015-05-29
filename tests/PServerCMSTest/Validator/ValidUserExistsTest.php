<?php


namespace PServerCMSTest\Validator;

use PServerCMSTest\Util\TestBase;

class ValidUserExistsTest extends TestBase
{
    protected $className = 'PServerCMS\Validator\ValidUserExists';

    public function testIsValid()
    {
        $this->mockedMethodList = [
            'query'
        ];

        $class = $this->getClass();
        $class->expects($this->any())
            ->method('query')
            ->willReturn(false);

        $this->assertFalse($class->isValid('foo'));
        $method = $this->getMethod('getValue');
        $this->assertEquals('foo', $method->invokeArgs($class, []));
        $this->assertNotEmpty($class->getMessages());
        $this->assertArrayHasKey($class::ERROR_NOT_ACTIVE, $class->getMessages());

        $class = $this->getClass(true);
        $class->expects($this->any())
            ->method('query')
            ->willReturn(null);

        $this->assertFalse($class->isValid('foo'));
        $this->assertNotEmpty($class->getMessages());
        $this->assertArrayHasKey($class::ERROR_NO_RECORD_FOUND, $class->getMessages());

        $class = $this->getClass(true);
        $class->expects($this->any())
            ->method('query')
            ->willReturn(null);

        $class->setKey('NOT_ACTIVE');
        $this->assertTrue($class->isValid('foo'));
        $this->assertEmpty($class->getMessages());
    }

    /**
     * @param bool $newInstance
     * @return \PServerCMS\Validator\ValidUserExists|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getClass($newInstance = false)
    {
        if (!$this->class || $newInstance) {
            $this->class = $this->getMockBuilder($this->className)
                ->disableOriginalConstructor()
                ->setMethods($this->getMockedMethodList())
                ->getMock();
        }

        return $this->class;
    }
}
