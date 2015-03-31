<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Entity\UserInterface;


class SecretAnswer extends EntityRepository
{
	/**
	 * @return \PServerCMS\Entity\SecretAnswer|null
	 */
	public function getAnswer4UserId( $userId )
    {
		$query = $this->createQueryBuilder('p')
			->select('p')
			->where('p.user = :user')
			->setParameter('user', $userId)
			->getQuery();

		return $query->getOneOrNullResult();
	}

    /**
     * @param UserInterface $user
     */
    public function deleteAnswer4User( $user )
    {
        $this->createQueryBuilder('p')
            ->delete()
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute();
    }
} 