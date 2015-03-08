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
            ->join('p.usersUsrid', 'user')
            ->orderBy('p.created', 'desc');

        return $query;
    }

}