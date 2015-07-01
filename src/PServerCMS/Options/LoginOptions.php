<?php


namespace PServerCMS\Options;

use Zend\Stdlib\AbstractOptions;

class LoginOptions extends AbstractOptions
{
    protected $__strictMode__ = false;

    /**
     * @var array
     */
    protected $exploit = [
        'time' => 900, //in seconds
        'try' => 5
    ];

    /**
     * @var bool
     */
    protected $countryCheck = false;

    /**
     * @var array
     */
    protected $secretLoginRoleList = [];

    /**
     * @return array
     */
    public function getExploit()
    {
        return $this->exploit;
    }

    /**
     * @param array $exploit
     * @return LoginOptions
     */
    public function setExploit( $exploit )
    {
        $this->exploit = $exploit;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCountryCheck()
    {
        return $this->countryCheck;
    }

    /**
     * @param boolean $countryCheck
     * @return LoginOptions
     */
    public function setCountryCheck( $countryCheck )
    {
        $this->countryCheck = $countryCheck;

        return $this;
    }

    /**
     * @return array
     */
    public function getSecretLoginRoleList()
    {
        return $this->secretLoginRoleList;
    }

    /**
     * @param array $secretLoginRoleList
     * @return LoginOptions
     */
    public function setSecretLoginRoleList( $secretLoginRoleList )
    {
        $this->secretLoginRoleList = $secretLoginRoleList;

        return $this;
    }


}