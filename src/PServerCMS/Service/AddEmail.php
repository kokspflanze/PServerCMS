<?php


namespace PServerCMS\Service;


use PServerCMS\Entity\UserInterface;

class AddEmail extends InvokableBase
{
    const ERROR_NAMESPACE = 'pserver-user-account-error';

    public function addEmail($data, UserInterface $user)
    {
        $form = $this->getAddEmailForm();
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }

        $user = $this->getUser4Id($user->getId());
        if ($user->getEmail()) {
            $this->getFlashMessenger()->setNamespace(self::ERROR_NAMESPACE)->addMessage('Email already exists in your Account');
            return false;
        }

        $data = $form->getData();
    }

}