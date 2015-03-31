<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpBlock
 *
 * @ORM\Table(name="ip_block")
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\IpBlock")
 */
class IpBlock
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
	 * @ORM\Column(name="expire", type="datetime", nullable=false)
	 */
	private $expire;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime", nullable=false)
	 */
	private $created;

	public function __construct( ) {
		$this->created = new \DateTime();
	}

	/**
	 * Get bid
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
	 * @return IpBlock
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
	 * Set expire
	 *
	 * @param \DateTime $expire
	 *
	 * @return IpBlock
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
	 * @return IpBlock
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
}
