<?php


namespace PServerCMSTest\Validator;


use PServerCMSTest\Util\TestBase;

class StriposExistsTest extends TestBase
{
    /** @var string */
    protected $className = '\PServerCMS\Validator\StriposExists';

    public function testIsValid()
    {
        $config = [
            'pserver' => [
                'blacklisted' => [
                    'email' => [
                        'foo.bar'
                    ],
                ],
            ],
        ];
        $this->serviceManager->setService('Config', $config);

        $class = $this->getClass();

        $class->__construct($this->serviceManager, $class::TYPE_EMAIL);

        $this->assertTrue($class->isValid('foo@bar.sucks'));
        $this->assertEmpty($class->getMessages());
    }

    public function testIsValidFalse()
    {
        $config = [
            'pserver' => [
                'blacklisted' => [
                    'email' => [
                        'foo.bar'
                    ],
                ],
            ],
        ];
        $this->serviceManager->setService('Config', $config);

        $class = $this->getClass();

        $class->__construct($this->serviceManager, $class::TYPE_EMAIL);

        $this->assertFalse($class->isValid('bar.sucks@foo.bar'));
        $this->assertNotEmpty($class->getMessages());
    }


    /**
     * @return \PServerCMS\Validator\StriposExists|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getClass()
    {
        if (!$this->class) {
            /** @var \Zend\ServiceManager\ServiceManagerAwareInterface $class */
            $class = $this->getMockBuilder($this->className)
                ->disableOriginalConstructor()
                ->setMethods($this->getMockedMethodList())
                ->getMock();

            $this->class = $class;
        }

        return $this->class;
    }
}
