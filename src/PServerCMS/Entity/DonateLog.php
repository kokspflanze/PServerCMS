<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DonateLog
 * @ORM\Table(name="donate_log", indexes={@ORM\Index(name="fk_donateLog_users1_idx", columns={"users_usrId"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\DonateLog")
 */
class DonateLog
{

    const TYPE_PAYMENT_WALL = 'paymentwall';
    const TYPE_SUPER_REWARD = 'superreward';

    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 0;

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="`type`", type="string", length=45, nullable=false)
     */
    private $type = '';

    /**
     * @var string
     * @ORM\Column(name="transaction_id", type="string", length=255, nullable=false)
     */
    private $transactionId = '';

    /**
     * @var string
     * @ORM\Column(name="success", type="string", nullable=false)
     */
    private $success = '';

    /**
     * @var integer
     * @ORM\Column(name="coins", type="integer", nullable=false)
     */
    private $coins = '';

    /**
     * @var string
     * @ORM\Column(name="`desc`", type="text", nullable=false)
     */
    private $desc = '';

    /**
     * @var string
     * @ORM\Column(name="ip", type="string", length=60, nullable=false)
     */
    private $ip = '';

    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var UserInterface
     * @ORM\Column(nullable=true)
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="users_usrId", referencedColumnName="usrId")
     * })
     */
    private $user;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * Get did
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set transactionId
     * @param string $transactionId
     * @return DonateLog
     */
    public function setTransactionId( $transactionId )
    {
        $this->transactionId = (string) $transactionId;

        return $this;
    }

    /**
     * Get transactionId
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set type
     * @param string $type
     * @return DonateLog
     */
    public function setType( $type )
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set success
     * @param string $success
     * @return DonateLog
     */
    public function setSuccess( $success )
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Get success
     * @return string
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set coins
     * @param integer $coins
     * @return DonateLog
     */
    public function setCoins( $coins )
    {
        $this->coins = $coins;

        return $this;
    }

    /**
     * Get coins
     * @return integer
     */
    public function getCoins()
    {
        return $this->coins;
    }

    /**
     * Set desc
     * @param string $desc
     * @return DonateLog
     */
    public function setDesc( $desc )
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Get desc
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Set ip
     * @param string $ip
     * @return DonateLog
     */
    public function setIp( $ip )
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set created
     * @param \DateTime $created
     * @return DonateLog
     */
    public function setCreated( $created )
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set user
     * @param UserInterface $user
     * @return DonateLog
     */
    public function setUser( UserInterface $user = null )
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
