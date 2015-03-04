<?php


namespace PServerCMS\Service;


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
}