<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * News
 */
class News extends EntityRepository {

	/**
	 * @param $limit
	 *
	 * @return \PServerCMS\Entity\News[]
	 */
	public function getActiveNews( $limit = null ) {
		$query = $this->createQueryBuilder('p')
			->select('p')
			->where('p.active = :active')
			->setParameter('active', '1')
			->orderBy('p.created','desc')
			->getQuery();

		if(!$limit){
			$limit = 5;
		}

		$query = $query->setMaxResults($limit);

		return $query->getResult();
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