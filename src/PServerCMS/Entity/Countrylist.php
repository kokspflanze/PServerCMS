<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Countrylist
 *
 * @ORM\Table(name="countryList")
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\CountryList")
 */
class Countrylist {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="cId", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $cid;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="ipMin", type="integer", nullable=false)
	 */
	private $ipmin;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="ipMax", type="integer", nullable=false)
	 */
	private $ipmax;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="registry", type="string", length=45, nullable=false)
	 */
	private $registry;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="assigned", type="integer", nullable=false)
	 */
	private $assigned;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="ctry", type="string", length=45, nullable=false)
	 */
	private $ctry;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="cntry", type="string", length=45, nullable=false)
	 */
	private $cntry;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="country", type="string", length=255, nullable=false)
	 */
	private $country;


	/**
	 * Get cid
	 *
	 * @return integer
	 */
	public function getCid() {
		return $this->cid;
	}

	/**
	 * Set ipmin
	 *
	 * @param integer $ipmin
	 *
	 * @return Countrylist
	 */
	public function setIpmin( $ipmin ) {
		$this->ipmin = $ipmin;

		return $this;
	}

	/**
	 * Get ipmin
	 *
	 * @return integer
	 */
	public function getIpmin() {
		return $this->ipmin;
	}

	/**
	 * Set ipmax
	 *
	 * @param integer $ipmax
	 *
	 * @return Countrylist
	 */
	public function setIpmax( $ipmax ) {
		$this->ipmax = $ipmax;

		return $this;
	}

	/**
	 * Get ipmax
	 *
	 * @return integer
	 */
	public function getIpmax() {
		return $this->ipmax;
	}

	/**
	 * Set registry
	 *
	 * @param string $registry
	 *
	 * @return Countrylist
	 */
	public function setRegistry( $registry ) {
		$this->registry = $registry;

		return $this;
	}

	/**
	 * Get registry
	 *
	 * @return string
	 */
	public function getRegistry() {
		return $this->registry;
	}

	/**
	 * Set assigned
	 *
	 * @param integer $assigned
	 *
	 * @return Countrylist
	 */
	public function setAssigned( $assigned ) {
		$this->assigned = $assigned;

		return $this;
	}

	/**
	 * Get assigned
	 *
	 * @return integer
	 */
	public function getAssigned() {
		return $this->assigned;
	}

	/**
	 * Set ctry
	 *
	 * @param string $ctry
	 *
	 * @return Countrylist
	 */
	public function setCtry( $ctry ) {
		$this->ctry = $ctry;

		return $this;
	}

	/**
	 * Get ctry
	 *
	 * @return string
	 */
	public function getCtry() {
		return $this->ctry;
	}

	/**
	 * Set cntry
	 *
	 * @param string $cntry
	 *
	 * @return Countrylist
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
	 * Set country
	 *
	 * @param string $country
	 *
	 * @return Countrylist
	 */
	public function setCountry( $country ) {
		$this->country = $country;

		return $this;
	}

	/**
	 * Get country
	 *
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}
}
