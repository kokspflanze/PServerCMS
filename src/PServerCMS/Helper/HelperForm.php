<?php


namespace PServerCMS\Helper;


trait HelperForm
{

    /**
     * @return \ZfcBase\Form\ProvidesEventsForm
     */
    public function getAdminCoinForm()
    {
        return $this->getService('pserver_admin_coin_form');
    }

    /**
     * @return \PServerAdmin\Form\Download
     */
    public function getAdminDownloadForm()
    {
        return $this->getService('pserver_admin_download_form');
    }

    /**
     * @return \PServerAdmin\Form\News
     */
    public function getAdminNewsForm()
    {
        return $this->getService('pserver_admin_news_form');
    }

    /**
     * @return \PServerAdmin\Form\PageInfo
     */
    public function getAdminPageInfoForm()
    {
        return $this->getService('pserver_admin_page_info_form');
    }

    /**
     * @return \PServerAdmin\Form\ServerInfo
     */
    public function getAdminServerInfoForm()
    {
        return $this->getService('pserver_admin_server_info_form');
    }

    /**
     * @return \PServerAdmin\Form\UserBlock
     */
    public function getAdminUserBlockForm()
    {
        return $this->getService('pserver_admin_user_block_form');
    }

    /**
     * @return \PServerAdmin\Form\SecretQuestion
     */
    public function getAdminSecretQuestionForm()
    {
        return $this->getService('pserver_admin_secret_question_form');
    }

    /**
     * @return \PServerAdmin\Form\UserRole
     */
    public function getAdminUserRoleForm()
    {
        return $this->getService('pserver_admin_user_role_form');
    }

    /**
     * @return \PServerCMS\Form\Register
     */
    public function getRegisterForm()
    {
        return $this->getService('pserver_user_register_form');
    }

    /**
     * @return \PServerCMS\Form\Password
     */
    public function getPasswordForm()
    {
        return $this->getService('pserver_user_password_form');
    }

    /**
     * @return \PServerCMS\Form\PwLost
     */
    public function getPasswordLostForm()
    {
        return $this->getService('pserver_user_pwlost_form');
    }

    /**
     * @return \PServerCMS\Form\ChangePwd
     */
    public function getChangePwdForm()
    {
        return $this->getService('pserver_user_changepwd_form');
    }

    /**
     * @return \PServerCMS\Form\AddEmail
     */
    public function getAddEmailForm()
    {
        return $this->getService('pserver_user_add_mail_form');
    }

    /**
     * @param $serviceName
     *
     * @return array|object
     */
    public abstract function getService($serviceName);
}