<?php


namespace PServerCMS\Options;

use Zend\Stdlib\AbstractOptions;

class GeneralOptions extends AbstractOptions
{
    protected $__strictMode__ = false;

    /**
     * @var array
     */
    protected $datetime = [
        'format' => [
            'time' => 'Y-m-d H:i'
        ],
    ];

    /**
     * @var array
     */
    protected $cache = [
        'enable' => false
    ];

    /**
     * @return array
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param array $datetime
     * @return GeneralOptions
     */
    public function setDatetime( array $datetime )
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return array
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param array $cache
     * @return GeneralOptions
     */
    public function setCache( array $cache )
    {
        $this->cache = $cache;

        return $this;
    }


}