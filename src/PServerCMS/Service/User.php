<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\Usercodes;
use PServerCMS\Entity\Users;
use PServerCMS\Entity\AvailableCountries;
use PServerCMS\Entity\Repository\AvailableCountries as RepositoryAvailableCountries;
use PServerCMS\Entity\Repository\CountryList;
use PServerCMS\Helper\DateTimer;
use PServerCMS\Helper\Ip;
use SmallUser\Entity\UsersInterface;
use SmallUser\Mapper\HydratorUser;
use Zend\Crypt\Password\Bcrypt;

class User extends \SmallUser\Service\User
{
    /** @var \PServerCMS\Form\Register */
    protected $registerForm;
    /** @var \PServerCMS\Service\Mail */
    protected $mailService;
    /** @var \PServerCMS\Service\UserCodes */
    protected $userCodesService;
    /** @var \PServerCMS\Form\Password */
    protected $passwordForm;
    /** @var \GameBackend\DataService\DataServiceInterface */
    protected $gameBackendService;
    /** @var \PServerCMS\Form\PwLost */
    protected $passwordLostForm;
    /** @var ConfigRead */
    protected $configReadService;

    /**
     * @param array $data
     *
     * @return Users|bool
     */
    public function register( array $data )
    {

        $oForm = $this->getRegisterForm();
        $oForm->setHydrator( new HydratorUser() );
        $oForm->bind( new Users() );
        $oForm->setData( $data );
        if (!$oForm->isValid()) {
            return false;
        }

        $oEntityManager = $this->getEntityManager();
        /** @var Users $userEntity */
        $userEntity = $oForm->getData();
        $userEntity->setCreateIp( Ip::getIp() );
        $userEntity->setPassword( $this->bcrypt( $userEntity->getPassword() ) );

        $oEntityManager->persist( $userEntity );
        $oEntityManager->flush();

        $sCode = $this->getUserCodesService()->setCode4User( $userEntity, \PServerCMS\Entity\Usercodes::TYPE_REGISTER );

        $this->getMailService()->register( $userEntity, $sCode );

        $this->getSecretQuestionService()->setSecretAnswer( $userEntity, $data['question'], $data['answer'] );

        return $userEntity;
    }

    /**
     * @param Usercodes $userCode
     *
     * @return Users
     */
    public function registerGameWithSamePassword( Usercodes $userCode )
    {

        $option = $this->getConfigService()->get( 'pserver.password.different-passwords' );

        // config is different pw-system
        if ($option) {
            return null;
        }

        $user = $this->registerGame( $userCode->getUser() );
        if ($user) {
            $this->getUserCodesService()->deleteCode( $userCode );
        }

        return $user;
    }

    /**
     * @param array     $data
     * @param Usercodes $userCode
     *
     * @return Users|bool
     */
    public function registerGameWithOtherPw( array $data, Usercodes $userCode )
    {

        $form = $this->getPasswordForm();

        $form->setData( $data );
        if (!$form->isValid()) {
            return false;
        }

        $data          = $form->getData();
        $plainPassword = $data['password'];

        $user = $this->registerGame( $userCode->getUser(), $plainPassword );

        if ($user) {
            $this->getUserCodesService()->deleteCode( $userCode );
        }

        return $user;
    }

    /**
     * @param Users  $user
     * @param string $plainPassword
     *
     * @return Users
     */
    public function registerGame( Users $user, $plainPassword = '' )
    {

        $gameBackend = $this->getGameBackendService();

        $backendId = $gameBackend->setUser( $user, $plainPassword );
        $user->setBackendId( $backendId );

        $entityManager = $this->getEntityManager();
        /** user have already a backendId, so better to set it there */
        $entityManager->persist( $user );
        $entityManager->flush();

        /** @var CountryList $countryList */
        $countryList        = $entityManager->getRepository( $this->getEntityOptions()->getCountryList() );
        $class = $this->getEntityOptions()->getAvailableCountries();
        /** @var \PServerCMS\Entity\AvailableCountries $availableCountries */
        $availableCountries = new $class;
        $availableCountries->setActive( '1' );
        $availableCountries->setUser( $user );
        $availableCountries->setCntry( $countryList->getCountryCode4Ip( Ip::getIp() ) );

        $repositoryRole = $entityManager->getRepository( $this->getEntityOptions()->getUserRole() );
        $role           = $this->getConfigService()->get( 'pserver.register.role', 'user' );
        $roleEntity     = $repositoryRole->findOneBy( array( 'roleId' => $role ) );

        // add the ROLE + Remove the Key
        $user->addUserRole( $roleEntity );
        $roleEntity->addUsersUsrid( $user );
        $entityManager->persist( $user );
        $entityManager->persist( $roleEntity );
        $entityManager->persist( $availableCountries );
        $entityManager->flush();

        return $user;
    }

