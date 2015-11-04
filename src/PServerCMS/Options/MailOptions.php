<?php


namespace PServerCMS\Options;

use Zend\Stdlib\AbstractOptions;


class MailOptions extends AbstractOptions
{
    protected $__strictMode__ = false;

    /**
     * @var string
     */
    protected $from = 'abcd@example.com';

    /**
     * @var string
     */
    protected $fromName = 'team';

    /**
     * @var array
     */
    protected $subject = [
        'register' => 'RegisterMail',
        'password' => 'LostPasswordMail',
        'country' => 'LoginIpMail',
    ];

    /**
     * @var array
     */
    protected $basic = [
        'name' => 'localhost',
        'host' => 'smtp.example.com',
        'port' => 587,
        'connection_class' => 'login',
        'connection_config' => [
            'username' => 'put your username',
            'password' => 'put your password',
            'ssl' => 'tls',
        ],
    ];

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return MailOptions
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     * @return MailOptions
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return array
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param array $subject
     * @return MailOptions
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function getBasic()
    {
        return $this->basic;
    }

    /**
     * @param array $basic
     * @return MailOptions
     */
    public function setBasic($basic)
    {
        $this->basic = $basic;

        return $this;
    }


}