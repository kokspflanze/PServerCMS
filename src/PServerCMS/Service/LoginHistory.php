<?php


namespace PServerCMS\Service;


use PServerCMS\Entity\UserInterface;

class LoginHistory extends InvokableBase
{

    /**
     * @param UserInterface $user
     * @return \PServerCMS\Entity\LoginHistory[]
     */
    public function getHistoryList4User( UserInterface $user )
    {
        /** @var \PServerCMS\Entity\Repository\LoginHistory $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getLoginHistory());
        return $repository->getLastLoginList4User($user);
    }

}