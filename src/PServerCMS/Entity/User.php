<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;
use PServerCMS\Service\ServiceManager;
use Zend\Crypt\Password\Bcrypt;

/**
 * User
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\User")
 */
class User implements UserInterface
{
    /**
     * @var integer
     * @ORM\Column(name="usrId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $usrId;

    /**
     * @var integer
     * @ORM\Column(name="backendId", type="integer", nullable=true)
     */
    private $backendId;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     */
    private $username = '';

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=60, nullable=false)
     */
    private $password = '';

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email = '';

    /**
     * @var string
     * @ORM\Column(name="createIP", type="string", length=60, nullable=false)
     */
    private $createip = '127.0.0.1';

    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \Doctrine\Common\Collections\Collection|UserRole[]
     * @ORM\ManyToMany(targetEntity="PServerCMS\Entity\UserRole", mappedBy="user")
     */
    private $userRole;

    /**
     * @var \Doctrine\Common\Collections\Collection|UserExtension[]
     * @ORM\OneToMany(targetEntity="UserExtension", mappedBy="user")
     * @ORM\JoinColumn(name="usrId", referencedColumnName="userId")
     */
    private $userExtension;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userRole      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userExtension = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created       = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->usrId;
    }

    /**
     * @param int $usrId
     * @return User
     */
    public function setId( $usrId )
    {
        $this->usrId = $usrId;

        return $this;
    }

    /**
     * @return int
     */
    public function getBackendId()
    {
        return $this->backendId;
    }

    /**
     * @param $backendId
     * @return $this
     */
    public function setBackendId( $backendId )
    {
        $this->backendId = $backendId;

        return $this;
    }

    /**
     * Set username
     * @param string $username
     * @return User
     */
    public function setUsername( $username )
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     * @param string $password
     * @return User
     */
    public function setPassword( $password )
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     * @param string $email
     * @return User
     */
    public function setEmail( $email )
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createIp
     * @param string $createIp
     * @return User
     */
    public function setCreateIp( $createIp )
    {
        $this->createip = $createIp;

        return $this;
    }

    /**
     * Get createIp
     * @return string
     */
    public function getCreateIp()
    {
        return $this->createip;
    }

    /**
     * Set created
     * @param \DateTime $created
     * @return User
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
     * Add userRole
     * @param UserRoleInterface $userRole
     * @return User
     */
    public function addUserRole( UserRoleInterface $userRole )
    {
        $this->userRole[] = $userRole;

        return $this;
    }

    /**
     * Remove userRole
     * @param UserRoleInterface $userRole
     */
    public function removeUserRole( UserRoleInterface $userRole )
    {
        $this->userRole->removeElement( $userRole );
    }

    /**
     * Get userRole
     * @return \Doctrine\Common\Collections\Collection|UserRoleInterface[]
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @return UserRoleInterface[]
     */
    public function getRoles()
    {
        return $this->userRole->getValues();
    }

    /**
     * Add userExtension
     * @param UserExtension $userExtension
     * @return User
     */
    public function addUserExtension( $userExtension )
    {
        $this->userExtension[] = $userExtension;

        return $this;
    }

    /**
     * Remove userExtension
     * @param UserExtension $userExtension
     */
    public function removeUserExtension( $userExtension )
    {
        $this->userExtension->removeElement( $userExtension );

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserExtension()
    {
        return $this->userExtension;
    }

    /**
     * @param UserInterface $entity
     * @param               $plaintext
     * @return bool
     */
    public static function hashPassword( $entity, $plaintext )
    {
        /** @var \PServerCMS\Service\User $userService */
        $userService = ServiceManager::getInstance()->get( 'small_user_service' );
        if (!$userService->isSamePasswordOption()) {
            return $userService->getGameBackendService()->isPasswordSame( $entity->getPassword(), $plaintext );
        }

        $bcrypt = new Bcrypt();

        return $bcrypt->verify( $plaintext, $entity->getPassword() );
    }

}