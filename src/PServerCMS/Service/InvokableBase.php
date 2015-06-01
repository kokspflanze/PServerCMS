<?php
namespace PServerCMS\Service;

use PServerCMS\Helper\HelperOptions;
use PServerCMS\Helper\HelperService;
use PServerCMS\Helper\HelperBasic;
use SmallUser\Service\InvokableBase as UserBase;
use Zend\Form\FormInterface;

abstract class InvokableBase extends UserBase
{
    use HelperService, HelperOptions, HelperBasic;

    /**
     * @param $userId
     *
     * @return null|\PServerCMS\Entity\UserInterface
     */
    protected function getUser4Id( $userId )
    {
        /** @var \PServerCMS\Entity\Repository\User $userRepository */
        $userRepository = $this->getEntityManager()->getRepository( $this->getEntityOptions()->getUser() );

        return $userRepository->getUser4Id( $userId );
    }

    /**
     * @param FormInterface $form
     * @param $namespace
     */
    protected function addFormMessagesInFlashMessenger( FormInterface $form, $namespace)
    {
        $messages = $form->getMessages();
        foreach ($messages as $elementMessages) {
            foreach ($elementMessages as $message) {
                $this->getFlashMessenger()->setNamespace( $namespace )->addMessage( $message );
            }
        }
    }
} 