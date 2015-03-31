<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AvailableCountries extends EntityRepository{

    /**
     * @param $userId
     * @param $country
     *
     * @return bool
     */
    public function isCountryAllowedForUser($userId, $country){

        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery();

        $data = $query->getResult();
        $return = false;

        foreach($data as $availableCountries){
            /** @var \PServerCMS\Entity\AvailableCountries $availableCountries */
            if($availableCountries->getCntry() == $country){
                $return = true;
                break;
            }
        }
        return $return;
    }
}