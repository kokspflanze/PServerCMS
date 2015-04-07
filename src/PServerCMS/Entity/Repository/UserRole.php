<?php


namespace PServerCMS\Entity\Repository;


class UserRole extends \SmallUser\Entity\Repository\UserRole
{
    /**
     * @return \PServerCMS\Entity\UserRoleInterface[]|null
     */
    public function getRoles()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return \PServerCMS\Entity\UserRoleInterface|null
     */
    public function getRole4Id( $id )
    {
        return $this->findOneBy(['id' => $id]);
    }
}