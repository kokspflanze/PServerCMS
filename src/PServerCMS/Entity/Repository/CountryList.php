<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Helper\Ip;

/**
 * Class CountryList
 * @package PServerCMS\Entity\Repository
 */
class CountryList extends EntityRepository
{

    /**
     * @param $ip
     *
     * @return \PServerCMS\Entity\CountryList
     */
    public function getCountryCode4Ip( $ip )
    {
        $query  = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.ipMin <= :sIp')
            ->andWhere('p.ipMax >= :sIp')
            ->setParameter('sIp', Ip::getIp2Decimal($ip))
            ->getQuery();

        /** @var \PServerCMS\Entity\CountryList $result */
        $result = $query->getOneOrNullResult();
        if(!$result){
            return 'ZZZ';
        }
        return $result->getCntry();
    }

    /**
     * @param string $cntry
     *
     * @return string
     */
    public function getDescription4CountryCode( $cntry ) {

        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.cntry = :sCntry')
            ->setParameter('sCntry', $cntry)
            ->setMaxResults(1)
            ->getQuery();

        /** @var \PServerCMS\Entity\CountryList $result */
        $result = $query->getOneOrNullResult();

		// no country found
		if(!$result){
			return 'ZZZ';
		}

        return $result->getCountry();
    }
}