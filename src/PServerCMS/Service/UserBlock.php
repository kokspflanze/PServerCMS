<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\Userblock as UserBlockEntity;
use PServerAdmin\Mapper\HydratorUserBlock;
use PServerCMS\Entity\UserInterface;

class UserBlock extends InvokableBase
{
    const ErrorNameSpace = 'p-server-admin-user-panel';

    /**
     * @param $data
     * @param $userId
     * @return \PServerCMS\Entity\UserInterface
     */
    public function blockForm($data, $userId)
    {
        $class = $this->getEntityOptions()->getUserBlock();
        /** @var UserBlockEntity $userBlock */

        $form = $this->getAdminUserBlockForm();
        $form->setHydrator(new HydratorUserBlock());
        $form->bind(new $class);
        $form->setData($data);

        if (!$form->isValid()) {
            return false;
        }
        /** @var UserBlockEntity $userBlockEntity */
        $userBlockEntity = $form->getData();
        $user = $this->getUser4Id($userId);

        if ($user) {
            $userBlockEntity->setUser($user);
            $this->blockUserWithEntity($userBlockEntity);
        }

        return $user;
    }

    /**
     * We want to block a user
     *
     * @param UserInterface $user
     * @param       $expire
     * @param       $reason
     * @return bool
     */
    public function blockUser(UserInterface $user, $expire, $reason)
    {
        $class = $this->getEntityOptions()->getUserBlock();
        /** @var UserBlockEntity $userBlock */
        $userBlock = new $class;
        $userBlock->setUser($user);
        $userBlock->setReason($reason);
        $userBlock->setExpire($expire);

        return $this->blockUserWithEntity($userBlock);
    }

    /**
     * @param UserInterface|int $user
     * @return boolean
     */
    public function removeBlock($user)
    {
        if (!$user instanceof UserInterface) {
            $user = $this->getUser4Id($user);

            if (!$user) {
                return false;
            }
        }

        /** @var \PServerCMS\Entity\Repository\USerBlock $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getUserBlock());
        $repository->removeBlock($user);

        $this->getGameBackendService()->removeBlockUser($user);

        return true;
    }

    /**
     * @param UserInterface $user
     * @return null|UserBlockEntity
     */
    public function isUserBlocked(UserInterface $user)
    {
        $entityManager = $this->getEntityManager();
        /** @var \PServerCMS\Entity\Repository\UserBlock $repositoryUserBlock */
        $repositoryUserBlock = $entityManager->getRepository($this->getEntityOptions()->getUserBlock());
        return $repositoryUserBlock->isUserAllowed($user);
    }

    /**
     * @param UserBlockEntity $userBlock
     * @return bool
     */
    protected function blockUserWithEntity(UserBlockEntity $userBlock)
    {
        // delete all old blocks
        $this->removeBlock($userBlock->getUser());
        $result = false;

        if ($userBlock->getExpire() > new \DateTime) {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($userBlock);
            $entityManager->flush();
            $result = true;

            $this->getGameBackendService()->blockUser($userBlock->getUser(), $userBlock->getExpire(),
                $userBlock->getReason());
        }

        return $result;
    }
} 