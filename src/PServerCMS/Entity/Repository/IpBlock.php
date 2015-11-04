<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * IpBlock
 */
class IpBlock extends EntityRepository
{

    /**
     * @return \PServerCMS\Entity\IpBlock
     */
    public function isIPAllowed($ip)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.ip = :ipString')
            ->setParameter('ipString', $ip)
            ->andWhere('p.expire >= :expireTime')
            ->setParameter('expireTime', new \DateTime())
            ->orderBy('p.expire', 'desc')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
