<?php


namespace PServerCMS\Entity;

use GameBackend\Entity\User\UserInterface as GameUserInterface;
use SmallUser\Entity\UserInterface as SmallUserInterface;

interface UserInterface extends
    GameUserInterface,
    SmallUserInterface
{
    /**
     * @param $backendId
     *
     * @return self
     */
    public function setBackendId($backendId);

    /**
     * @param UserRoleInterface $userRole
     *
     * @return self
     */
    public function addUserRole(UserRoleInterface $userRole);

    /**
     * @param UserRoleInterface $userRole
     *
     * @return self
     */
    public function removeUserRole(UserRoleInterface $userRole);

    /**
     * @return \Doctrine\Common\Collections\Collection|UserRoleInterface[]
     */
    public function getUserRole();

    /**
     * @return UserRoleInterface[]
     */
    public function getRoles();

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserExtension();
}