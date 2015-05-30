<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\UserCodes;
use PServerCMS\Entity\UserInterface;
use PServerCMS\Helper\HelperOptions;
use SmallUser\Entity\UserInterface as SmallUserInterface;
use PServerCMS\Entity\User as Entity;
use PServerCMS\Entity\Repository\AvailableCountries as RepositoryAvailableCountries;
use PServerCMS\Entity\Repository\CountryList;
use PServerCMS\Helper\DateTimer;
use PServerCMS\Helper\Ip;
use PServerCMS\Validator\AbstractRecord;
use SmallUser\Mapper\HydratorUser;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class User
 * @package PServerCMS\Service
 * @TODO refactoring
 */
class User extends \SmallUser\Service\User
{
    use HelperOptions;

    /**
     * @param array $data
     * @return bool
     */
    public function login( array $data )
    {
        $result = parent::login($data);
        if (!$result) {
            $form = $this->getLoginForm();
            $error = $form->getMessages('username');
            if($error && isset($error[AbstractRecord::ERROR_NOT_ACTIVE])){
                $this->getFlashMessenger()->setNamespace(self::ErrorNameSpace)->addMessage($error[AbstractRecord::ERROR_NOT_ACTIVE]);
            }
        }

        return $result;
    }

    /**
     * @param array $data
     * @return UserInterface|bool
     */
    public function register( array $data )
    {
        $form = $this->getRegisterForm();
        $form->setHydrator( new HydratorUser() );
        $form->bind( new Entity() );
        $form->setData( $data );
        if (!$form->isValid()) {
            return false;
        }

        $entityManager = $this->getEntityManager();
        /** @var Entity $userEntity */
        $userEntity = $form->getData();
        $userEntity->setCreateIp( Ip::getIp() );
        $userEntity->setPassword( $this->bCrypt( $userEntity->getPassword() ) );

        $entityManager->persist( $userEntity );
        $entityManager->flush();

        if ($this->isRegisterMailConfirmationOption()) {
            $code = $this->getUserCodesService()->setCode4User( $userEntity, UserCodes::TYPE_REGISTER );

            $this->getMailService()->register( $userEntity, $code );
        } else {
            $userEntity = $this->registerGame( $userEntity, $userEntity->getPassword() );
            $this->setAvailableCountries4User($userEntity, Ip::getIp());
            //valid identity after register with no mail
            $this->doAuthentication($userEntity);
        }

        if ($this->isSecretQuestionOption()) {
            $this->getSecretQuestionService()->setSecretAnswer( $userEntity, $data['question'], $data['answer'] );
        }

        return $userEntity;
    }

    /**
     * @param UserCodes $userCode
     * @return UserInterface|null
     */
    public function registerGameWithSamePassword( UserCodes $userCode )
    {
        $user = null;
        // config is different pw-system
        if ($this->isSamePasswordOption()) {
            $user = $this->registerGameForm($userCode);
        }

        return $user;
    }

    /**
     * @param array     $data
     * @param UserCodes $userCode
     * @return UserInterface|bool
     */
    public function registerGameWithOtherPw( array $data, UserCodes $userCode )
    {
        $form = $this->getPasswordForm();

        $form->setData( $data );
        if (!$form->isValid()) {
            return false;
        }

        $data          = $form->getData();
        $plainPassword = $data['password'];
        $user = $this->registerGameForm($userCode, $plainPassword);

        return $user;
    }

    /**
     * @param UserCodes $userCode
     * @param null      $plainPassword
     * @return UserInterface
     */
    public function registerGameForm( UserCodes $userCode, $plainPassword = null )
    {
        $user = $this->registerGame( $userCode->getUser(), $plainPassword );
        $this->setAvailableCountries4User($user, Ip::getIp());

        if ($user) {
            $this->getUserCodesService()->deleteCode( $userCode );
            //user logged-in after confirmation
            $this->doAuthentication($user);
        }

        return $user;
    }

