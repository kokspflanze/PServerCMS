<?php


namespace PServerCMS\Options;

use Zend\Stdlib\AbstractOptions;

class PasswordOptions extends AbstractOptions
{
    protected $__strictMode__ = false;

    /**
     * @var bool
     */
    protected $differentPasswords = true;

    /**
     * @var bool
     */
    protected $secretQuestion = false;

    /**
     * @var array
     */
    protected $length = [
        'min' => 6,
        'max' => 32
    ];

    /**
     * @return boolean
     */
    public function isDifferentPasswords()
    {
        return (bool)$this->differentPasswords;
    }

    /**
     * @param boolean $differentPasswords
     * @return PasswordOptions
     */
    public function setDifferentPasswords($differentPasswords)
    {
        $this->differentPasswords = $differentPasswords;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSecretQuestion()
    {
        return (bool)$this->secretQuestion;
    }

    /**
     * @param boolean $secretQuestion
     * @return PasswordOptions
     */
    public function setSecretQuestion($secretQuestion)
    {
        $this->secretQuestion = $secretQuestion;

        return $this;
    }

    /**
     * @return array
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param array $length
     * @return PasswordOptions
     */
    public function setLength(array $length)
    {
        $this->length = $length;

        return $this;
    }


}