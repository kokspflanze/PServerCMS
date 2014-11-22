<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;
use PServerCMS\Keys\Caching;
use PServerCMS\Service\ServiceManager;

/**
 * Downloadlist
 *
 * @ORM\Table(name="downloadList")
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\DownloadList")
 * @ORM\HasLifecycleCallbacks
 */
class Downloadlist {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="dId", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $did;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="hoster", type="string", length=50, nullable=false)
	 */
	private $hoster;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="link", type="text", nullable=false)
	 */
	private $link;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="memo", type="text", nullable=false)
	 */
	private $memo;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="active", type="string", nullable=false)
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
		$cachingHelperService->delItem(Caching::Download);
	}

	/**
	 * Get did
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->did;
	}

	/**
	 * Set hoster
	 *
	 * @param string $hoster
	 *
	 * @return Downloadlist
	 */
	public function setHoster( $hoster ) {
		$this->hoster = $hoster;

		return $this;
	}

	/**
	 * Get hoster
	 *
	 * @return string
	 */
	public function getHoster() {
		return $this->hoster;
	}

	/**
	 * Set link
	 *
	 * @param string $link
	 *
	 * @return Downloadlist
	 */
	public function setLink( $link ) {
		$this->link = $link;

		return $this;
	}

	/**
	 * Get link
	 *
	 * @return string
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * Set memo
	 *
	 * @param string $memo
	 *
	 * @return Downloadlist
	 */
	public function setMemo( $memo ) {
		$this->memo = $memo;

		return $this;
	}

	/**
	 * Get memo
	 *
	 * @return string
	 */
	public function getMemo() {
		return $this->memo;
	}

	/**
	 * Set active
	 *
	 * @param string $active
	 *
	 * @return Downloadlist
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
	 * Set sortkey
	 *
	 * @param integer $sortkey
	 *
	 * @return Downloadlist
	 */
	public function setSortkey( $sortkey ) {
		$this->sortkey = $sortkey;

		return $this;
	}

	/**
	 * Get sortkey
	 *
	 * @return integer
	 */
	public function getSortkey() {
		return $this->sortkey;
	}
}
