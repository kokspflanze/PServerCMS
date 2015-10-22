<?php


namespace PServerCMS\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use PServerCMS\Entity\UserInterface;

class UserExtension extends EntityRepository
{

    /**
     * @param UserInterface $user
     */
    public function deleteExtension(UserInterface $user)
    {
        $this->createQueryBuilder('p')
            ->delete()
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute();
    }
}