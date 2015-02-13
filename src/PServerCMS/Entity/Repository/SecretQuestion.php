<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SecretQuestion extends EntityRepository
{

    /**
     * @return \PServerCMS\Entity\SecretQuestion[]|null
     */
    public function getQuestions()
    {
        $query = $this->createQueryBuilder( 'p' )
            ->select( 'p' )
            ->orderBy( 'p.sortKey', 'asc' )
            ->getQuery();


        return $query->getResult();
    }

    /**
     * @param $id
     *
     * @return \PServerCMS\Entity\SecretQuestion[]|null
     */
    public function getQuestion4Id( $id )
    {
        $query = $this->createQueryBuilder( 'p' )
            ->select( 'p' )
            ->where( 'p.id = :id' )
            ->setParameter( 'id', $id )
            ->getQuery();


        return $query->getOneOrNullResult();
    }
} 