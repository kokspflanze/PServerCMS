<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * IPBlock
 */
class UserBlock extends EntityRepository {

    /**
     * @param $userId
	 * @return \PServerCMS\Entity\UserBlock
     */
    public function isUserAllowed( $userId ) {
        $oQuery = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.user = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('p.expire >= :expireTime')
            ->setParameter('expireTime', new \DateTime())
            ->orderBy('p.expire', 'desc')
            ->setMaxResults(1)
            ->getQuery();

        return $oQuery->getOneOrNullResult();
    }
}