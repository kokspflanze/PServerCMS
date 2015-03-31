<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;


class PageInfo extends EntityRepository
{

	/**
	 * @return \PServerCMS\Entity\PageInfo
	 */
	public function getPageData4Type( $type )
    {
		$query = $this->createQueryBuilder('p')
			->select('p')
			->where('p.type = :type')
			->setParameter('type', $type)
			->orderBy('p.created', 'desc')
			->setMaxResults(1)
			->getQuery();

		return $query->getOneOrNullResult();
	}
} 