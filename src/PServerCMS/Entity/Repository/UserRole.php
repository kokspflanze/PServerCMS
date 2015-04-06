<?php


namespace PServerCMS\Entity\Repository;


class UserRole extends \SmallUser\Entity\Repository\UserRole
{
    /**
     * @return \PServerCMS\Entity\UserRole[]|null
     */
    public function getRoles()
    {
        return $this->findAll();
    }
}