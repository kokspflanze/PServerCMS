<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 15.07.14
 * Time: 02:43
 */

namespace PServerCMS\Service;


use PServerCMS\Entity\Usercodes;
use PServerCMS\Entity\Users;
use PServerCMS\Entity\AvailableCountries;
use PServerCMS\Entity\Repository\AvailableCountries as RepositoryAvailableCountries;
use PServerCMS\Entity\Repository\CountryList;
use PServerCMS\Helper\DateTimer;
use PServerCMS\Helper\Ip;
use PServerCMS\Keys\Entity;
use SmallUser\Entity\UsersInterface;
use SmallUser\Mapper\HydratorUser;
use Zend\Crypt\Password\Bcrypt;

class User extends \SmallUser\Service\User {
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
	 * @param array $aData
	 *
	 * @return Users|bool
	 */
	public function register( array $aData ){

		$oForm = $this->getRegisterForm();
		$oForm->setHydrator( new HydratorUser() );
		$oForm->bind( new Users() );
		$oForm->setData($aData);
		if(!$oForm->isValid()){
			return false;
		}

		$oEntityManager = $this->getEntityManager();
		/** @var Users $userEntity */
		$userEntity = $oForm->getData();
		$userEntity->setCreateip(Ip::getIp());
		$userEntity->setPassword($this->bcrypt($userEntity->getPassword()));

		$oEntityManager->persist($userEntity);
		$oEntityManager->flush();

		$sCode = $this->getUserCodesService()->setCode4User($userEntity, \PServerCMS\Entity\Usercodes::Type_Register);

		$this->getMailService()->register($userEntity, $sCode);

		return $userEntity;
	}

	/**
	 * @param Usercodes $userCode
	 *
	 * @return Users
	 */
	public function registerGameWithSamePassword( Usercodes $userCode ){

		$option = $this->getConfigService()->get('pserver.password.different-passwords');

		// config is different pw-system
		if($option){
			return null;
		}

		$user = $this->registerGame( $userCode->getUsersUsrid());
		if($user){
			$this->getUserCodesService()->deleteCode($userCode);
		}

		return $user;
	}

	/**
	 * @param array     $data
	 * @param Usercodes $userCode
	 *
	 * @return Users|bool
	 */
	public function registerGameWithOtherPw( array $data, Usercodes $userCode ){

		$form = $this->getPasswordForm();

		$form->setData($data);
		if(!$form->isValid()){
			return false;
		}

		$data = $form->getData();
		$plainPassword = $data['password'];

		$user = $this->registerGame( $userCode->getUsersUsrid(), $plainPassword);

		if($user){
			$this->getUserCodesService()->deleteCode($userCode);
		}

		return $user;
	}

	/**
	 * @param Users  $user
	 * @param string $plainPassword
	 *
	 * @return Users
	 */
	public function registerGame( Users $user, $plainPassword = '' ){

		$gameBackend = $this->getGameBackendService();

		$backendId = $gameBackend->setUser($user, $plainPassword);
		$user->setBackendId($backendId);

		$entityManager = $this->getEntityManager();
		/** user have already a backendId, so better to set it there */
		$entityManager->persist($user);
		$entityManager->flush();

		/** @var CountryList $countryList */
		$countryList = $entityManager->getRepository(Entity::CountryList);
		$availableCountries = new AvailableCountries();
		$availableCountries->setActive('1');
		$availableCountries->setUsersUsrid($user);
		$availableCountries->setCntry($countryList->getCountryCode4Ip(Ip::getIp()));

		$repositoryRole = $entityManager->getRepository(Entity::UserRole);
		$role = $this->getConfigService()->get('pserver.register.role','user');
		$roleEntity = $repositoryRole->findOneBy(array('roleId' => $role));

		// add the ROLE + Remove the Key
		$user->addUserRole($roleEntity);
		$roleEntity->addUsersUsrid($user);
		$entityManager->persist($user);
		$entityManager->persist($roleEntity);
		$entityManager->persist($availableCountries);
		$entityManager->flush();

		return $user;
	}

