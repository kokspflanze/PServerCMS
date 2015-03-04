<?php


namespace PServerCMS\Service;


class Character extends InvokableBase
{

    /**
     * @param $id
     *
     * @return \GameBackend\Entity\Game\CharacterInterface|null
     */
    public function getCharacter4Id( $id )
    {
        return $this->getGameBackendService()->getCharacter4Id($id);
    }

}