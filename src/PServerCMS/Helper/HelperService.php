<?php


namespace PServerCMS\Helper;


trait HelperService
{

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getService('Doctrine\ORM\EntityManager');
    }

    /**
     * @return array|object
     */
    public function getConfig()
    {
        return $this->getService('Config');
    }

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        return $this->getService('small_user_auth_service');
    }

    /**
     * @return \Zend\Mvc\Controller\PluginManager
     */
    protected function getControllerPluginManager()
    {
        return $this->getService('ControllerPluginManager');
    }

    /**
     * @return \Zend\Cache\Storage\StorageInterface
     */
    protected function getCachingService()
    {
        return $this->getService('pserver_caching_service');
    }

    /**
     * @return \PServerCMS\Service\CachingHelper
     */
    protected function getCachingHelperService()
    {
        return $this->getService('pserver_cachinghelper_service');
    }

    /**
     * @return \PServerCMS\Service\ConfigRead
     */
    protected function getConfigService()
    {
        return $this->getService('pserver_configread_service');
    }

    /**
     * @return \PServerCMS\Service\UserBlock
     */
    protected function getUserBlockService()
    {
        return $this->getService('pserver_user_block_service');
    }

    /**
     * @return \PServerCMS\Service\User
     */
    protected function getUserService()
    {
        return $this->getService('small_user_service');
    }

    /**
     * @return \PServerCMS\Service\UserCodes
     */
    protected function getUserCodesService()
    {
        return $this->getService('pserver_usercodes_service');
    }

    /**
     * @return \PServerCMS\Service\Mail
     */
    protected function getMailService()
    {
        return $this->getService('pserver_mail_service');
    }

    /**
     * @return \PServerCMS\Service\SecretQuestion
     */
    protected function getSecretQuestionService()
    {
        return $this->getService('pserver_secret_question');
    }

    /**
     * @return \PServerCMS\Service\Coin
     */
    protected function getCoinService()
    {
        return $this->getService('pserver_coin_service');
    }

    /**
     * @return \PServerCMS\Service\Download
     */
    protected function getDownloadService()
    {
        return $this->getService('pserver_download_service');
    }

    /**
     * @return \PServerCMS\Service\PageInfo
     */
    protected function getPageInfoService()
    {
        return $this->getService('pserver_pageinfo_service');
    }

    /**
     * @return \PServerCMS\Service\News
     */
    protected function getNewsService()
    {
        return $this->getService('pserver_news_service');
    }

    /**
     * @return \PServerCMS\Service\UserRole
     */
    protected function getUserRoleService()
    {
        return $this->getService('pserver_user_role_service');
    }

    /**
     * @return \PServerCMS\Service\ServerInfo
     */
    protected function getServerInfoService()
    {
        return $this->getService('pserver_server_info_service');
    }

    /**
     * @return \PServerCMS\Service\Logs
     */
    protected function getWebLogService()
    {
        return $this->getService('pserver_log_service');
    }

    /**
     * @return \PServerCMS\Service\Donate
     */
    protected function getDonateService()
    {
        return $this->getService('pserver_donate_service');
    }

    /**
     * @return \PServerCMS\Service\UserPanel
     */
    protected function getUserPanelService()
    {
        return $this->getService('pserver_user_panel_service');
    }

    /**
     * @return \PServerCMS\Service\LoginHistory
     */
    protected function getLoginHistoryService()
    {
        return $this->getService('pserver_login_history_service');
    }

    /**
     * @return \PServerCMS\Service\Donate
     */
    protected function getDonateLogService()
    {
        return $this->getService('pserver_donate_service');
    }

    /**
     * @return \PServerCMS\Service\PlayerHistory
     */
    protected function getPlayerHistory()
    {
        return $this->getService('pserver_playerhistory_service');
    }

    /**
     * @return \PServerCMS\Service\Timer
     */
    protected function getTimerService()
    {
        return $this->getService('pserver_timer_service');
    }

    /**
     * @return \PServerPanel\Service\Character
     */
    protected function getCharacterService()
    {
        return $this->getService('pserverpanel_character_service');
    }

    /**
     * @param $serviceName
     *
     * @return array|object
     */
    abstract function getService( $serviceName );

}