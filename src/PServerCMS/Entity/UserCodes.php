<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCodes
 * @ORM\Table(name="user_codes", indexes={@ORM\Index(name="fk_userCodes_users1_idx", columns={"users_usrId"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\UserCodes")
 */
class UserCodes
{

    const TYPE_REGISTER = 'register';
    const TYPE_LOST_PASSWORD = 'password';
    const TYPE_CONFIRM_COUNTRY = 'country';
    const EXPIRE_DEFAULT = 86400;

    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=32, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=45, nullable=false)
     */
    private $type;

    /**
     * @var integer
     * @ORM\Column(name="expire", type="datetime", nullable=false)
     */
    private $expire;

    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="PServerCMS\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="users_usrId", referencedColumnName="usrId")
     * })
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $dateTime      = new \DateTime();
        $this->expire  = $dateTime->setTimestamp( time() + static::EXPIRE_DEFAULT );
    }

    /**
     * Set code
     * @param string $sCode
     * @return self
     */
    public function setCode( $sCode )
    {
        $this->code = $sCode;

        return $this;
    }

    /**
     * Get code
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set type
     * @param string $type
     * @return self
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
     * Set expire
     * @param \DateTime $expire
     * @return self
     */
    public function setExpire( \DateTime $expire )
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * Get expire
     * @return \DateTime
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set created
     * @param \DateTime $created
     * @return self
     */
    public function setCreated( \DateTime $created )
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
     * @return self
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