    /**
     * @param array $data
     * @param Users $user
     * @return bool|null|Users
     */
    public function changeWebPwd( array $data, Users $user ){
		$user = $this->getUser4Id($user->getId());

		// check if we use different pw system
		if(!$this->isSamePasswordOption()){
			return false;
		}

        if(!$this->isPwdChangeAllowed($data, $user, 'Web')){
			return false;
		}

		$user = $this->setNewPasswordAtUser($user, $data['password']);

		return $user;
    }

    /**
     * @param array $data
     * @param Users $user
     * @return bool
     */
    public function changeIngamePwd( array $data, Users $user ){
		$user = $this->getUser4Id($user->getId());
        if(!$this->isPwdChangeAllowed($data, $user, 'InGame')){
			return false;
        }

		// check if we have to change it at web too
		if(!$this->isSamePasswordOption()){
			$user = $this->setNewPasswordAtUser($user, $data['password']);
		}

		$gameBackend = $this->getGameBackendService();
		$gameBackend->setUser($user, $data['password']);
		return $user;
    }

	public function lostPw( array $aData ){

		$oForm = $this->getPasswordLostForm();

		$oForm->setData($aData);
		if(!$oForm->isValid()){
			return false;
		}

		$aData = $oForm->getData();

		$oEntityManager = $this->getEntityManager();
		$oUser = $oEntityManager->getRepository(Entity::Users)->findOneBy(array('username' => $aData['username']));


		$sCode = $this->getUserCodesService()->setCode4User($oUser, \PServerCMS\Entity\Usercodes::Type_LostPassword);

		$this->getMailService()->lostPw($oUser, $sCode);

		return $oUser;
	}

	public function lostPwConfirm( array $data, Usercodes $userCode ){

		$oForm = $this->getPasswordForm();

		$oForm->setData($data);
		if(!$oForm->isValid()){
			return false;
		}

		$data = $oForm->getData();
		$sPlainPassword = $data['password'];
		$userEntity = $userCode->getUsersUsrid();

		$this->setNewPasswordAtUser( $userEntity, $sPlainPassword );

		$this->getUserCodesService()->deleteCode($userCode);

		if(!$this->isSamePasswordOption()){
			$gameBackend = $this->getGameBackendService();
			$gameBackend->setUser($userEntity, $sPlainPassword);
		}

		return $userEntity;
	}

    public function countryConfirm( Usercodes $oUserCodes ){
        $oEntityManager = $this->getEntityManager();

        /** @var Users $oUserEntity */
        $oUserEntity = $oUserCodes->getUsersUsrid();

		/** @var CountryList $oCountryList */
		$oCountryList = $oEntityManager->getRepository(Entity::CountryList);
		$sCountry = $oCountryList->getCountryCode4Ip(Ip::getIp());

		/** @var AvailableCountries $oAvailableCountries */
		$class = Entity::AvailableCountries;
        $oAvailableCountries = new $class();
        $oAvailableCountries->setCntry($sCountry);
        $oAvailableCountries->setUsersUsrid($oUserEntity);

        $oEntityManager->persist($oAvailableCountries);
        $oEntityManager->remove($oUserCodes);
        $oEntityManager->flush();

        return $oUserEntity;
    }

	/**
	 * @param Users $oUser
	 * @return bool
	 */
	protected function isValidLogin(UsersInterface $oUser) {
		if (!(bool)$oUser->getUserRole()->getKeys()) {
			$this->setFailedLoginMessage('Your Account is not active, please confirm your email');
			return false;
		}
		if(!$this->isCountryAllowed($oUser)){
			return false;
		}
		if($this->isUserBlocked($oUser)){
			return false;
		}
		return true;
	}

	/**
	 * @param Users $oUser
	 * @return bool
	 */
	protected function isCountryAllowed(UsersInterface $oUser) {
		$oEntityManager = $this->getEntityManager();

		/** @var CountryList $oCountryList */
		$oCountryList = $oEntityManager->getRepository(Entity::CountryList);
		$sCountry = $oCountryList->getCountryCode4Ip(Ip::getIp());
		/** @var RepositoryAvailableCountries $oAvailableCountries */
		$oAvailableCountries = $oEntityManager->getRepository(Entity::AvailableCountries);
		if(!$oAvailableCountries->isCountryAllowedForUser($oUser->getUsrid(), $sCountry)){
			$sCode = $this->getUserCodesService()->setCode4User($oUser, \PServerCMS\Entity\Usercodes::Type_ConfirmCountry);
			$this->getMailService()->confirmCountry($oUser, $sCode);
			$this->getFlashMessenger()->setNamespace(self::ErrorNameSpace)->addMessage('Please confirm your new ip with your email');
			return false;
		}
		return true;
	}

