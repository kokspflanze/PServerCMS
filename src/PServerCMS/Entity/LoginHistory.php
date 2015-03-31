<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LoginHistory
 *
 * @ORM\Table(name="login_history", indexes={@ORM\Index(name="fk_loginHistory_users1_idx", columns={"users_usrId"})})
 * @ORM\Entity
 */
class LoginHistory
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="ip", type="string", length=60, nullable=false)
	 */
	private $ip;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime", nullable=false)
	 */
	private $created;

	/**
	 * @var UserInterface
	 *
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="users_usrId", referencedColumnName="usrId")
	 * })
	 */
	private $user;

	public function __construct( ) {
		$this->created = new \DateTime();
	}

	/**
	 * Get lid
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set ip
	 *
	 * @param string $ip
	 *
	 * @return self
	 */
	public function setIp( $ip ) {
		$this->ip = $ip;

		return $this;
	}

	/**
	 * Get ip
	 *
	 * @return string
	 */
	public function getIp() {
		return $this->ip;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 *
	 * @return self
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
	 * Set user
	 *
	 * @param UserInterface $user
	 *
	 * @return self
	 */
	public function setUser( UserInterface $user = null ) {
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return UserInterface
	 */
	public function getUser() {
		return $this->user;
	}
}
