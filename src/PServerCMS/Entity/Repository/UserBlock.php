<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Entity\UserInterface;

/**
 * IPBlock
 */
class UserBlock extends EntityRepository
{
    /**
     * @param UserInterface $user
     * @param null          $expireTime
     * @return null|\PServerCMS\Entity\UserBlock
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isUserAllowed( UserInterface $user, $expireTime = null )
    {
        if(!$expireTime){
            $expireTime = new \DateTime();
        }

        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.user = :user')
            ->setParameter('user', $user )
            ->andWhere('p.expire >= :expireTime')
            ->setParameter('expireTime', $expireTime)
            ->orderBy('p.expire', 'desc')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}