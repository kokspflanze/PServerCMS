<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class DownloadList extends EntityRepository
{

    /**
     * @return null|\PServerCMS\Entity\DownloadList[]
     */
    public function getActiveDownloadList()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.active = :active')
            ->setParameter('active', '1')
            ->orderBy('p.sortKey', 'asc')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @return null|\PServerCMS\Entity\DownloadList[]
     */
    public function getDownloadList()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param $id
     *
     * @return null|\PServerCMS\Entity\DownloadList
     */
    public function getDownload4Id($id)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param $downloadId
     * @return mixed
     */
    public function deleteDownloadEntry($downloadId)
    {
        $query = $this->createQueryBuilder('p')
            ->delete($this->getEntityName(), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $downloadId)
            ->getQuery();

        return $query->execute();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->createQueryBuilder('p')
            ->select('p');
    }
}