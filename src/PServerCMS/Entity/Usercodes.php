<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usercodes
 *
 * @ORM\Table(name="userCodes", indexes={@ORM\Index(name="fk_userCodes_users1_idx", columns={"users_usrId"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\Usercodes")
 */
class Usercodes {

	const Type_Register = 'register';
	const Type_LostPassword = 'password';
    const Type_ConfirmCountry = 'country';
	const Expire_Default = 86400;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="code", type="string", length=32, nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 */
	private $code;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="type", type="string", length=45, nullable=false)
	 */
	private $type;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="expire", type="datetime", nullable=false)
	 */
	private $expire;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime", nullable=false)
	 */
	private $created;

	/**
	 * @var \PServerCMS\Entity\Users
	 *
	 * @ORM\ManyToOne(targetEntity="PServerCMS\Entity\Users")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="users_usrId", referencedColumnName="usrId")
	 * })
	 */
	private $usersUsrid;

	public function __construct( ) {
		$this->created = new \DateTime();
		$oDateTime = new \DateTime();
		$this->expire = $oDateTime->setTimestamp(time()+static::Expire_Default);
	}


	/**
	 * Set code
	 *
	 * @param string $sCode
	 *
	 * @return Usercodes
	 */
	public function setCode( $sCode ) {
		$this->code = $sCode;

		return $this;
	}

	/**
	 * Get code
	 *
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * Set type
	 *
	 * @param string $type
	 *
	 * @return Usercodes
	 */
	public function setType( $type ) {
		$this->type = $type;

		return $this;
	}

	/**
	 * Get type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set expire
	 *
	 * @param \DateTime $expire
	 *
	 * @return Usercodes
	 */
	public function setExpire( \DateTime $expire ) {
		$this->expire = $expire;

		return $this;
	}

	/**
	 * Get expire
	 *
	 * @return \DateTime
	 */
	public function getExpire() {
		return $this->expire;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 *
	 * @return Usercodes
	 */
	public function setCreated( \DateTime $created ) {
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
	 * Set usersUsrid
	 *
	 * @param \PServerCMS\Entity\Users $usersUsrid
	 *
	 * @return Usercodes
	 * @deprecated
	 */
	public function setUsersUsrid( \PServerCMS\Entity\Users $usersUsrid = null ) {
		return $this->setUser($usersUsrid);
	}


	/**
	 * Set usersUsrid
	 *
	 * @param \PServerCMS\Entity\Users $user
	 *
	 * @return Usercodes
	 */
	public function setUser( \PServerCMS\Entity\Users $user = null ){
		$this->usersUsrid = $user;

		return $this;
	}

	/**
	 * Get usersUsrid
	 *
	 * @return \PServerCMS\Entity\Users
	 * @deprecated
	 */
	public function getUsersUsrid() {
		return $this->getUser();
	}

	/**
	 * Get usersUsrid
	 *
	 * @return \PServerCMS\Entity\Users
	 */
	public function getUser() {
		return $this->usersUsrid;
	}
}
