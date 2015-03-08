<?php


namespace PServerCMS\Service;



class Logs extends InvokableBase
{
    public function getLogDataSource(){
        /** @var \PServerCMS\Entity\Repository\Logs $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getLogs());
        return $repository->getLogQueryBuilder();
    }
}