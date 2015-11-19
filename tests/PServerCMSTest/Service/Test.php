<?php


namespace PServerCMSTest\Service;


use PServerCMSTest\Util\TestBase;

class Test extends TestBase
{
    /** @var  string */
    protected $className = '\PServerCMS\Service\Format';

    public function testGetCode()
    {
        /** @var \PServerCMS\Service\Format $class */
        $class = $this->getClass();

        $result = $class->getCode(32);
        $this->assertInternalType('string', $result);
        $this->assertEquals(32, strlen($result));
    }


}
