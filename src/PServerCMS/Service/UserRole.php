<?php


namespace PServerCMS\Service;


class UserRole extends InvokableBase
{

    /**
     * @return \PServerAdmin\Form\UserRole
     */
    public function getForm()
    {
        return $this->getServiceManager()->get('pserver_admin_user_role_form');
    }
}