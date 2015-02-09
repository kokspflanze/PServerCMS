<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;
use PServerCMS\Keys\Caching;
use PServerCMS\Service\ServiceManager;

/**
 * Ipblock
 *
 * @ORM\Table(name="serverInfo")
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\ServerInfo")
 * @ORM\HasLifecycleCallbacks
 */
class ServerInfo {

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
	 * @ORM\Column(name="icon", type="string", length=255, nullable=false)
	 */
	private $icon;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="label", type="string", length=255, nullable=false)
	 */
	private $label;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="memo", type="string", length=255, nullable=false)
	 */
	private $memo;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="active", type="string", columnDefinition="ENUM('0', '1')", nullable=false)
	 */
	private $active;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="sortkey", type="integer", nullable=false)
	 */
	private $sortkey;

	/**
	 * @ORM\PreFlush()
	 */
	public function preFlush() {
		/** @var \PServerCMS\Service\CachingHelper $cachingHelperService */
		$cachingHelperService = ServiceManager::getInstance()->get('pserver_cachinghelper_service');
		$cachingHelperService->delItem(Caching::SERVER_INFO);
	}

	/**
	 * @param string $active
	 *
	 * @return ServerInfo
	 */
	public function setActive( $active ) {
		$this->active = $active;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * @param string $icon
	 *
	 * @return ServerInfo
	 */
	public function setIcon( $icon ) {
		$this->icon = $icon;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIcon() {
		return $this->icon;
	}
	/**
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param string $label
	 *
	 * @return ServerInfo
	 */
	public function setLabel( $label ) {
		$this->label = $label;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param string $memo
	 *
	 * @return ServerInfo
	 */
	public function setMemo( $memo ) {
		$this->memo = $memo;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMemo() {
		return $this->memo;
	}

	/**
	 * @param int $sortkey
	 *
	 * @return ServerInfo
	 */
	public function setSortkey( $sortkey ) {
		$this->sortkey = $sortkey;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSortkey() {
		return $this->sortkey;
	}

} 