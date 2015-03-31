<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Helper\DateTimer;

/**
 * LoginFailed
 */
class LoginFailed extends EntityRepository
{

	/**
	 * @param $ip
	 * @param $timeInterVal
	 *
	 * @return int
	 */
	public function getNumberOfFailLogin4Ip( $ip, $timeInterVal )
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.ip = :ipString')
            ->setParameter('ipString', $ip)
            ->andWhere('p.created >= :expireTime')
            ->setParameter('expireTime', DateTimer::getDateTime4TimeStamp(time()-$timeInterVal))
            ->getQuery();
        /**
         * TODO remove count
         */
        return count($query->getArrayResult());
    }
}
