<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Entity\DonateLog as Entity;
use PServerCMS\Entity\UserInterface;

class DonateLog extends EntityRepository
{
    /**
     * @param $transactionId
     * @param $type
     *
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isDonateAlreadyAdded($transactionId, $type)
    {
        if (!$transactionId) {
            return false;
        }

        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.transactionId = :transactionId')
            ->setParameter('transactionId', $transactionId)
            ->andWhere('p.type = :type')
            ->setParameter('type', $type)
            ->andWhere('p.success = :success')
            ->setParameter('success', Entity::STATUS_SUCCESS)
            ->setMaxResults(1)
            ->getQuery();

        return (bool)$query->getOneOrNullResult($query::HYDRATE_SIMPLEOBJECT);
    }

    /**
     * Group date does not realy work on different DBMS, so we must do that in PHP
     *
     * @param \DateTime $dateTime
     *
     * @return array
     */
    public function getDonateHistorySuccess(\DateTime $dateTime)
    {
        $query = $this->createQueryBuilder('p')
            ->select('
                SUM(p.coins) as coins, p.type, COUNT(p.coins) as amount, p.created'
            )
            ->where('p.success = :success')
            ->setParameter('success', Entity::STATUS_SUCCESS)
            ->andWhere('p.created >= :created')
            ->setParameter('created', $dateTime)
            ->groupBy('p.type, p.created')
            ->orderBy('p.created', 'asc')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return array
     */
    public function getDonationDataSuccess(\DateTime $dateTime)
    {
        $query = $this->createQueryBuilder('p')
            ->select('SUM(p.coins) as coins, COUNT(p.coins) as amount')
            ->where('p.success = :success')
            ->setParameter('success', Entity::STATUS_SUCCESS)
            ->andWhere('p.created >= :created')
            ->setParameter('created', $dateTime)
            ->andWhere('p.type in (:type)')
            ->setParameter(
                'type',
                [Entity::TYPE_PAYMENT_WALL, Entity::TYPE_SUPER_REWARD],
                \Doctrine\DBAL\Connection::PARAM_STR_ARRAY
            )
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function getDonateTypes()
    {
        return [
            Entity::TYPE_PAYMENT_WALL,
            Entity::TYPE_SUPER_REWARD,
            Entity::TYPE_INTERNAL
        ];
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getDonateQueryBuilder()
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'user')
            ->leftJoin('p.user', 'user')
            ->orderBy('p.created', 'desc');
    }

    /**
     * @param UserInterface $user
     * @param int $limit
     * @return \PServerCMS\Entity\DonateLog[]
     */
    public function getDonateHistory4User(UserInterface $user, $limit = 10)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.created', 'desc')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }
} 