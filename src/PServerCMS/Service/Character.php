<?php


namespace PServerCMS\Service;


use PServerCMS\Entity\UserInterface;

class Character extends InvokableBase
{
    /**
     * @param $id
     * @return \GameBackend\Entity\Game\CharacterInterface|null
     */
    public function getCharacter4Id( $id )
    {
        return $this->getGameBackendService()->getCharacter4Id($id);
    }

    /**
     * @param $id
     * @return \GameBackend\Entity\Game\InventoryInterface[]|null
     */
    public function getInventorySet4CharacterId( $id )
    {
        return $this->getGameBackendService()->getInventorySet4CharacterId($id);
    }

    /**
     * @param UserInterface $user
     * @return \GameBackend\Entity\Game\CharacterInterface[]|null
     */
    public function getCharacterList4User( UserInterface $user )
    {
        return $this->getGameBackendService()->getCharacterList4User($user);
    }
}