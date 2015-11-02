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
     * @var int
     */
    protected $maxPlayer = 1000;

    /**
     * @var array
     */
    protected $imagePlayer = [
        'font_color' => [
            0,
            0,
            0
        ],
        'background_color' => [
            237,
            237,
            237
        ],
    ];

    /**
     * @var bool
     */
    protected $ticketAnswerMail = false;

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
    public function setDatetime(array $datetime)
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
    public function setCache(array $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxPlayer()
    {
        return $this->maxPlayer;
    }

    /**
     * @param int $maxPlayer
     * @return GeneralOptions
     */
    public function setMaxPlayer($maxPlayer)
    {
        $this->maxPlayer = $maxPlayer;

        return $this;
    }

    /**
     * @return array
     */
    public function getImagePlayer()
    {
        return $this->imagePlayer;
    }

    /**
     * @param array $imagePlayer
     * @return $this
     */
    public function setImagePlayer($imagePlayer)
    {
        $this->imagePlayer = $imagePlayer;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isTicketAnswerMail()
    {
        return $this->ticketAnswerMail;
    }

    /**
     * @param boolean $ticketAnswerMail
     * @return $this
     */
    public function setTicketAnswerMail($ticketAnswerMail)
    {
        $this->ticketAnswerMail = $ticketAnswerMail;
        return $this;
    }


}