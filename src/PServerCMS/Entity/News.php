<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;
use PServerCMS\Keys\Caching;
use PServerCMS\Service\ServiceManager;

/**
 * News
 *
 * @ORM\Table(name="news", indexes={@ORM\Index(name="fk_news_users1_idx", columns={"users_usrId"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\News")
 * @ORM\HasLifecycleCallbacks
 */
class News {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="nId", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $nid;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=100, nullable=false)
	 */
	private $title;

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

	/**
	 * @ORM\PreFlush()
	 */
	public function preFlush( ) {
		/** @var \PServerCMS\Service\CachingHelper $cachingHelperService */
		$cachingHelperService = ServiceManager::getInstance()->get('pserver_cachinghelper_service');
		$cachingHelperService->delItem(Caching::News);
	}

	public function __construct( ) {
		$this->created = new \DateTime();
	}

	/**
	 * Get nid
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->nid;
	}

	/**
	 * @param $id
	 *
	 * @return News
	 */
	public function setId( $id ) {
		$this->nid = $id;
		return $this;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 *
	 * @return News
	 */
	public function setTitle( $title ) {
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Set memo
	 *
	 * @param string $memo
	 *
	 * @return News
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
	 * @return News
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
	 * @return News
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
	 * @return News
	 */
	public function setUsersUsrid( \PServerCMS\Entity\Users $usersUsrid = null ) {
		$this->usersUsrid = $usersUsrid;

		return $this;
	}

	/**
	 * @param Users $user
	 *
	 * @return News
	 */
	public function setUser( Users $user){
		return $this->setUsersUsrid($user);
	}

	/**
	 * Get usersUsrid
	 *
	 * @return \PServerCMS\Entity\Users
	 */
	public function getUsersUsrid() {
		return $this->usersUsrid;
	}

	/**
	 * @return \PServerCMS\Entity\Users
	 */
	public function getUser() {
		return $this->getUsersUsrid();
	}

}
