<?php


namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;


class Users extends EntityRepository {

    /**
     * @param $userId
     *
     * @return null|\PServerCMS\Entity\Users
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUser4Id( $userId )
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.usrid = :usrid')
            ->setParameter('usrid', $userId)
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * @param $username
     *
     * @return null|\PServerCMS\Entity\Users
     */
    public function getUser4UserName( $username )
    {
        return $this->findOneBy( array( 'username' => $username ) );
    }

    /**
     * @param $username
     *
     * @return bool|null null for user not exists and bool for roles exists or not
     */
    public function isUserValid4UserName( $username )
    {
        $result = false;
        $user = $this->getUser4UserName($username);
        if (!$user) {
            $result = null;
        } elseif ($user->getRoles() ){
            $result = true;
        }

        return $result;
    }

}