    /**
     * @param array $data
     * @param UserInterface $user
     * @return bool|null|UserInterface
     */
    public function changeWebPwd( array $data, UserInterface $user )
    {
        $user = $this->getUser4Id( $user->getId() );

        // check if we use different pw system
        if ($this->isSamePasswordOption()) {
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
     * @param UserInterface $user
     * @return bool
     */
    public function changeInGamePwd( array $data, UserInterface $user )
    {
        $user = $this->getUser4Id( $user->getId() );
        if (!$this->isPwdChangeAllowed( $data, $user, 'InGame' )) {
            return false;
        }

        // check if we have to change it at web too
        if ($this->isSamePasswordOption()) {
            $user = $this->setNewPasswordAtUser( $user, $data['password'] );
        }

        $gameBackend = $this->getGameBackendService();
        $gameBackend->setUser( $user, $data['password'] );

        return $user;
    }

    /**
     * @param array $data
     * @return bool|null|UserInterface
     */
    public function lostPw( array $data )
    {
        $form = $this->getPasswordLostForm();
        $form->setData( $data );

        if (!$form->isValid()) {
            return false;
        }

        $data = $form->getData();

        /** @var \PServerCMS\Entity\Repository\User $userRepository */
        $userRepository = $this->getEntityManager()->getRepository( $this->getEntityOptions()->getUser() );
        $user = $userRepository->getUser4UserName( $data['username'] );

        $code = $this->getUserCodesService()->setCode4User( $user, UserCodes::TYPE_LOST_PASSWORD );

        $this->getMailService()->lostPw( $user, $code );

        return $user;
    }

    /**
     * @param array     $data
     * @param UserCodes $userCode
     * @return bool|User
     */
    public function lostPwConfirm( array $data, UserCodes $userCode )
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

        if ($this->isSamePasswordOption()) {
            $gameBackend = $this->getGameBackendService();
            $gameBackend->setUser( $userEntity, $sPlainPassword );
        }

        return $userEntity;
    }

    /**
     * @param UserCodes $userCodes
     * @return UserInterface
     */
    public function countryConfirm( UserCodes $userCodes )
    {
        $entityManager = $this->getEntityManager();

        /** @var User $userEntity */
        $userEntity = $userCodes->getUser();
        $this->setAvailableCountries4User($userEntity, Ip::getIp());

        $entityManager->remove( $userCodes );
        $entityManager->flush();

        return $userEntity;
    }

    /**
     * @param UserInterface  $user
     * @param string $plainPassword
     * @return UserInterface
     */
    protected function registerGame( UserInterface $user, $plainPassword = '' )
    {
        $gameBackend = $this->getGameBackendService();

        $backendId = $gameBackend->setUser( $user, $plainPassword );
        $user->setBackendId( $backendId );

        $entityManager = $this->getEntityManager();
        /** user have already a backendId, so better to set it there */
        $entityManager->persist( $user );
        $entityManager->flush();

        $user = $this->addDefaultRole($user);

        return $user;
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    protected function addDefaultRole( UserInterface $user )
    {
        $entityManager = $this->getEntityManager();
        /** @var \PServerCMS\Entity\Repository\UserRole $repositoryRole */
        $repositoryRole = $entityManager->getRepository( $this->getEntityOptions()->getUserRole() );
        $role           = $this->getConfigService()->get( 'pserver.register.role', 'user' );
        $roleEntity     = $repositoryRole->getRole4Name( $role );

        // add the ROLE + Remove the Key
        $user->addUserRole( $roleEntity );
        $roleEntity->addUser( $user );
        $entityManager->persist( $user );
        $entityManager->persist( $roleEntity );
        $entityManager->flush();

        return $user;
    }

    /**
     * @param UserInterface $user
     * @param string        $ip
     */
    protected function setAvailableCountries4User( UserInterface $user, $ip )
    {
        // skip if the config say no check, so we don´t have to save the country in list
        if (!$this->isCountryCheckOption()) {
            return;
        }

        $entityManager = $this->getEntityManager();
        /** @var CountryList $countryList */
        $countryList        = $entityManager->getRepository( $this->getEntityOptions()->getCountryList() );
        $class = $this->getEntityOptions()->getAvailableCountries();
        /** @var \PServerCMS\Entity\AvailableCountries $availableCountries */
        $availableCountries = new $class;
        $availableCountries->setUser( $user );
        $availableCountries->setCntry( $countryList->getCountryCode4Ip( $ip ) );
        $entityManager->persist( $availableCountries );
        $entityManager->flush();
    }

    /**
     * @param SmallUserInterface $user
     * @return bool
     */
    protected function isValidLogin( SmallUserInterface $user )
    {
        $result = true;

        if ($this->isCountryCheckOption() && !$this->isCountryAllowed( $user )) {
            $result = false;
        }

        if ($this->isUserBlocked( $user )) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    protected function isCountryAllowed( UserInterface $user )
    {
        $result = true;
        $entityManager = $this->getEntityManager();

        /** @var CountryList $countryList */
        $countryList = $entityManager->getRepository( $this->getEntityOptions()->getCountryList() );
        $country     = $countryList->getCountryCode4Ip( Ip::getIp() );
        /** @var RepositoryAvailableCountries $availableCountries */
        $availableCountries = $entityManager->getRepository( $this->getEntityOptions()->getAvailableCountries() );

        if (!$availableCountries->isCountryAllowedForUser( $user->getId(), $country )) {
            $code = $this->getUserCodesService()->setCode4User( $user, UserCodes::TYPE_CONFIRM_COUNTRY );
            $this->getMailService()->confirmCountry( $user, $code );
            $this->getFlashMessenger()->setNamespace( self::ErrorNameSpace )->addMessage( 'Please confirm your new ip with your email' );
            $result = false;
        }

        return $result;
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    protected function isUserBlocked( UserInterface $user )
    {
        $userBlocked = $this->getUserBlockService()->isUserBlocked($user);
        $result = false;

        if ($userBlocked) {
            $message = sprintf(
                'You are blocked because %s!, try it again @ %s',
                $userBlocked->getReason(),
                $userBlocked->getExpire()->format(
                    $this->getDateTimeFormatTime()
                )
            );
            $this->getFlashMessenger()->setNamespace( self::ErrorNameSpace )->addMessage($message);
            $result = true;
        }

        return $result;
    }

    /**
     * @param $userId
     * @return null|UserInterface
     */
    protected function getUser4Id( $userId )
    {
        /** @var \PServerCMS\Entity\Repository\User $userRepository */
        $userRepository = $this->getEntityManager()->getRepository( $this->getEntityOptions()->getUser() );

        return $userRepository->getUser4Id( $userId );
    }

    /**
     * @param SmallUserInterface $user
     */
    protected function doLogin( SmallUserInterface $user )
    {
        parent::doLogin( $user );
        $entityManager = $this->getEntityManager();
        /**
         * Set LoginHistory
         */
        $class = $this->getEntityOptions()->getLoginHistory();
        /** @var \PServerCMS\Entity\LoginHistory $loginHistory */
        $loginHistory = new $class();
        $loginHistory->setUser( $user );
        $loginHistory->setIp( Ip::getIp() );
        $entityManager->persist( $loginHistory );
        $entityManager->flush();
    }

    /**
     * @param SmallUserInterface $user
     * @return bool
     */
    protected function handleInvalidLogin( SmallUserInterface $user )
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
        /** @var \PServerCMS\Entity\LoginFailed $loginFailed */
        $loginFailed = new $class();
        $loginFailed->setUsername( $user->getUsername() );
        $loginFailed->setIp( Ip::getIp() );
        $entityManager->persist( $loginFailed );
        $entityManager->flush();

        $time = $this->getConfigService()->get( 'pserver.login.exploit.time' );

        /** @var \PServerCMS\Entity\Repository\LoginFailed $repositoryLoginFailed */
        $repositoryLoginFailed = $entityManager->getRepository( $class );

        if ($repositoryLoginFailed->getNumberOfFailLogin4Ip( Ip::getIp(), $time ) >= $maxTries) {
            $class = $this->getEntityOptions()->getIpBlock();
            /** @var \PServerCMS\Entity\IpBlock $ipBlock */
            $ipBlock = new $class();
            $ipBlock->setExpire( DateTimer::getDateTime4TimeStamp( time() + $time ) );
            $ipBlock->setIp( Ip::getIp() );
            $entityManager->persist( $ipBlock );
            $entityManager->flush();
        }

        return true;
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
        $result = true;

        if ($ipAllowed) {
            $message = sprintf( 'Your IP is blocked!, try it again @ %s', $ipAllowed->getExpire()->format( 'H:i:s' ) );
            $this->getFlashMessenger()->setNamespace( self::ErrorNameSpace )->addMessage( $message );
            $result = false;
        }

        return $result;
    }

    /**
     * Login with a User
     *
     * @param UserInterface $user
     */
    public function doAuthentication( UserInterface $user )
    {
        /** @var \PServerCMS\Entity\Repository\User $repository */
        $repository = $this->getEntityManager()->getRepository( $this->getUserEntityClassName() );

        // fix if we have a proxy we don´t have a valid entity, so we have to clear before we can create a new select
        $repository->clear();

        $userNew = $repository->getUser4UserName( $user->getUsername() );

        $authService = $this->getAuthService();

        $authService->getStorage()->write( $userNew );
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
     * read from the config if system works for different pws @ web and in-game or with same
     * @return boolean
     */
    public function isSamePasswordOption()
    {
        return $this->getPasswordOptions()->isDifferentPasswords();
    }

    /**
     * read from the config if system works with the country check for login
     * @return boolean
     */
    public function isCountryCheckOption()
    {
        return (bool)$this->getConfigService()->get( 'pserver.login.country-check' );
    }

    /**
     * @return boolean
     */
    public function isRegisterDynamicImport()
    {
        return (bool)$this->getConfigService()->get( 'pserver.register.dynamic-import' );
    }

    /**
     * read from the config if system works for secret question
     * @return boolean
     */
    public function isSecretQuestionOption()
    {
        return $this->getPasswordOptions()->isSecretQuestion();
    }

    /**
     * read from the config if system works with mail confirmation
     * @return boolean
     */
    public function isRegisterMailConfirmationOption()
    {
        return (bool)$this->getConfigService()->get( 'pserver.register.mail_confirmation' );
    }

    /**
     * @return string
     */
    public function getDateTimeFormatTime()
    {
        return $this->getConfigService()->get('pserver.general.datetime.format.time');
    }

    /**
     * We want to crypt a password =)
     *
     * @param $password
     *
     * @return string
     */
    protected function bCrypt( $password )
    {
        if ($this->isSamePasswordOption()) {
            $result = $this->getGameBackendService()->hashPassword( $password );
        } else {
            $bCrypt = new Bcrypt();
            $result = $bCrypt->create( $password );
        }

        return $result;
    }

    /**
     * @TODO better error handling
     *
     * @param array $data
     * @param UserInterface $user
     *
     * @return bool
     */
    protected function isPwdChangeAllowed( array $data, UserInterface $user, $errorExtension )
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
     * @param UserInterface $user
     * @param $password
     * @return UserInterface
     */
    protected function setNewPasswordAtUser( UserInterface $user, $password )
    {
        $entityManager = $this->getEntityManager();
        $user->setPassword( $this->bCrypt( $password ) );

        $entityManager->persist( $user );
        $entityManager->flush();

        return $user;
    }

    /**
     * @param SmallUserInterface $user
     * @return boolean
     */
    protected function handleAuth4UserLogin( SmallUserInterface $user )
    {
        if ($this->isRegisterDynamicImport()) {
            /** @var \PServerCMS\Entity\Repository\User $userRepository */
            $userRepository = $this->getEntityManager()->getRepository( $this->getEntityOptions()->getUser() );
            if (!$userRepository->getUser4UserName($user->getUsername())) {
                if ($backendUser = $this->getGameBackendService()->getUser4Login($user)) {

                    if (!$backendUser->getCreateIp()) {
                        $backendUser->setCreateIp(IP::getIp());
                    }

                    $backendUser->setPassword( $this->bCrypt( $user->getPassword() ) );
                    $entityManager = $this->getEntityManager();
                    $entityManager->persist($backendUser);
                    $entityManager->flush();

                    $this->setAvailableCountries4User($backendUser, Ip::getIp());
                    $this->addDefaultRole($backendUser);

                    $this->doAuthentication($backendUser);

                    return true;
                }
            }
        }

        return parent::handleAuth4UserLogin($user);
    }

    /**
     * @param UserInterface $entity
     * @param string $plaintext
     * @return bool
     */
    public function hashPassword( UserInterface $entity, $plaintext )
    {
        if ($this->isSamePasswordOption()) {
            return $this->getGameBackendService()->isPasswordSame( $entity->getPassword(), $plaintext );
        }

        $bcrypt = new Bcrypt();

        return $bcrypt->verify( $plaintext, $entity->getPassword() );
    }
}