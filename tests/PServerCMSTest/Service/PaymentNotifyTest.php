<?php


namespace PServerCMSTest\Service;


use PaymentAPI\Provider\Request;
use PServerCMSTest\Util\TestBase;

class PaymentNotifyTest extends TestBase
{
    /** @var  string */
    protected $className = '\PServerCMS\Service\PaymentNotify';

    /**
     * @expectedException \Exception
     */
    public function testSuccessNoUser()
    {
        $this->mockedMethodList = [
            'getUser4Id'
        ];

        /** @var \PHPUnit_Framework_MockObject_MockObject|\PServerCMS\Service\PaymentNotify $class */
        $class = $this->getClass();
        $class->expects($this->any())
            ->method('getUser4Id')
            ->willReturn(null);

        $request = new Request();

        $class->success($request);
    }
}
