<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use PServerCMS\Keys\Caching;
use PServerCMS\Service\ServiceManager;

/**
 * Ipblock
 *
 * @ORM\Table(name="pageInfo")
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\PageInfo")
 * @ORM\HasLifecycleCallbacks
 */
class PageInfo {

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
	 * @ORM\Column(name="type", type="string", length=255, nullable=false)
	 */
	private $type;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255, nullable=false)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="memo", type="text", nullable=false)
	 */
	private $memo;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime", nullable=false)
	 */
	private $created;

	/**
	 * @ORM\PostPersist()
	 */
	public function postPersist( LifecycleEventArgs $eventArgs ) {
		/** @var PageInfo $entity */
		$entity = $eventArgs->getEntity();

		/** @var \PServerCMS\Service\CachingHelper $cachingHelperService */
		$cachingHelperService = ServiceManager::getInstance()->get('pserver_cachinghelper_service');
		$cachingHelperService->delItem(Caching::PAGE_INFO . '_' . $entity->getType());
		//$em->getUnitOfWork()->getS
	}

	public function __construct( ) {
		$this->created = new \DateTime();
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param string $type
	 *
	 * @return PageInfo
	 */
	public function setType( $type ) {
		$this->type = $type;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $title
	 *
	 * @return PageInfo
	 */
	public function setTitle( $title ) {
		$this->title = $title;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $memo
	 *
	 * @return PageInfo
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
	 * @param \DateTime $created
	 *
	 * @return PageInfo
	 */
	public function setCreated( $created ) {
		$this->created = $created;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreated() {
		return $this->created;
	}

} 