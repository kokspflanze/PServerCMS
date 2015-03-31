<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * IPBlock
 */
class UserBlock extends EntityRepository
{
    /**
     * @param      $userId
     * @param null $expireTime
     *
     * @return null|\PServerCMS\Entity\UserBlock
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isUserAllowed( $userId, $expireTime = null )
    {
        if(!$expireTime){
            $expireTime = new \DateTime();
        }

        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.user = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('p.expire >= :expireTime')
            ->setParameter('expireTime', $expireTime)
            ->orderBy('p.expire', 'desc')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}