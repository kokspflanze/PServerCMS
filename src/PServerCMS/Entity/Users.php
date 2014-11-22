<?php

namespace PServerCMS\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\ORM\Mapping as ORM;
use GameBackend\Entity\User\UserInterface;
use PServerCMS\Service\ServiceManager;
use SmallUser\Entity\UsersInterface;
use Zend\Crypt\Password\Bcrypt;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})})
 * @ORM\Entity
 */
class Users implements
	ProviderInterface, 
	UsersInterface,
	UserInterface {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="usrId", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $usrid;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="backendId", type="integer", nullable=true)
	 */
	private $backendId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="username", type="string", length=45, nullable=false)
	 */
	private $username = '';

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=60, nullable=false)
	 */
	private $password = '';

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255, nullable=false)
	 */
	private $email = '';

	/**
	 * @var string
	 *
	 * @ORM\Column(name="createIP", type="string", length=60, nullable=false)
	 */
	private $createip = '127.0.0.1';

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime", nullable=false)
	 */
	private $created;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 *
	 * @ORM\ManyToMany(targetEntity="PServerCMS\Entity\UserRole", mappedBy="usersUsrid")
	 */
	private $userRole;

	/**
	 * @var \PServerCMS\Entity\Userexstension
	 *
	 * @ORM\OneToMany(targetEntity="PServerCMS\Entity\Userexstension", mappedBy="usersUsrid")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="usrId", referencedColumnName="users_usrId")
	 * })
	 */
	private $userExtension;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->userRole = new \Doctrine\Common\Collections\ArrayCollection();
		$this->userExtension = new \Doctrine\Common\Collections\ArrayCollection();
		$this->created = new \DateTime();
	}


	/**
	 * Get usrid
	 *
	 * @return integer
	 */
	public function getUsrid() {
		return $this->usrid;
	}

	/**
	 * @return int
	 */
	public function getId(){
		return $this->getUsrid();
	}

	/**
	 * @return int
	 */
	public function getBackendId(){
		return $this->backendId;
	}

	/**
	 * @param $iBackendId
	 *
	 * @return $this
	 */
	public function setBackendId( $iBackendId ){
		$this->backendId = $iBackendId;

		return $this;
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return Users
	 */
	public function setUsername( $username ) {
		$this->username = $username;

		return $this;
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 *
	 * @return Users
	 */
	public function setPassword( $password ) {
		$this->password = $password;

		return $this;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 *
	 * @return Users
	 */
	public function setEmail( $email ) {
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Set createip
	 *
	 * @param string $createip
	 *
	 * @return Users
	 */
	public function setCreateip( $createip ) {
		$this->createip = $createip;

		return $this;
	}

	/**
	 * Get createip
	 *
	 * @return string
	 */
	public function getCreateip() {
		return $this->createip;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 *
	 * @return Users
	 */
	public function setCreated( $created ) {
		$this->created = $created;

		return $this;
	}

	/**
	 * Get created
	 *
	 * @return \DateTime
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * Add userRole
	 *
	 * @param $userRole
	 *
	 * @return Users
	 */
	public function addUserRole( $userRole ) {
		$this->userRole[] = $userRole;

		return $this;
	}

	/**
	 * Remove userRole
	 *
	 * @param $userRole
	 */
	public function removeUserRole( $userRole ) {
		$this->userRole->removeElement( $userRole );
	}

	/**
	 * Get userRole
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getUserRole() {
		return $this->userRole;
	}

	/**
	 * @return \Zend\Permissions\Acl\Role\RoleInterface[]
	 */
	public function getRoles() {
		return $this->userRole->getValues();
	}


	/**
	 * Add userExtension
	 *
	 * @param Userexstension $userExtension
	 *
	 * @return Users
	 */
	public function addUserExtension( $userExtension ) {
		$this->userExtension[] = $userExtension;

		return $this;
	}

	/**
	 * Remove userExtension
	 *
	 * @param Userexstension $userExtension
	 */
	public function removeUserExtension( $userExtension ) {
		$this->userExtension->removeElement( $userExtension );

		return $this;
	}

	/**
	 * @return Userexstension
	 */
	public function getUserExtension(){
		return $this->userExtension;
	}

	/**
	 * @param Users $entity
	 * @param       $plaintext
	 *
	 * @return bool
	 */
	public static function hashPassword( $entity, $plaintext ){

		/** @var \PServerCMS\Service\User $userService */
		$userService = ServiceManager::getInstance()->get('small_user_service');
		if(!$userService->isSamePasswordOption()){
			return $userService->getGameBackendService()->isPasswordSame($entity->getPassword(), $plaintext);
		}

		$oBcrypt = new Bcrypt();
		return $oBcrypt->verify($plaintext, $entity->getPassword());
	}

}