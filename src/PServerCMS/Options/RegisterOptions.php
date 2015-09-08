<?php


namespace PServerCMS\Options;

use Zend\Stdlib\AbstractOptions;

class RegisterOptions extends AbstractOptions
{
    protected $__strictMode__ = false;

    /** @var string */
    protected $role = 'user';

    /** @var bool */
    protected $mailConfirmation = false;

    /** @var bool */
    protected $duplicateEmail = true;

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isMailConfirmation()
    {
        return $this->mailConfirmation;
    }

    /**
     * @param boolean $mailConfirmation
     * @return $this
     */
    public function setMailConfirmation($mailConfirmation)
    {
        $this->mailConfirmation = $mailConfirmation;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDuplicateEmail()
    {
        return $this->duplicateEmail;
    }

    /**
     * @param boolean $duplicateEmail
     * @return $this
     */
    public function setDuplicateEmail($duplicateEmail)
    {
        $this->duplicateEmail = $duplicateEmail;
        return $this;
    }


}