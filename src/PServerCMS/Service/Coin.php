<?php


namespace PServerCMS\Service;

use PServerCMS\Entity\UserInterface;

class Coin extends InvokableBase
{
    /**
     * @param $data
     * @param $userId
     * @return bool
     */
    public function addCoinsForm($data, $userId)
    {
        $form = $this->getAdminCoinForm();
        $form->setData($data);

        if(!$form->isValid()){
            return false;
        }
        $user = $this->getUser4Id($userId);
        
        if ($user) {
            $data = $form->getData();
            $this->addCoins($user, $data['coins']);
        }

        return true;
    }

    /**
     * @param UserInterface $user
     * @return int
     */
    public function getCoinsOfUser( UserInterface $user )
    {
        return $this->getGameBackendService()->getCoins($user);
    }

    /**
     * @param UserInterface $user
     * @param               $amount
     * @return bool
     */
    public function addCoins( UserInterface $user, $amount )
    {
        return $this->getGameBackendService()->setCoins($user, $amount);
    }

}