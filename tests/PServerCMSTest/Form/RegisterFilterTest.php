<?php


namespace PServerCMSTest\Form;


use PServerCMSTest\Util\TestBase;

class RegisterFilterTest extends TestBase
{
    /** @var string */
    protected $className = '\PServerCMS\Form\RegisterFilter';

    public function testIsValid()
    {
        $this->mockedMethodList = [
            'getUsernameValidator',
            'getUserNameBackendNotExistsValidator'
        ];

        $noRecordExistsMock = $this->getMockBuilder('PServerCMS\Validator\NoRecordExists')
            ->disableOriginalConstructor()
            ->setMethods(['isValid'])
            ->getMock();

        $noRecordExistsMock->expects($this->any())
            ->method('isValid')
            ->willReturn(true);

        $UserNameBackendNotExistsMock = $this->getMockBuilder('PServerCMS\Validator\UserNameBackendNotExists')
            ->disableOriginalConstructor()
            ->setMethods(['isValid'])
            ->getMock();

        $UserNameBackendNotExistsMock->expects($this->any())
            ->method('isValid')
            ->willReturn(true);

        $class = $this->getClass();

        $class->expects($this->any())
            ->method('getUsernameValidator')
            ->willReturn($noRecordExistsMock);

        $class->expects($this->any())
            ->method('getUserNameBackendNotExistsValidator')
            ->willReturn($UserNameBackendNotExistsMock);

        $class->__construct($this->serviceManager);

        $class->setData([
            'username' => 'fodfgo',
            'email' => 'fodfgo@travel.com',
            'emailVerify' => 'fodfgo@travel.com',
            'password' => 'fodfgo',
            'passwordVerify' => 'fodfgo',
        ]);

        $this->assertTrue($class->isValid());
    }

    /**
     * @return \PServerCMS\Form\RegisterFilter|\PHPUnit_Framework_MockObject_MockObject
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
