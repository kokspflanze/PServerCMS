<?php


namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;


class Users extends EntityRepository {

    /**
     * @param $userId
     *
     * @return null|\PServerCMS\Entity\Users
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUser4Id( $userId )
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.usrid = :usrid')
            ->setParameter('usrid', $userId)
            ->getQuery();
        return $query->getOneOrNullResult();
    }

}