    /**
     * @param array $data
     * @param Users $user
     *
     * @return bool|null|Users
     */
    public function changeWebPwd( array $data, Users $user )
    {
        $user = $this->getUser4Id( $user->getId() );

        // check if we use different pw system
        if (!$this->isSamePasswordOption()) {
            return false;
        }

        if (!$this->isPwdChangeAllowed( $data, $user, 'Web' )) {
            return false;
        }

        $user = $this->setNewPasswordAtUser( $user, $data['password'] );

        return $user;
    }

    /**
     * @param array $data
     * @param Users $user
     *
     * @return bool
     */
    public function changeIngamePwd( array $data, Users $user )
    {
        $user = $this->getUser4Id( $user->getId() );
        if (!$this->isPwdChangeAllowed( $data, $user, 'InGame' )) {
            return false;
        }

        // check if we have to change it at web too
        if (!$this->isSamePasswordOption()) {
            $user = $this->setNewPasswordAtUser( $user, $data['password'] );
        }

        $gameBackend = $this->getGameBackendService();
        $gameBackend->setUser( $user, $data['password'] );
        return $user;
    }

    public function lostPw( array $data )
    {
        $form = $this->getPasswordLostForm();

        $form->setData( $data );
        if (!$form->isValid()) {
            return false;
        }

        $data = $form->getData();

        $entityManager = $this->getEntityManager();
        $user          = $entityManager->getRepository( $this->getEntityOptions()->getUsers() )
            ->findOneBy( array( 'username' => $data['username'] ) );


        $code = $this->getUserCodesService()->setCode4User( $user, \PServerCMS\Entity\Usercodes::TYPE_LOST_PASSWORD );

        $this->getMailService()->lostPw( $user, $code );

        return $user;
    }

    public function lostPwConfirm( array $data, Usercodes $userCode )
    {

        $form = $this->getPasswordForm();
        /** @var \PServerCMS\Form\PasswordFilter $filter */
        $filter = $form->getInputFilter();
        $filter->addAnswerValidation( $userCode->getUser() );
        $form->setData( $data );
        if (!$form->isValid()) {
            return false;
        }

        $data           = $form->getData();
        $sPlainPassword = $data['password'];
        $userEntity     = $userCode->getUser();

        $this->setNewPasswordAtUser( $userEntity, $sPlainPassword );

        $this->getUserCodesService()->deleteCode( $userCode );

        if (!$this->isSamePasswordOption()) {
            $gameBackend = $this->getGameBackendService();
            $gameBackend->setUser( $userEntity, $sPlainPassword );
        }

        return $userEntity;
    }

    public function countryConfirm( Usercodes $userCodes )
    {
        $entityManager = $this->getEntityManager();

        /** @var Users $userEntity */
        $userEntity = $userCodes->getUser();

        /** @var CountryList $countryList */
        $countryList = $entityManager->getRepository( $this->getEntityOptions()->getCountryList() );
        $country     = $countryList->getCountryCode4Ip( Ip::getIp() );

        /** @var AvailableCountries $availableCountries */
        $class               = $this->getEntityOptions()->getAvailableCountries();
        $availableCountries = new $class();
        $availableCountries->setCntry( $country );
        $availableCountries->setUser( $userEntity );

        $entityManager->persist( $availableCountries );
        $entityManager->remove( $userCodes );
        $entityManager->flush();

        return $userEntity;
    }

    /**
     * @param Users $user
     *
     * @return bool
     */
    protected function isValidLogin( UsersInterface $user )
    {
        $result = true;
        if (!(bool)$user->getUserRole()->getKeys()) {
            $this->setFailedLoginMessage( 'Your Account is not active, please confirm your email' );
            $result = false;
        }
        if (!$this->isCountryAllowed( $user )) {
            $result = false;
        }
        if ($this->isUserBlocked( $user )) {
            $result = false;
        }
        return $result;
    }

    /**
     * @param Users $user
     *
     * @return bool
     */
    protected function isCountryAllowed( UsersInterface $user )
    {
        $entityManager = $this->getEntityManager();
        $result = true;

        /** @var CountryList $countryList */
        $countryList = $entityManager->getRepository( $this->getEntityOptions()->getCountryList() );
        $country     = $countryList->getCountryCode4Ip( Ip::getIp() );
        /** @var RepositoryAvailableCountries $availableCountries */
        $availableCountries = $entityManager->getRepository( $this->getEntityOptions()->getAvailableCountries() );
        if (!$availableCountries->isCountryAllowedForUser( $user->getUsrid(), $country )) {
            $code = $this->getUserCodesService()->setCode4User( $user, \PServerCMS\Entity\Usercodes::TYPE_CONFIRM_COUNTRY );
            $this->getMailService()->confirmCountry( $user, $code );
            $this->getFlashMessenger()->setNamespace( self::ErrorNameSpace )->addMessage( 'Please confirm your new ip with your email' );
            $result = false;
        }
        return $result;
    }

