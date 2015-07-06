<?php


namespace PServerCMSTest\Service;


use PServerCMSTest\Util\TestBase;

class TimerTest extends TestBase
{
    /** @var  string */
    protected $className = '\PServerCMS\Service\Timer';

    public function testGetNextTimeSameDay()
    {
        $this->mockedMethodList = [
            'getCurrentTimeStamp'
        ];
        /** @var \PServerCMS\Service\Timer|\PHPUnit_Framework_MockObject_MockObject $class */
        $class = $this->getClass();

        $class->expects($this->any())
            ->method('getCurrentTimeStamp')
            ->willReturn(1437082616);

        $hourList = [
            23, 2
        ];

        $minute = 10;

        $result = $class->getNextTime($hourList, $minute);

        $this->assertEquals(1437088200, $result);
    }

    public function testGetNextTimeNextDay()
    {
        $this->mockedMethodList = [
            'getCurrentTimeStamp'
        ];
        /** @var \PServerCMS\Service\Timer|\PHPUnit_Framework_MockObject_MockObject $class */
        $class = $this->getClass();

        $class->expects($this->any())
            ->method('getCurrentTimeStamp')
            ->willReturn(1438373400);

        $hourList = [
            22 ,15
        ];

        $minute = 10;

        $result = $class->getNextTime($hourList, $minute);

        $this->assertEquals(1438380600, $result);
    }
}
