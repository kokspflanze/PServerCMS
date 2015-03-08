<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Helper\DateTimer;

/**
 * LoginFaild
 */
class LoginFaild extends EntityRepository
{

	/**
	 * @param $sIP
	 * @param $iTimeInterVal
	 *
	 * @return int
	 */
	public function getNumberOfFailLogins4Ip( $sIP, $iTimeInterVal )
    {
        $oQuery = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.ip = :ipString')
            ->setParameter('ipString', $sIP)
            ->andWhere('p.created >= :expireTime')
            ->setParameter('expireTime', DateTimer::getDateTime4TimeStamp(time()-$iTimeInterVal))
            ->getQuery();
        /**
         * TODO remove count
         */
        return count($oQuery->getArrayResult());
    }
}
