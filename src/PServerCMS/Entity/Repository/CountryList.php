<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PServerCMS\Helper\Ip;

/**
 * Class CountryList
 * @package PServerCMS\Entity\Repository
 */
class CountryList extends EntityRepository{

    /**
     * @param $sIp
     * @return \PServerCMS\Entity\CountryList
     */
    public function getCountryCode4Ip($sIp) {
        $oQuery  = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.ipmin <= :sIp')
            ->andWhere('p.ipmax >= :sIp')
            ->setParameter('sIp', Ip::getIp2Decimal($sIp))
            ->getQuery();

        /** @var \PServerCMS\Entity\CountryList $oResult */
        $oResult = $oQuery->getOneOrNullResult();
        if(!$oResult){
            return 'ZZZ';
        }
        return $oResult->getCntry();
    }

    /**
     * @param string $sCntry
     * @return string
     */
    public function getDescription4CountryCode($sCntry) {

        $oQuery = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.cntry = :sCntry')
            ->setParameter('sCntry', $sCntry)
            ->setMaxResults(1)
            ->getQuery();

        /** @var \PServerCMS\Entity\CountryList $oResult */
        $oResult = $oQuery->getOneOrNullResult();

		// no country found
		if(!$oResult){
			return 'ZZZ';
		}

        return $oResult->getCountry();
    }
}