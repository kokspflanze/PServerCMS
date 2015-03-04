<?php


namespace PServerCMS\Service;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class Ranking extends InvokableBase
{
    /**
     * @param int $page
     *
     * @return Paginator|\GameBackend\Entity\Game\CharacterInterface[]
     */
    public function getTopPlayer( $page = 1 )
    {
        $topCharacter = $this->getGameBackendService()->getTopCharacter();

        return $this->getPaginator4QueryBuilder($topCharacter, $page);
    }

    /**
     * @param     $queryBuilder
     * @param int $page
     *
     * @return Paginator
     */
    protected function getPaginator4QueryBuilder( $queryBuilder, $page = 1 )
    {
        $adapter = new DoctrineAdapter(new ORMPaginator($queryBuilder));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(25);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }
}