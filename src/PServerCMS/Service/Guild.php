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
     * @param $id
     *
     * @return \GameBackend\Entity\Game\GuildMemberInterface[]|null
     */
    public function getGuildMemberList4GuildId( $id )
    {
        return $this->getGameBackendService()->getGuildMember4GuildId($id);
    }

    /**
     * @param     $id
     * @param int $page
     *
     * @return null|Paginator
     */
    public function getGuildMember4GuildId( $id, $page = 1 )
    {
        $memberList = $this->getGuildMemberList4GuildId($id);

        $result = null;
        if($memberList){
            $result = $this->getPaginator4QueryBuilder($memberList, $page);
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