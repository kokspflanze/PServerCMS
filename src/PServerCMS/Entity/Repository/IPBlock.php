<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * IPBlock
 */
class IPBlock extends EntityRepository {

	/**
	 * @return \PServerCMS\Entity\Ipblock
	 */
	public function isIPAllowed( $sIP ) {
		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->where('p.ip = :ipString')
			->setParameter('ipString', $sIP)
			->andWhere('p.expire >= :expireTime')
			->setParameter('expireTime', new \DateTime())
            ->orderBy('p.expire', 'desc')
            ->setMaxResults(1)
			->getQuery();

		return $oQuery->getOneOrNullResult();
	}
}
