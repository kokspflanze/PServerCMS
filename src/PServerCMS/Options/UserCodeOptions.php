<?php


namespace PServerCMS\Options;

use Zend\Stdlib\AbstractOptions;

class UserCodeOptions extends AbstractOptions
{
    protected $__strictMode__ = false;

    /** @var array */
    protected $expire = [
        'general' => 86400
    ];

    /**
     * @return array
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param array $expire
     * @return $this
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;
        return $this;
    }

}