	/**
	 * @param Users $oUser
	 * @return bool
	 */
	protected function isUserBlocked(UsersInterface $oUser) {
		$oEntityManager = $this->getEntityManager();
		/** @var \PServerCMS\Entity\Repository\UserBlock $RepositoryUserBlock */
		$RepositoryUserBlock = $oEntityManager->getRepository(Entity::UserBlock);
		$oIsUserBlocked = $RepositoryUserBlock->isUserAllowed( $oUser->getUsrid() );
		if($oIsUserBlocked){
			$this->getFlashMessenger()->setNamespace(self::ErrorNameSpace)->addMessage('You are blocked because '.$oIsUserBlocked->getReason().' !, try it again '.$oIsUserBlocked->getExpire()->format('H:i:s'));
			return true;
		}
		return false;
	}

    /**
     * @param $userId
     *
     * @return null|\PServerCMS\Entity\Users
     */
    protected function getUser4Id( $userId ){
        $entityManager = $this->getEntityManager();
        return $entityManager->getRepository('PServerCMS\Entity\Users')->findOneBy(array('usrid' => $userId));
    }

	/**
	 * @param Users $oUser
	 */
	protected function doLogin(UsersInterface $oUser) {
		parent::doLogin($oUser);
		$oEntityManager = $this->getEntityManager();
		/**
		 * Set LoginHistory
		 */
		$class = Entity::LoginHistory;
		/** @var \PServerCMS\Entity\LoginHistory $oLoginHistory */
		$oLoginHistory = new $class();
		$oLoginHistory->setUsersUsrid($oUser);
		$oLoginHistory->setIp(Ip::getIp());
		$oEntityManager->persist($oLoginHistory);
		$oEntityManager->flush();
	}

	protected function handleInvalidLogin(UsersInterface $oUser) {
		$iMaxTries = $this->getConfigService()->get('pserver.login.exploit.try');
		if(!$iMaxTries){
			return false;
		}

		$oEntityManager = $this->getEntityManager();
		/**
		 * Set LoginHistory
		 */
		$class = Entity::LoginFailed;
		/** @var \PServerCMS\Entity\Loginfaild $oLoginFailed */
		$oLoginFailed = new $class();
		$oLoginFailed->setUsername($oUser->getUsername());
		$oLoginFailed->setIp(Ip::getIp());
		$oEntityManager->persist($oLoginFailed);
		$oEntityManager->flush();

		$iTime = $this->getConfigService()->get('pserver.login.exploit.time');

		/** @var \PServerCMS\Entity\Repository\LoginFaild $oRepositoryLoginFailed */
		$oRepositoryLoginFailed = $oEntityManager->getRepository($class);
		if($oRepositoryLoginFailed->getNumberOfFailLogins4Ip(Ip::getIp(), $iTime) >= $iMaxTries){
			$class = Entity::IpBlock;
			/** @var \PServerCMS\Entity\Ipblock $oIPBlock */
			$oIPBlock = new $class();
			$oIPBlock->setExpire(DateTimer::getDateTime4TimeStamp(time()+$iTime));
			$oIPBlock->setIp(Ip::getIp());
			$oEntityManager->persist($oIPBlock);
			$oEntityManager->flush();
		}
	}

	/**
	 * @return bool
	 */
	protected function isIpAllowed(){
		$oEntityManager = $this->getEntityManager();
		/** @var \PServerCMS\Entity\Repository\IPBlock $RepositoryIPBlock */
		$RepositoryIPBlock = $oEntityManager->getRepository(Entity::IpBlock);
		$oIsIpAllowed = $RepositoryIPBlock->isIPAllowed( Ip::getIp() );
		if($oIsIpAllowed){
			$this->getFlashMessenger()->setNamespace(self::ErrorNameSpace)->addMessage('Your IP is blocked!, try it again '.$oIsIpAllowed->getExpire()->format('H:i:s'));
			return false;
		}
		return true;
	}

