<?php


namespace PServerCMS\Service;


class UserPanel extends InvokableBase
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getUserListQueryBuilder()
    {
        /** @var \PServerCMS\Entity\Repository\User $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getUser());

        return $repository->getUserListQueryBuilder();
    }
}