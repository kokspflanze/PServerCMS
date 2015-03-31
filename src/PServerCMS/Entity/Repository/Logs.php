<?php


namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Entity\UserInterface;

class Logs extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getLogQueryBuilder()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p', 'user')
            ->leftJoin('p.user', 'user')
            ->orderBy('p.created', 'desc');

        return $query;
    }

    /**
     * @param UserInterface $users
     */
    public function setLogsNull4User( UserInterface $user )
    {
        $query = $this->createQueryBuilder('p')
            ->update()
            ->set('p.user', ':userNull')
            ->setParameter('userNull', null)
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery();

        $query->execute();
    }

}