	/**
	 * @return \PServerCMS\Form\Register
	 */
	public function getRegisterForm() {
		if (! $this->registerForm) {
			$this->registerForm = $this->getServiceManager()->get('pserver_user_register_form');
		}

		return $this->registerForm;
	}

	/**
	 * @return \PServerCMS\Form\Password
	 */
	public function getPasswordForm() {
		if (! $this->passwordForm) {
			$this->passwordForm = $this->getServiceManager()->get('pserver_user_password_form');
		}

		return $this->passwordForm;
	}

	/**
	 * Login with a User
	 * @param UsersInterface $user
	 */
	public function doAuthentication( Users $user ){
		$find = array($this->getUserEntityUserName() => $user->getUsername());
		$userNew = $this->getEntityManager()->getRepository($this->getUserEntityClassName())->findOneBy($find);

		$authService = $this->getAuthService();
		// FIX: no roles after register
		$userNew->getUserRole();
		$userNew->getUserExtension();
		$authService->getStorage()->write($userNew);
	}

	/**
	 * @return \PServerCMS\Form\PwLost
	 */
	public function getPasswordLostForm() {
		if (! $this->passwordLostForm) {
			$this->passwordLostForm = $this->getServiceManager()->get('pserver_user_pwlost_form');
		}

		return $this->passwordLostForm;
	}

	/**
	 * @return \PServerCMS\Form\ChangePwd
	 */
    public function getChangePwdForm(){
        return $this->getServiceManager()->get('pserver_user_changepwd_form');
    }

	/**
	 * read from the config if system works for different pws @ web and in-game or with same
	 * @return boolean
	 */
	public function isSamePasswordOption(){
		return (bool) $this->getConfigService()->get('pserver.password.different-passwords');
	}

	/**
	 * @return \GameBackend\DataService\DataServiceInterface
	 */
	public function getGameBackendService() {
		if (! $this->gameBackendService) {
			$this->gameBackendService = $this->getServiceManager()->get('gamebackend_dataservice');
		}

		return $this->gameBackendService;
	}

	/**
	 * @return \PServerCMS\Service\Mail
	 */
	protected function getMailService() {
		if (! $this->mailService) {
			$this->mailService = $this->getServiceManager()->get('pserver_mail_service');
		}

		return $this->mailService;
	}

	/**
	 * @return \PServerCMS\Service\UserCodes
	 */
	protected function getUserCodesService() {
		if (! $this->userCodesService) {
			$this->userCodesService = $this->getServiceManager()->get('pserver_usercodes_service');
		}

		return $this->userCodesService;
	}

	/**
	 * @return ConfigRead
	 */
	protected function getConfigService() {
		if (!$this->configReadService) {
			$this->configReadService = $this->getServiceManager()->get('pserver_configread_service');
		}

		return $this->configReadService;
	}

	/**
	 * We want to crypt a password =)
	 * @param $password
	 *
	 * @return string
	 */
    protected function bcrypt($password){
		if(!$this->isSamePasswordOption()){
			return $this->getGameBackendService()->hashPassword($password);
		}

        $bcrypt = new Bcrypt();
        return $bcrypt->create($password);
    }

	/**
	 * @TODO better error handling
	 * @param array $data
	 * @param Users $user
	 * @return bool
	 */
	protected function isPwdChangeAllowed( array $data, Users $user, $errorExtension){
		$form = $this->getChangePwdForm();
		$form->setData($data);
		if(!$form->isValid()){
			$this->getFlashMessenger()->setNamespace(\PServerCMS\Controller\AccountController::ErrorNameSpace.$errorExtension)->addMessage('Form not valid.');
			return false;
		}

		$data = $form->getData();

		if(!$user->hashPassword($user, $data['currentPassword'])){
			$this->getFlashMessenger()->setNamespace(\PServerCMS\Controller\AccountController::ErrorNameSpace.$errorExtension)->addMessage('Wrong Password.');
			return false;
		}

		return true;
	}

	/**
	 * @param $userEntity
	 * @param $password
	 */
	protected function setNewPasswordAtUser( $userEntity, $password ) {
		$entityManager = $this->getEntityManager();
		/** @var Users $userEntity */
		$userEntity->setPassword( $this->bcrypt( $password ) );

		$entityManager->persist( $userEntity );
		$entityManager->flush();

		return $userEntity;
	}
}