    /**
     * @param Users $user
     *
     * @return bool
     */
    protected function isUserBlocked( UsersInterface $user )
    {
        $entityManager = $this->getEntityManager();
        /** @var \PServerCMS\Entity\Repository\UserBlock $repositoryUserBlock */
        $repositoryUserBlock = $entityManager->getRepository( $this->getEntityOptions()->getUserBlock() );
        $userBlocked      = $repositoryUserBlock->isUserAllowed( $user->getUsrid() );
        if ($userBlocked) {
            $message = sprintf('You are blocked because %s !, try it again %s', $userBlocked->getReason(), $userBlocked->getExpire()->format( 'H:i:s' ) );
            $this->getFlashMessenger()->setNamespace( self::ErrorNameSpace )->addMessage($message);
            return true;
        }
        return false;
    }

    /**
     * @param $userId
     *
     * @return null|\PServerCMS\Entity\Users
     */
    protected function getUser4Id( $userId )
    {
        /** @var \PServerCMS\Entity\Repository\Users $userRepository */
        $userRepository = $this->getEntityManager()->getRepository( $this->getEntityOptions()->getUsers() );
        return $userRepository->getUser4Id( $userId );
    }

    /**
     * @param Users $user
     */
    protected function doLogin( UsersInterface $user )
    {
        parent::doLogin( $user );
        $entityManager = $this->getEntityManager();
        /**
         * Set LoginHistory
         */
        $class = $this->getEntityOptions()->getLoginHistory();
        /** @var \PServerCMS\Entity\LoginHistory $loginHistory */
        $loginHistory = new $class();
        $loginHistory->setUsersUsrid( $user );
        $loginHistory->setIp( Ip::getIp() );
        $entityManager->persist( $loginHistory );
        $entityManager->flush();
    }

    protected function handleInvalidLogin( UsersInterface $user )
    {
        $maxTries = $this->getConfigService()->get( 'pserver.login.exploit.try' );
        if (!$maxTries) {
            return false;
        }

        $entityManager = $this->getEntityManager();
        /**
         * Set LoginHistory
         */
        $class = $this->getEntityOptions()->getLoginFailed();
        /** @var \PServerCMS\Entity\Loginfaild $loginFailed */
        $loginFailed = new $class();
        $loginFailed->setUsername( $user->getUsername() );
        $loginFailed->setIp( Ip::getIp() );
        $entityManager->persist( $loginFailed );
        $entityManager->flush();

        $time = $this->getConfigService()->get( 'pserver.login.exploit.time' );

        /** @var \PServerCMS\Entity\Repository\LoginFaild $repositoryLoginFailed */
        $repositoryLoginFailed = $entityManager->getRepository( $class );
        if ($repositoryLoginFailed->getNumberOfFailLogins4Ip( Ip::getIp(), $time ) >= $maxTries) {
            $class = $this->getEntityOptions()->getIpBlock();
            /** @var \PServerCMS\Entity\Ipblock $ipBlock */
            $ipBlock = new $class();
            $ipBlock->setExpire( DateTimer::getDateTime4TimeStamp( time() + $time ) );
            $ipBlock->setIp( Ip::getIp() );
            $entityManager->persist( $ipBlock );
            $entityManager->flush();
        }
    }

    /**
     * @return bool
     */
    protected function isIpAllowed()
    {
        $entityManager = $this->getEntityManager();
        /** @var \PServerCMS\Entity\Repository\IPBlock $repositoryIPBlock */
        $repositoryIPBlock = $entityManager->getRepository( $this->getEntityOptions()->getIpBlock() );
        $ipAllowed         = $repositoryIPBlock->isIPAllowed( Ip::getIp() );
        if ($ipAllowed) {
            $message = sprintf( 'Your IP is blocked!, try it again %s', $ipAllowed->getExpire()->format( 'H:i:s' ) );
            $this->getFlashMessenger()->setNamespace( self::ErrorNameSpace )->addMessage( $message );
            return false;
        }
        return true;
    }

    /**
     * @return \PServerCMS\Form\Register
     */
    public function getRegisterForm()
    {
        if (!$this->registerForm) {
            $this->registerForm = $this->getServiceManager()->get( 'pserver_user_register_form' );
        }

        return $this->registerForm;
    }

