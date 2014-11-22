<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AvailableCountries extends EntityRepository{

    public function isCountryAllowedForUser($iUserId, $sCountry){

        $oQuery = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.usersUsrid = :userId')
            ->setParameter('userId', $iUserId)
            ->getQuery();

        $aResult = $oQuery->getResult();
        foreach($aResult as $oCurRslt){
            /** @var \PServerCMS\Entity\AvailableCountries $oCurRslt */
            if($oCurRslt->getCntry() == $sCountry){
                return true;
            }
        }
        return false;
    }
}