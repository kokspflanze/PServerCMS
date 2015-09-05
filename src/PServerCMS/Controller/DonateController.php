<?php

namespace PServerCMS\Controller;

use PServerCMS\Helper\HelperService;
use PServerCMS\Helper\HelperServiceLocator;
use Zend\Mvc\Controller\AbstractActionController;

class DonateController extends AbstractActionController
{
    use HelperServiceLocator, HelperService;

    public function indexAction()
    {
        /** @var \PServerCMS\Entity\UserInterface $user */
        $user = $this->getUserService()->getAuthService()->getIdentity();

        return [
            'user' => $user
        ];
    }

}