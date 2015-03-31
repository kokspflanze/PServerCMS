<?php


namespace PServerCMS\Entity;

use GameBackend\Entity\User\UserInterface as GameUserInterface;
use SmallUser\Entity\UsersInterface;
use ZfcTicketSystem\Entity\UserInterface as TicketUserInterface;
use BjyAuthorize\Provider\Role\ProviderInterface;
use SmallUser\Entity\UserRoleInterface;

interface UserInterface extends
    GameUserInterface,
    UsersInterface,
    TicketUserInterface,
    ProviderInterface
{
    /**
     * @param $backendId
     *
     * @return self
     */
    public function setBackendId( $backendId );

    /**
     * @param UserRoleInterface $userRole
     *
     * @return self
     */
    public function addUserRole( UserRoleInterface $userRole);

    /**
     * @return \Doctrine\Common\Collections\Collection|UserRoleInterface[]
     */
    public function getUserRole();

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserExtension();
}