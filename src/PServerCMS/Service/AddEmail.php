<?php


namespace PServerCMS\Service;


use PServerCMS\Entity\UserCodes;
use PServerCMS\Entity\UserInterface;

class AddEmail extends InvokableBase
{
    const ERROR_NAMESPACE = 'pserver-user-account-errorAddEmail';
    const SUCCESS_NAMESPACE = 'pserver-user-account-successAddEmail';

    /**
     * @param $data
     * @param UserInterface $user
     * @return bool
     */
    public function addEmail($data, UserInterface $user)
    {
        $form = $this->getAddEmailForm();
        $form->setData($data);
        if (!$form->isValid()) {
            foreach ($form->getElements() as $messages) {
                /** @var \Zend\Form\ElementInterface $messages */
                foreach ($messages->getMessages() as $message) {
                $this->getFlashMessenger()
                    ->setNamespace(self::ERROR_NAMESPACE)
                    ->addMessage($message);
                }
            }

            return false;
        }

        $user = $this->getUser4Id($user->getId());
        if ($user->getEmail()) {
            $this->getFlashMessenger()
                ->setNamespace(self::ERROR_NAMESPACE)
                ->addMessage('Email already exists in your Account');
            return false;
        }

        $data = $form->getData();
        $entityManager = $this->getEntityManager();

        if ($this->getRegisterOptions()->isMailConfirmation()) {
            $userExtensionName = $this->getEntityOptions()->getUserExtension();
            /** @var \PServerCMS\Entity\UserExtension $userExtension */
            $userExtension = new $userExtensionName;

            /** @var \PServerCMS\Entity\Repository\UserExtension $extensionRepository */
            $extensionRepository = $entityManager->getRepository($userExtensionName);
            $extensionRepository->deleteExtension($user, $userExtension::KEY_ADD_EMAIL);

            $userExtension->setKey($userExtension::KEY_ADD_EMAIL)
                ->setUser($user)
                ->setValue($data['email']);

            $entityManager->persist($userExtension);
            $entityManager->flush();

            $code = $this->getUserCodesService()->setCode4User($user, UserCodes::TYPE_ADD_EMAIL);
            $user->setEmail($data['email']);

            $this->getMailService()->addEmail($user, $code);

            $this->getFlashMessenger()
                ->setNamespace(self::SUCCESS_NAMESPACE)
                ->addMessage('Success, please confirm your mail.');
        } else {
            $user->setEmail($data['email']);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->getAuthService()->getStorage()->write($user);
        }

        return true;
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function changeMail(UserInterface $user)
    {
        $entityManager = $this->getEntityManager();
        $userExtensionName = $this->getEntityOptions()->getUserExtension();
        /** @var \PServerCMS\Entity\UserExtension $userExtension */
        $userExtension = new $userExtensionName;
        /** @var \PServerCMS\Entity\Repository\UserExtension $extensionRepository */
        $extensionRepository = $entityManager->getRepository($userExtensionName);
        $userExtension = $extensionRepository->findOneBy(['key' => $userExtension::KEY_ADD_EMAIL]);

        $user->setEmail($userExtension->getValue());
        $entityManager->persist($user);
        $entityManager->flush();

        $extensionRepository->deleteExtension($user, $userExtension::KEY_ADD_EMAIL);

        return $user;
    }

}