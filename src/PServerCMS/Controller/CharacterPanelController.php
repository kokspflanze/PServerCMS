<?php


namespace PServerCMS\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class CharacterPanelController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var \PServerCMS\Entity\UserInterface $user */
        $user = $this->getUserService()->getAuthService()->getIdentity();

        return [
            'characterList' => $this->getCharacterService()->getCharacterList4User($user)
        ];
    }

    /**
     * @return \PServerRanking\Service\Character
     */
    protected function getCharacterService()
    {
        return $this->getServiceLocator()->get('pserverranking_character_service');
    }

    /**
     * @return \PServerCMS\Service\User
     */
    protected function getUserService()
    {
        return $this->getServiceLocator()->get( 'small_user_service' );
    }
}