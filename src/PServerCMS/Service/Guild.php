<?php


namespace PServerCMS\Service;

use Zend\Paginator\Paginator;

class Guild extends InvokableBase
{
    /**
     * @param $id
     *
     * @return \GameBackend\Entity\Game\GuildInterface|null
     */
    public function getGuild4Id( $id )
    {
        return $this->getGameBackendService()->getGuild4Id($id);
    }

    /**
     * @param     $id
     * @param int $page
     *
     * @return null|Paginator
     */
    public function getGuildMember4GuildId( $id, $page = 1 )
    {
        $guild = $this->getGameBackendService()->getGuild4Id($id);

        $result = null;
        if($guild){
            /** @var \Doctrine\ORM\PersistentCollection $member */
            $member = $guild->getMember();
            $result = $this->getPaginator4QueryBuilder($member->toArray(), $page);
        }

        return $result;
    }

    /**
     * @param array $array
     * @param int   $page
     *
     * @return Paginator
     */
    protected function getPaginator4QueryBuilder( $array, $page = 1 )
    {
        $adapter = new \Zend\Paginator\Adapter\ArrayAdapter($array);
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }
}