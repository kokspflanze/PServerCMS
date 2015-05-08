<?php


namespace PServerCMSTest\View\Helper;


use PServerCMSTest\Util\TestBase;

class DateTimeFormatTest extends TestBase
{
    protected $className = 'PServerCMS\View\Helper\DateTimeFormat';

    public function testInvoke()
    {
        /** @var \PServerCMS\View\Helper\DateTimeFormat $class */
        $class = $this->getClass();
        $config = [
            'pserver' => [
                'general' => [
                    'datetime' => [
                        'format' => [
                            'time' => 'Y-m-d'
                        ],
                    ],
                ],
            ],
        ];
        $this->serviceManager->setService('Config', $config);

        $dateTime = new \DateTime();
        $dateTime->setDate(2000, 1, 1);
        $result = $class->__invoke($dateTime);

        $this->assertEquals('2000-01-01', $result);
    }

    /**
     * @return \Zend\ServiceManager\ServiceManagerAwareInterface
     */
    protected function getClass()
    {
        /** @var \Zend\ServiceManager\ServiceManagerAwareInterface $class */
        $class = new $this->className($this->serviceManager);

        return $class;
    }
}
