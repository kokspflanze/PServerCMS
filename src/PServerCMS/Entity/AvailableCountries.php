<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AvailableCountries
 *
 * @ORM\Table(name="availableCountrys", indexes={@ORM\Index(name="fk_availableCountrys_users1_idx", columns={"users_usrId"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\AvailableCountries")
 */
class AvailableCountries {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="acId", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $acid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="cntry", type="string", length=45, nullable=false)
	 */
	private $cntry;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="active", type="string", nullable=false)
	 */
	private $active;

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
		$this->active = '1';
	}

	/**
	 * Get acid
	 *
	 * @return integer
	 */
	public function getAcid() {
		return $this->acid;
	}

	/**
	 * Set cntry
	 *
	 * @param string $cntry
	 *
	 * @return AvailableCountries
	 */
	public function setCntry( $cntry ) {
		$this->cntry = $cntry;

		return $this;
	}

	/**
	 * Get cntry
	 *
	 * @return string
	 */
	public function getCntry() {
		return $this->cntry;
	}

	/**
	 * Set active
	 *
	 * @param string $active
	 *
	 * @return AvailableCountries
	 */
	public function setActive( $active ) {
		$this->active = $active;

		return $this;
	}

	/**
	 * Get active
	 *
	 * @return string
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 *
	 * @return AvailableCountries
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
	 * @return AvailableCountries
	 */
	public function setUsersUsrid( \PServerCMS\Entity\Users $usersUsrid = null ) {
		$this->usersUsrid = $usersUsrid;

		return $this;
	}

	/**
	 * Get usersUsrid
	 *
	 * @return \PServerCMS\Entity\Users
	 */
	public function getUsersUsrid() {
		return $this->usersUsrid;
	}
}
