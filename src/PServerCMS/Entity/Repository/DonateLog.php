<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Entity\DonateLog as Entity;

class DonateLog extends EntityRepository
{
    /**
     * @param $transactionId
     * @param $type
     *
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isDonateAlreadyAdded( $transactionId, $type )
    {
        if (!$transactionId) {
            return false;
        }

        $query = $this->createQueryBuilder( 'p' )
            ->select( 'p' )
            ->where( 'p.transactionId = :transactionId' )
            ->setParameter( 'transactionId', $transactionId )
            ->andWhere( 'p.type = :type' )
            ->setParameter( 'type', $type )
            ->andWhere( 'p.success = :success' )
            ->setParameter( 'success', Entity::STATUS_SUCCESS )
            ->setMaxResults( 1 )
            ->getQuery();

        return (bool)$query->getOneOrNullResult();
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return array
     */
    public function getDonateHistorySuccess( \DateTime $dateTime )
    {
        $query = $this->createQueryBuilder( 'p' )
            ->select( 'SUM(p.coins) as coins, DATE(p.created) as date, p.type, COUNT(p.coins) as amount' )
            ->where( 'p.success = :success' )
            ->setParameter( 'success', Entity::STATUS_SUCCESS )
            ->andWhere( 'p.created >= :created' )
            ->setParameter( 'created', $dateTime )
            ->groupBy('p.type, date')
            ->orderBy('p.created', 'asc')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return array
     */
    public function getDonationDataSuccess( \DateTime $dateTime )
    {
        $query = $this->createQueryBuilder( 'p' )
            ->select( 'SUM(p.coins) as coins, COUNT(p.coins) as amount' )
            ->where( 'p.success = :success' )
            ->setParameter( 'success', Entity::STATUS_SUCCESS )
            ->andWhere( 'p.created >= :created' )
            ->setParameter( 'created', $dateTime )
            ->orderBy('p.created', 'asc')
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function getDonateTypes(){
        return [
            Entity::TYPE_PAYMENT_WALL,
            Entity::TYPE_SUPER_REWARD
        ];
    }
} 