<?php


namespace PServerCMS\Service;


class Logs extends InvokableBase
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getLogDataSource()
    {
        /** @var \PServerCMS\Entity\Repository\Logs $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getLogs());
        return $repository->getLogQueryBuilder();
    }
}