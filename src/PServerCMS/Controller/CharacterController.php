<?php


namespace PServerCMS\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class CharacterController extends AbstractActionController
{

    public function indexAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $character = $this->getCharacterService()->getCharacter4Id($id);

        if(!$character){
            return $this->redirect()->toRoute('PServerCMS/home');
        }

        return [
            'character' => $character,
            'inventory' => $this->getCharacterService()->getInventorySet4CharacterId($id)
        ];
    }

    /**
     * @return \PServerCMS\Service\Character
     */
    protected function getCharacterService()
    {
        return $this->getServiceLocator()->get('pserver_character_service');
    }
}