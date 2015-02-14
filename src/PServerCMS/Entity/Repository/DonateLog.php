<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class DonateLog extends EntityRepository {

	/**
	 * @param $transactionId
	 * @param $type
	 *
	 * @return bool
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function isDonateAlreadyAdded( $transactionId, $type ) {

		if(!$transactionId){
			return false;
		}

		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->where('p.transactionId = :transactionId')
			->setParameter('transactionId', $transactionId)
			->andWhere('p.type = :type')
			->setParameter('type', $type)
			->andWhere('p.success = :success')
			->setParameter('success', \PServerCMS\Entity\Donatelog::STATUS_SUCCESS)
			->setMaxResults(1)
			->getQuery();

		return (bool) $oQuery->getOneOrNullResult();
	}
} 