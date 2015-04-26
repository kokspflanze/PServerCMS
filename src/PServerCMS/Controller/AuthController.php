<?php

namespace PServerCMS\Controller;

use PServerCMS\Entity\UserCodes;

class AuthController extends \SmallUser\Controller\AuthController
{
    protected $passwordLostForm;
    protected $registerForm;
    protected $passwordForm;

    /**
     * @return array|\Zend\Http\Response
     */
    public function registerAction()
    {

        //if already login, redirect to success page
        if ($this->getUserService()->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute( $this->getLoggedInRoute() );
        }

        $form = $this->getUserService()->getRegisterForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = $this->getUserService()->register( $this->params()->fromPost() );
            if ($user) {
                return $this->redirect()->toRoute( 'small-user-auth', array( 'action' => 'register-done' ) );
            }
        }

        return [ 'registerForm' => $form ];
    }

    /**
     * @return array
     */
    public function registerDoneAction()
    {
        return [
            'mail_confirmation' => $this->getUserService()->isRegisterMailConfirmationOption()
        ];
    }

    /**
     * @return array|mixed|\Zend\Http\Response
     */
    public function registerConfirmAction()
    {
        $codeRoute = $this->params()->fromRoute( 'code' );

        $userCode = $this->getCode4Data( $codeRoute, UserCodes::TYPE_REGISTER );
        if (!$userCode) {
            return $this->forward()->dispatch( 'PServerCMS\Controller\Auth', array( 'action' => 'wrong-code' ) );
        }

        $user = $this->getUserService()->registerGameWithSamePassword( $userCode );

        $form    = $this->getUserService()->getPasswordForm();
        $request = $this->getRequest();
        if ($request->isPost() || $user) {
            if (!$user) {
                $user = $this->getUserService()->registerGameWithOtherPw( $this->params()->fromPost(), $userCode );
            }
            if ($user) {
                //$this->getUserService()->doAuthentication($user);
                return $this->redirect()->toRoute( $this->getLoggedInRoute() );
            }
        }

        return [ 'registerForm' => $form ];
    }

    public function ipConfirmAction()
    {
        $code = $this->params()->fromRoute( 'code' );

        $oCode = $this->getCode4Data( $code, UserCodes::TYPE_CONFIRM_COUNTRY );
        if (!$oCode) {
            return $this->forward()->dispatch( 'PServerCMS\Controller\Auth', array( 'action' => 'wrong-code' ) );
        }

        $user = $this->getUserService()->countryConfirm( $oCode );
        if ($user) {
            return $this->redirect()->toRoute( 'small-user-auth', array( 'action' => 'ip-confirm-done' ) );
        }

        return [];
    }

    public function ipConfirmDoneAction()
    {
        return [];
    }

    public function pwLostAction()
    {

        $form = $this->getUserService()->getPasswordLostForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = $this->getUserService()->lostPw( $this->params()->fromPost() );
            if ($user) {
                return $this->redirect()->toRoute( 'small-user-auth', array( 'action' => 'pw-lost-done' ) );
            }
        }

        return [ 'pwLostForm' => $form ];
    }

    public function pwLostDoneAction()
    {
        return [];
    }

    public function pwLostConfirmAction()
    {
        $code = $this->params()->fromRoute( 'code' );

        $codeEntity = $this->getCode4Data( $code, UserCodes::TYPE_LOST_PASSWORD );
        if (!$codeEntity) {
            return $this->forward()->dispatch( 'PServerCMS\Controller\Auth', array( 'action' => 'wrong-code' ) );
        }
        $form = $this->getUserService()->getPasswordForm();
        $form->addSecretQuestion( $codeEntity->getUser() );
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = $this->getUserService()->lostPwConfirm( $this->params()->fromPost(), $codeEntity );
            if ($user) {
                return $this->redirect()->toRoute( 'small-user-auth', array( 'action' => 'pw-lost-confirm-done' ) );
            }
        }

        return [ 'pwLostForm' => $form ];
    }

    public function pwLostConfirmDoneAction()
    {
        return [];
    }

    public function wrongCodeAction()
    {
        return [];
    }

    protected function getCode4Data( $code, $type )
    {
        $entityManager = $this->getEntityManager();
        /** @var $repositoryCode \PServerCMS\Entity\Repository\UserCodes */
        $repositoryCode = $entityManager->getRepository( $this->getEntityOptions()->getUserCodes() );
        $codeEntity     = $repositoryCode->getData4CodeType( $code, $type );

        return $codeEntity;
    }

    /**
     * @return \PServerCMS\Service\User
     */
    protected function getUserService()
    {
        return parent::getUserService();
    }

    /**
     * @return \PServerCMS\Options\EntityOptions
     */
    protected function getEntityOptions()
    {
        return $this->getServiceLocator()->get( 'pserver_entity_options' );
    }
}