    /**
     * @return \PServerCMS\Form\Password
     */
    public function getPasswordForm()
    {
        if (!$this->passwordForm) {
            $this->passwordForm = $this->getServiceManager()->get( 'pserver_user_password_form' );
        }

        return $this->passwordForm;
    }

    /**
     * Login with a User
     *
     * @param UsersInterface $user
     */
    public function doAuthentication( Users $user )
    {
        $find    = array( $this->getUserEntityUserName() => $user->getUsername() );
        $userNew = $this->getEntityManager()->getRepository( $this->getUserEntityClassName() )->findOneBy( $find );

        $authService = $this->getAuthService();
        // FIX: no roles after register
        $userNew->getUserRole();
        $userNew->getUserExtension();
        $authService->getStorage()->write( $userNew );
    }

    /**
     * @return \PServerCMS\Form\PwLost
     */
    public function getPasswordLostForm()
    {
        if (!$this->passwordLostForm) {
            $this->passwordLostForm = $this->getServiceManager()->get( 'pserver_user_pwlost_form' );
        }

        return $this->passwordLostForm;
    }

    /**
     * @return \PServerCMS\Form\ChangePwd
     */
    public function getChangePwdForm()
    {
        return $this->getServiceManager()->get( 'pserver_user_changepwd_form' );
    }

    /**
     * read from the config if system works for different pws @ web and in-game or with same
     * @return boolean
     */
    public function isSamePasswordOption()
    {
        return (bool)$this->getConfigService()->get( 'pserver.password.different-passwords' );
    }

    /**
     * @return \GameBackend\DataService\DataServiceInterface
     */
    public function getGameBackendService()
    {
        if (!$this->gameBackendService) {
            $this->gameBackendService = $this->getServiceManager()->get( 'gamebackend_dataservice' );
        }

        return $this->gameBackendService;
    }

    /**
     * @return \PServerCMS\Service\Mail
     */
    protected function getMailService()
    {
        if (!$this->mailService) {
            $this->mailService = $this->getServiceManager()->get( 'pserver_mail_service' );
        }

        return $this->mailService;
    }

    /**
     * @return \PServerCMS\Service\UserCodes
     */
    protected function getUserCodesService()
    {
        if (!$this->userCodesService) {
            $this->userCodesService = $this->getServiceManager()->get( 'pserver_usercodes_service' );
        }

        return $this->userCodesService;
    }

    /**
     * @return ConfigRead
     */
    protected function getConfigService()
    {
        if (!$this->configReadService) {
            $this->configReadService = $this->getServiceManager()->get( 'pserver_configread_service' );
        }

        return $this->configReadService;
    }

    /**
     * We want to crypt a password =)
     *
     * @param $password
     *
     * @return string
     */
    protected function bcrypt( $password )
    {
        if (!$this->isSamePasswordOption()) {
            return $this->getGameBackendService()->hashPassword( $password );
        }

        $bcrypt = new Bcrypt();
        return $bcrypt->create( $password );
    }

    /**
     * @TODO better error handling
     *
     * @param array $data
     * @param Users $user
     *
     * @return bool
     */
    protected function isPwdChangeAllowed( array $data, Users $user, $errorExtension )
    {
        $form = $this->getChangePwdForm();
        $form->setData( $data );
        if (!$form->isValid()) {
            $this->getFlashMessenger()
                ->setNamespace( \PServerCMS\Controller\AccountController::ERROR_NAME_SPACE . $errorExtension )
                ->addMessage( 'Form not valid.' );
            return false;
        }

        $data = $form->getData();

        if (!$user->hashPassword( $user, $data['currentPassword'] )) {
            $this->getFlashMessenger()
                ->setNamespace( \PServerCMS\Controller\AccountController::ERROR_NAME_SPACE . $errorExtension )
                ->addMessage( 'Wrong Password.' );
            return false;
        }

        return true;
    }

    /**
     * @param $userEntity
     * @param $password
     */
    protected function setNewPasswordAtUser( $userEntity, $password )
    {
        $entityManager = $this->getEntityManager();
        /** @var Users $userEntity */
        $userEntity->setPassword( $this->bcrypt( $password ) );

        $entityManager->persist( $userEntity );
        $entityManager->flush();

        return $userEntity;
    }

    /**
     * @return SecretQuestion
     */
    protected function getSecretQuestionService()
    {
        return $this->getServiceManager()->get( 'pserver_secret_question' );
    }

    /**
     * @return \PServerCMS\Options\EntityOptions
     */
    protected function getEntityOptions()
    {
        return $this->getServiceManager()->get( 'pserver_entity_options' );
    }
}