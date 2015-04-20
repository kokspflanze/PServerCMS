<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * NEWS
 */
class News extends EntityRepository
{
	/**
	 * @param $limit
	 *
	 * @return \PServerCMS\Entity\News[]
	 */
	public function getActiveNews( $limit = null )
    {
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
    public function getNews()
    {
        return $this->getQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'user')
            ->join('p.user', 'user')
            ->orderBy('p.created','desc');
    }

	/**
	 * @param $newsId
	 *
	 * @return null|\PServerCMS\Entity\News
	 */
	public function getNews4Id( $newsId )
    {
		$query = $this->createQueryBuilder('p')
			->select('p')
			->where('p.id = :newsId')
			->setParameter('newsId', $newsId)
			->getQuery();

		return $query->getOneOrNullResult();
	}
}