<?php


namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Logs extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getLogQueryBuilder()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p', 'user')
            ->leftJoin('p.usersUsrid', 'user')
            ->orderBy('p.created', 'desc');

        return $query;
    }

    /**
     * @param \PServerCMS\Entity\Users $users
     */
    public function setLogsNull4User( $user )
    {
        $query = $this->createQueryBuilder('p')
            ->update()
            ->set('p.usersUsrid', ':userNull')
            ->setParameter('userNull', null)
            ->where('p.usersUsrid = :user')
            ->setParameter('user', $user)
            ->getQuery();

        $query->execute();
    }

}