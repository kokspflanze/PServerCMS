<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Loginfaild
 *
 * @ORM\Table(name="loginFaild")
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\LoginFaild")
 */
class Loginfaild {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="fId", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $fid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="username", type="string", length=45, nullable=false)
	 */
	private $username;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="ip", type="string", length=60, nullable=false)
	 */
	private $ip;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="created", type="datetime", nullable=false)
	 */
	private $created;

	public function __construct( ) {
		$this->created = new \DateTime();
	}

	/**
	 * Get fid
	 *
	 * @return integer
	 */
	public function getFid() {
		return $this->fid;
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return Loginfaild
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
	 * Set ip
	 *
	 * @param string $ip
	 *
	 * @return Loginfaild
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
	 * @param integer $created
	 *
	 * @return Loginfaild
	 */
	public function setCreated( $created ) {
		$this->created = $created;

		return $this;
	}

	/**
	 * Get created
	 *
	 * @return integer
	 */
	public function getCreated() {
		return $this->created;
	}
}
