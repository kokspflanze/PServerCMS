<?php


namespace PServerCMS\Service;


use PServerCMS\Entity\UserInterface;

class UserRole extends InvokableBase
{
    const ErrorNameSpace = 'p-server-admin-user-panel';

    /**
     * @param $data
     * @param $userId
     * @return \PServerCMS\Entity\UserInterface
     */
    public function addRoleForm( $data, $userId )
    {
        $form = $this->getForm();
        $form->setData($data);

        if (!$form->isValid()) {
            $messages = $form->getMessages();
            foreach ($messages as $elementMessages) {
                foreach ($elementMessages as $message) {
                    $this->getFlashMessenger()->setNamespace( self::ErrorNameSpace )->addMessage( $message );
                }
            }

            return false;
        }

        $data = $form->getData();
        $roleId = $data['roleId'];

        $user = $this->getUser4Id($userId);

        if ($user) {
            $this->addRole4User($user, $roleId);
        }
    }

    /**
     * @param $userId
     * @param $roleId
     */
    public function removeRole( $userId, $roleId )
    {
        $user = $this->getUser4Id($userId);
        $this->removeRole4User($user, $roleId);
    }

    /**
     * @param UserInterface $user
     * @param               $roleId
     * @return bool
     */
    protected function removeRole4User( UserInterface $user, $roleId )
    {
        $role = $this->getRoleEntity4Id($roleId);
        if (!$role) {
            return false;
        }

        $user->removeUserRole($role);
        $role->removeUser($user);
        $this->getEntityManager()->persist($role);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @return \PServerAdmin\Form\UserRole
     */
    public function getForm()
    {
        return $this->getServiceManager()->get('pserver_admin_user_role_form');
    }

    /**
     * @param UserInterface $user
     * @param               $roleId
     * @return bool
     */
    protected function addRole4User( UserInterface $user, $roleId )
    {
        $result = false;
        if (!$this->isRoleAlreadyAdded($user, $roleId)) {
            $role = $this->getRoleEntity4Id($roleId);
            $role->addUser($user);
            $user->addUserRole($role);
            $this->getEntityManager()->persist($role);
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
        }

        return $result;
    }

    /**
     * @param $roleId
     * @return null|\PServerCMS\Entity\UserRole
     */
    protected function getRoleEntity4Id( $roleId )
    {
        /** @var \PServerCMS\Entity\Repository\UserRole $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getUserRole());
        return $repository->getRole4Id($roleId);
    }

    /**
     * @param UserInterface $user
     * @param               $roleId
     * @return bool
     */
    protected function isRoleAlreadyAdded( UserInterface $user, $roleId )
    {
        $result = false;
        foreach ($user->getRoles() as $role) {
            if ($role->getId() == $roleId) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}