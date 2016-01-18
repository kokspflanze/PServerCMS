<?php


namespace PServerCMS\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use PServerCMS\Entity\UserInterface;

class UserExtension extends EntityRepository
{
    /**
     * @param UserInterface $user
     * @param string $key
     */
    public function deleteExtension(UserInterface $user, $key = null)
    {
        $query = $this->createQueryBuilder('p')
            ->delete()
            ->where('p.user = :user')
            ->setParameter('user', $user);

        if ($key) {
            $query->andWhere('p.key = :key')
                ->setParameter('key', $key);
        }

        $query->getQuery()
            ->execute();
    }

}