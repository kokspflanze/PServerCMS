<?php


namespace PServerCMS\Options;

use Zend\Stdlib\AbstractOptions;

class EntityOptions extends AbstractOptions
{
    protected $__strictMode__ = false;

    /**
     * @var string
     */
    protected $availableCountries = 'PServerCMS\Entity\AvailableCountries';

    /**
     * @var string
     */
    protected $countryList = 'PServerCMS\Entity\CountryList';

    /**
     * @var string
     */
    protected $donateLog = 'PServerCMS\Entity\DonateLog';

    /**
     * @var string
     */
    protected $downloadList = 'PServerCMS\Entity\DownloadList';

    /**
     * @var string
     */
    protected $ipBlock = 'PServerCMS\Entity\IpBlock';

    /**
     * @var string
     */
    protected $loginFailed = 'PServerCMS\Entity\LoginFailed';

    /**
     * @var string
     */
    protected $loginHistory = 'PServerCMS\Entity\LoginHistory';

    /**
     * @var string
     */
    protected $logs = 'PServerCMS\Entity\Logs';

    /**
     * @var string
     */
    protected $news = 'PServerCMS\Entity\News';

    /**
     * @var string
     */
    protected $pageInfo = 'PServerCMS\Entity\PageInfo';

    /**
     * @var string
     */
    protected $playerHistory = 'PServerCMS\Entity\PlayerHistory';

    /**
     * @var string
     */
    protected $secretAnswer = 'PServerCMS\Entity\SecretAnswer';

    /**
     * @var string
     */
    protected $secretQuestion = 'PServerCMS\Entity\SecretQuestion';

    /**
     * @var string
     */
    protected $serverInfo = 'PServerCMS\Entity\ServerInfo';

    /**
     * @var string
     */
    protected $userBlock = 'PServerCMS\Entity\UserBlock';

    /**
     * @var string
     */
    protected $userCodes = 'PServerCMS\Entity\UserCodes';

    /**
     * @var string
     */
    protected $userExtension = 'PServerCMS\Entity\UserExtension';

    /**
     * @var string
     */
    protected $userRole = 'PServerCMS\Entity\UserRole';

    /**
     * @var string
     */
    protected $user = 'PServerCMS\Entity\User';

    /**
     * @return string
     */
    public function getAvailableCountries()
    {
        return $this->availableCountries;
    }

    /**
     * @param string $availableCountries
     *
     * @return EntityOptions
     */
    public function setAvailableCountries( $availableCountries )
    {
        $this->availableCountries = $availableCountries;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryList()
    {
        return $this->countryList;
    }

    /**
     * @param string $countryList
     *
     * @return EntityOptions
     */
    public function setCountryList( $countryList )
    {
        $this->countryList = $countryList;
        return $this;
    }

    /**
     * @return string
     */
    public function getDonateLog()
    {
        return $this->donateLog;
    }

    /**
     * @param string $donateLog
     *
     * @return EntityOptions
     */
    public function setDonateLog( $donateLog )
    {
        $this->donateLog = $donateLog;
        return $this;
    }

    /**
     * @return string
     */
    public function getDownloadList()
    {
        return $this->downloadList;
    }

    /**
     * @param string $downloadList
     *
     * @return EntityOptions
     */
    public function setDownloadList( $downloadList )
    {
        $this->downloadList = $downloadList;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpBlock()
    {
        return $this->ipBlock;
    }

    /**
     * @param string $ipBlock
     *
     * @return EntityOptions
     */
    public function setIpBlock( $ipBlock )
    {
        $this->ipBlock = $ipBlock;
        return $this;
    }

    /**
     * @return string
     */
    public function getLoginFailed()
    {
        return $this->loginFailed;
    }

    /**
     * @param string $loginFailed
     *
     * @return EntityOptions
     */
    public function setLoginFailed( $loginFailed )
    {
        $this->loginFailed = $loginFailed;
        return $this;
    }

    /**
     * @return string
     */
    public function getLoginHistory()
    {
        return $this->loginHistory;
    }

    /**
     * @param string $loginHistory
     *
     * @return EntityOptions
     */
    public function setLoginHistory( $loginHistory )
    {
        $this->loginHistory = $loginHistory;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param string $logs
     *
     * @return EntityOptions
     */
    public function setLogs( $logs )
    {
        $this->logs = $logs;
        return $this;
    }

    /**
     * @return string
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param string $news
     *
     * @return EntityOptions
     */
    public function setNews( $news )
    {
        $this->news = $news;
        return $this;
    }

    /**
     * @return string
     */
    public function getPageInfo()
    {
        return $this->pageInfo;
    }

    /**
     * @param string $pageInfo
     *
     * @return EntityOptions
     */
    public function setPageInfo( $pageInfo )
    {
        $this->pageInfo = $pageInfo;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlayerHistory()
    {
        return $this->playerHistory;
    }

    /**
     * @param string $playerHistory
     *
     * @return EntityOptions
     */
    public function setPlayerHistory( $playerHistory )
    {
        $this->playerHistory = $playerHistory;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecretAnswer()
    {
        return $this->secretAnswer;
    }

    /**
     * @param string $secretAnswer
     *
     * @return EntityOptions
     */
    public function setSecretAnswer( $secretAnswer )
    {
        $this->secretAnswer = $secretAnswer;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecretQuestion()
    {
        return $this->secretQuestion;
    }

    /**
     * @param string $secretQuestion
     *
     * @return EntityOptions
     */
    public function setSecretQuestion( $secretQuestion )
    {
        $this->secretQuestion = $secretQuestion;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerInfo()
    {
        return $this->serverInfo;
    }

    /**
     * @param string $serverInfo
     *
     * @return EntityOptions
     */
    public function setServerInfo( $serverInfo )
    {
        $this->serverInfo = $serverInfo;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserBlock()
    {
        return $this->userBlock;
    }

    /**
     * @param string $userBlock
     *
     * @return EntityOptions
     */
    public function setUserBlock( $userBlock )
    {
        $this->userBlock = $userBlock;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserCodes()
    {
        return $this->userCodes;
    }

    /**
     * @param string $userCodes
     *
     * @return EntityOptions
     */
    public function setUserCodes( $userCodes )
    {
        $this->userCodes = $userCodes;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserExtension()
    {
        return $this->userExtension;
    }

    /**
     * @param string $userExtension
     *
     * @return EntityOptions
     */
    public function setUserExtension( $userExtension )
    {
        $this->userExtension = $userExtension;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @param string $userRole
     *
     * @return EntityOptions
     */
    public function setUserRole( $userRole )
    {
        $this->userRole = $userRole;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     *
     * @return EntityOptions
     */
    public function setUser( $user )
    {
        $this->user = $user;
        return $this;
    }

}