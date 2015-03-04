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
            return $this->redirect()->toRoute('home');
        }

        return [
            'character' => $character
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