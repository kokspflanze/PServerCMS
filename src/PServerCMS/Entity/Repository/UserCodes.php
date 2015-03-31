<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserCodes
 */
class UserCodes extends EntityRepository
{

	/**
	 * @param $code
	 * @param $type
	 *
	 * @return null|\PServerCMS\Entity\UserCodes
	 */
	public function getData4CodeType($code, $type)
    {
		$query = $this->createQueryBuilder('p')
			->select('p')
			->where('p.code = :code')
			->setParameter('code', $code)
			->andWhere('p.expire >= :expire')
			->setParameter('expire', new \DateTime())
			->andWhere('p.type = :type')
			->setParameter('type', $type)
			->getQuery();

		return $query->getOneOrNullResult();
	}

	/**
	 * @param $userId
	 * @param $type
	 *
	 * @return mixed
	 */
	public function deleteCodes4User($userId, $type)
    {
		$query = $this->createQueryBuilder('p')
			->delete('PServerCMS\Entity\UserCodes','p')
			->where('p.user = :user_id')
			->setParameter('user_id', $userId)
			->andWhere('p.type = :type')
			->setParameter('type', $type)
			->getQuery();

		return $query->execute();
	}

    /**
     * @param $code
     *
     * @return null|\PServerCMS\Entity\UserCodes
     */
    public function getCode( $code )
    {
        return $this->findOneBy(array('code' => $code));
    }

    /**
     * @param int $limit
     *
     * @return \PServerCMS\Entity\UserCodes[]
     */
    public function getExpiredCodes( $limit = 100 )
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->andWhere('p.expire < :expire')
            ->setParameter('expire', new \DateTime())
            ->orderBy('p.expire', 'asc')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }
}
