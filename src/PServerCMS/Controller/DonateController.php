<?php

namespace PServerCMS\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class DonateController extends AbstractActionController
{
    /** @var \PServerCMS\Service\User */
    protected $userService;

    public function indexAction()
    {
        /** @var \PServerCMS\Entity\Users $user */
        $user = $this->getUserService()->getAuthService()->getIdentity();

        return array(
            'user' => $user
        );
    }

    /**
     * @return \PServerCMS\Service\User
     */
    protected function getUserService()
    {
        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get( 'small_user_service' );
        }

        return $this->userService;
    }
}