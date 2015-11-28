<?php


namespace PServerCMS\Service;

use PaymentAPI\Service\Validation;

class PaymentValidation extends Validation
{

    /**
     * @param $userId
     * @return bool
     */
    public function userExists($userId)
    {
        $user = $this->getUserService()->getUser4Id($userId);
        return (bool) $user;
    }

    /**
     * @return User
     */
    protected function getUserService()
    {
        return $this->getServiceManager()->get('small_user_service');
    }

}