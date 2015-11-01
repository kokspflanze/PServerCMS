<?php


namespace PServerCMS\Service;

use PServerCMS\Entity\UserInterface;

class Coin extends InvokableBase
{
    /**
     * @param $data
     * @param $userId
     * @param UserInterface $adminUser
     * @return bool
     */
    public function addCoinsForm($data, $userId, UserInterface $adminUser)
    {
        $form = $this->getAdminCoinForm();
        $form->setData($data);

        if (!$form->isValid()) {
            return false;
        }

        $user = $this->getUser4Id($userId);

        if ($user) {
            $data = $form->getData();
            $this->addCoins($user, $data['coins']);


            $class = $this->getEntityOptions()->getDonateLog();
            /** @var \PServerCMS\Entity\DonateLog $donateEntity */
            $donateEntity = new $class;
            $donateEntity->setTransactionId('AdminPanel: ' . $adminUser->getUsername())
                ->setCoins($data['coins'])
                ->setIp($this->getIpService()->getIp())
                ->setSuccess($donateEntity::STATUS_SUCCESS)
                ->setType($donateEntity::TYPE_INTERNAL)
                ->setUser($user);

            $entityManager = $this->getEntityManager();
            $entityManager->persist($donateEntity);
            $entityManager->flush();
        }

        return true;
    }

    /**
     * @param UserInterface $user
     * @return int
     */
    public function getCoinsOfUser(UserInterface $user)
    {
        return $this->getGameBackendService()->getCoins($user);
    }

    /**
     * @param UserInterface $user
     * @param               $amount
     * @return bool
     */
    public function addCoins(UserInterface $user, $amount)
    {
        return $this->getGameBackendService()->setCoins($user, $amount);
    }

}