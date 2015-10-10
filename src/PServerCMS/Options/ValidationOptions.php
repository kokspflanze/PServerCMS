<?php


namespace PServerCMS\Options;

use Zend\Stdlib\AbstractOptions;

class ValidationOptions extends AbstractOptions
{
    protected $__strictMode__ = false;
    /**
     * @var array
     */
    protected $username = [
        'length' => [
            'min' => 3,
            'max' => 16
        ],
    ];

    /**
     * @return array
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param array $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }


}