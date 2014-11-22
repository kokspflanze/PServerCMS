<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * News
 */
class News extends EntityRepository {

	/**
	 * @return null|\PServerCMS\Entity\News[]
	 */
	public function getActiveNews() {
		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->where('p.active = :active')
			->setParameter('active', '1')
			->orderBy('p.created','desc')
			->setMaxResults(5)
			->getQuery();
		return $oQuery->getResult();
	}

	/**
	 * @return null|\PServerCMS\Entity\News[]
	 */
	public function getNews() {
		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->orderBy('p.created','desc')
			->getQuery();
		return $oQuery->getResult();
	}

	/**
	 * @param $newsId
	 *
	 * @return null|\PServerCMS\Entity\News
	 */
	public function getNews4Id( $newsId ){
		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->where('p.nid = :newsId')
			->setParameter('newsId', $newsId)
			->getQuery();
		return $oQuery->getOneOrNullResult();
	}
}