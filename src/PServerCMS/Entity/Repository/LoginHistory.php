<?php


namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Entity\UserInterface;

class LoginHistory extends EntityRepository
{

    /**
     * @param UserInterface $user
     * @param int $days
     * @return \PServerCMS\Entity\LoginHistory[]
     */
    public function getLastLoginList4User(UserInterface $user, $days = 10)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.created', 'desc')
            ->setMaxResults($days)
            ->getQuery();

        return $query->getResult();
    }

}