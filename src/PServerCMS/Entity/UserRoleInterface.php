<?php


namespace PServerCMS\Entity;


use SmallUser\Entity\UserRoleInterface as SmallUserUserRoleInterface;

interface UserRoleInterface extends SmallUserUserRoleInterface
{
    /**
     * @return int
     */
    public function getId();

}