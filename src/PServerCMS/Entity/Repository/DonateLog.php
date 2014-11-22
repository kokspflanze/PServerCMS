<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 09.10.2014
 * Time: 22:28
 */

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
			->setParameter('success', \PServerCMS\Entity\Donatelog::StatusSuccess)
			->setMaxResults(1)
			->getQuery();

		return (bool) $oQuery->getOneOrNullResult();
	}
} 