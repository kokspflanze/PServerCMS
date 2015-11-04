<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;
use PServerCMS\Keys\Caching;
use PServerCMS\Service\ServiceManager;

/**
 * DownloadList
 * @ORM\Table(name="download_list")
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\DownloadList")
 * @ORM\HasLifecycleCallbacks
 */
class DownloadList
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="hoster", type="string", length=50, nullable=false)
     */
    private $hoster;

    /**
     * @var string
     * @ORM\Column(name="link", type="text", nullable=false)
     */
    private $link;

    /**
     * @var string
     * @ORM\Column(name="memo", type="text", nullable=false)
     */
    private $memo;

    /**
     * @var string
     * @ORM\Column(name="active", type="string", nullable=false)
     */
    private $active;

    /**
     * @var integer
     * @ORM\Column(name="sort_key", type="integer", nullable=false)
     */
    private $sortKey;

    /**
     * @ORM\PreFlush()
     */
    public function preFlush()
    {
        /** @var \PServerCMS\Service\CachingHelper $cachingHelperService */
        $cachingHelperService = ServiceManager::getInstance()->get('pserver_cachinghelper_service');
        $cachingHelperService->delItem(Caching::DOWNLOAD);
    }

    /**
     * Get did
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hoster
     * @param string $hoster
     * @return self
     */
    public function setHoster($hoster)
    {
        $this->hoster = $hoster;

        return $this;
    }

    /**
     * Get hoster
     * @return string
     */
    public function getHoster()
    {
        return $this->hoster;
    }

    /**
     * Set link
     * @param string $link
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set memo
     * @param string $memo
     * @return self
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * Get memo
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Set active
     * @param string $active
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set sortKey
     * @param integer $sortKey
     * @return self
     */
    public function setSortKey($sortKey)
    {
        $this->sortKey = $sortKey;

        return $this;
    }

    /**
     * Get sortKey
     * @return self
     */
    public function getSortKey()
    {
        return $this->sortKey;
    }
}
