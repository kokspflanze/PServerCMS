<?php


namespace PServerCMS\Service;


class UserPanel extends InvokableBase
{
    public function getUserListQueryBuilder()
    {
        /** @var \PServerCMS\Entity\Repository\Users $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getUsers());
        return $repository->getUserListQueryBuilder();
    }
}