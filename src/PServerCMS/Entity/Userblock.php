<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;
use PServerCMS\Helper\DateTimer;

/**
 * Userblock
 *
 * @ORM\Table(name="userBlock", indexes={@ORM\Index(name="fk_userBlock_users1_idx", columns={"users_usrId"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\UserBlock")
 */
class Userblock {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="bId", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $bid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="reason", type="text", nullable=false)
	 */
	private $reason;

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

	/**
	 * @var \PServerCMS\Entity\Users
	 *
	 * @ORM\ManyToOne(targetEntity="PServerCMS\Entity\Users")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="users_usrId", referencedColumnName="usrId")
	 * })
	 */
	private $user;

	public function __construct( ) {
		$this->created = new \DateTime();
	}

	/**
	 * Get bid
	 *
	 * @return integer
	 */
	public function getBid() {
		return $this->bid;
	}

	/**
	 * Set reason
	 *
	 * @param string $reason
	 *
	 * @return Userblock
	 */
	public function setReason( $reason ) {
		$this->reason = $reason;

		return $this;
	}

	/**
	 * Get reason
	 *
	 * @return string
	 */
	public function getReason() {
		return $this->reason;
	}

	/**
	 * Set expire
	 *
	 * @param $expire
	 *
	 * @return Userblock
	 */
	public function setExpire( $expire ) {
		if(!$expire instanceof \DateTime){
			$expire = DateTimer::getDateTime4TimeStamp($expire);
		}
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
	 * @return Userblock
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
	 * Set usersUsrid
	 *
	 * @param \PServerCMS\Entity\Users $usersUsrid
	 *
	 * @return Userblock
	 * @deprecated use setUser
	 */
	public function setUsersUsrid( \PServerCMS\Entity\Users $usersUsrid = null ) {
		return $this->setUser($usersUsrid);
	}

	/**
	 * @param Users $user
	 *
	 * @return $this
	 */
	public function setUser( Users $user ){
		$this->user = $user;

		return $this;
	}

	/**
	 * Get usersUsrid
	 *
	 * @return \PServerCMS\Entity\Users
	 * @deprecated use getUser
	 */
	public function getUsersUsrid() {
		return $this->getUser();
	}

	/**
	 * @param Users $user
	 *
	 * @return $this
	 */
	public function getUser(){
		return $this->user;
	}
}
