<?php

namespace PServerCMS\Controller;

use PServerCMS\Entity\Usercodes;
use PServerCMS\Keys\Entity;
use Zend\Mvc\Controller\AbstractActionController;

class AuthController extends \SmallUser\Controller\AuthController {
	protected $passwordLostForm;
	protected $registerForm;
	protected $passwordForm;

	public function registerAction(){

		//if already login, redirect to success page
		if ($this->getUserService()->getAuthService()->hasIdentity()){
			return $this->redirect()->toRoute(self::RouteLoggedIn);
		}

		$oForm = $this->getUserService()->getRegisterForm();

		$oRequest = $this->getRequest();
		if($oRequest->isPost()){
			$oUser = $this->getUserService()->register($this->params()->fromPost());
			if($oUser){
				return $this->redirect()->toRoute('small-user-auth', array('action' => 'register-done'));
			}
		}

		return array('registerForm' => $oForm);
	}

	public function registerDoneAction(){
		return array();
	}

	public function registerConfirmAction(){
		$codeRoute = $this->params()->fromRoute('code');

		$userCode = $this->getCode4Data($codeRoute, Usercodes::Type_Register);
		if(!$userCode){
			return $this->forward()->dispatch('PServerCMS\Controller\Auth', array('action' => 'wrong-code'));
		}

		$user = $this->getUserService()->registerGameWithSamePassword($userCode);

		$form = $this->getUserService()->getPasswordForm();
		$request = $this->getRequest();
		if($request->isPost() || $user){
			if(!$user) {
				$user = $this->getUserService()->registerGameWithOtherPw($this->params()->fromPost(), $userCode);
			}
			if($user){
				//$this->getUserService()->doAuthentication($user);
				return $this->redirect()->toRoute('home');
			}
		}

		return array('registerForm' => $form);
	}

    public function ipConfirmAction(){
        $code = $this->params()->fromRoute('code');

		$oCode = $this->getCode4Data($code, Usercodes::Type_ConfirmCountry);
		if(!$oCode){
			return $this->forward()->dispatch('PServerCMS\Controller\Auth', array('action' => 'wrong-code'));
		}

        $user = $this->getUserService()->countryConfirm($oCode);
        if($user){
            return $this->redirect()->toRoute('small-user-auth', array('action' => 'ip-confirm-done'));
        }

        return array();
    }

    public function ipConfirmDoneAction(){
        return array();
    }

	public function pwLostAction(){

		$form = $this->getUserService()->getPasswordLostForm();

		$request = $this->getRequest();
		if($request->isPost()){
			$user = $this->getUserService()->lostPw($this->params()->fromPost());
			if($user){
				return $this->redirect()->toRoute('small-user-auth', array('action' => 'pw-lost-done'));
			}
		}

		return array('pwLostForm' => $form);
	}

	public function pwLostDoneAction(){
		return array();
	}

	public function pwLostConfirmAction(){
		$code = $this->params()->fromRoute('code');

		$codeEntity = $this->getCode4Data($code, Usercodes::Type_LostPassword);
		if(!$codeEntity){
			return $this->forward()->dispatch('PServerCMS\Controller\Auth', array('action' => 'wrong-code'));
		}

		$form = $this->getUserService()->getPasswordForm();
		$form->setUser($codeEntity->getUser());
		$request = $this->getRequest();
		if($request->isPost()){
			$user = $this->getUserService()->lostPwConfirm($this->params()->fromPost(), $codeEntity);
			if($user){
				return $this->redirect()->toRoute('small-user-auth', array('action' => 'pw-lost-confirm-done'));
			}
		}

		return array('pwLostForm' => $form);
	}

	public function pwLostConfirmDoneAction(){
		return array();
	}

	public function wrongCodeAction(){
		return array();
	}

	protected function getCode4Data($sCode, $sType){
		$oEntityManager = $this->getEntityManager();
		/** @var $oRepositoryCode \PServerCMS\Entity\Repository\Usercodes */
		$oRepositoryCode = $oEntityManager->getRepository(Entity::UserCodes);
		$oCode = $oRepositoryCode->getData4CodeType($sCode, $sType);

		return $oCode;
	}
	/**
	 * @return \PServerCMS\Service\User
	 */
	protected function getUserService(){
		return parent::getUserService();
	}
}
