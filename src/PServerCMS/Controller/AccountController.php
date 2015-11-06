<?php

namespace PServerCMS\Controller;

use PServerCMS\Helper\HelperForm;
use PServerCMS\Helper\HelperService;
use PServerCMS\Helper\HelperServiceLocator;
use PServerCMS\Service;
use Zend\Mvc\Controller\AbstractActionController;

class AccountController extends AbstractActionController
{
    use HelperServiceLocator, HelperForm, HelperService;

    const ERROR_NAME_SPACE = 'pserver-user-account-error';
    const SUCCESS_NAME_SPACE = 'pserver-user-account-success';

    public function indexAction()
    {
        /** @var \PServerCMS\Entity\UserInterface $user */
        $user = $this->getUserService()->getAuthService()->getIdentity();

        $form = $this->getChangePwdForm();
        $elements = $form->getElements();
        foreach ($elements as $element) {
            if ($element instanceof \Zend\Form\Element) {
                $element->setValue('');
            }
        }

        $formChangeWebPwd = null;
        if (!$this->getUserService()->isSamePasswordOption()) {
            $webPasswordForm = clone $form;
            $formChangeWebPwd = $webPasswordForm->setWhich('web');
        }

        $inGamePasswordForm = clone $form;
        $formChangeIngamePwd = $inGamePasswordForm->setWhich('ingame');

        $addEmailForm = null;
        if (!$user->getEmail()) {
            $addEmailForm = $this->getAddEmailForm();
        }

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return [
                'changeWebPwdForm' => $formChangeWebPwd,
                'changeIngamePwdForm' => $formChangeIngamePwd,
                'addEmailForm' => $addEmailForm,
                'messagesWeb' => $this->flashmessenger()->getMessagesFromNamespace(self::SUCCESS_NAME_SPACE . 'Web'),
                'messagesInGame' => $this->flashmessenger()->getMessagesFromNamespace(self::SUCCESS_NAME_SPACE . 'InGame'),
                'messagesAddEmail' => $this->flashmessenger()->getMessagesFromNamespace(self::SUCCESS_NAME_SPACE . 'AddEmail'),
                'errorsWeb' => $this->flashmessenger()->getMessagesFromNamespace(self::ERROR_NAME_SPACE . 'Web'),
                'errorsInGame' => $this->flashmessenger()->getMessagesFromNamespace(self::ERROR_NAME_SPACE . 'InGame'),
                'errorsAddEmail' => $this->flashmessenger()->getMessagesFromNamespace(self::ERROR_NAME_SPACE . 'AddEmail'),
            ];

        }

        $method = $this->params()->fromPost('which') == 'ingame' ? 'changeInGamePwd' : 'changeWebPwd';
        if ($this->getUserService()->$method($this->params()->fromPost(), $user)) {
            $successKey = self::SUCCESS_NAME_SPACE;
            if ($this->params()->fromPost('which') == 'ingame') {
                $successKey .= 'InGame';
            } else {
                $successKey .= 'Web';
            }
            $this->flashMessenger()->setNamespace($successKey)->addMessage('Success, password changed.');
        }

        return $this->redirect()->toUrl($this->url()->fromRoute('PServerCMS/user'));
    }

    public function addEmailAction()
    {
        return $this->redirect()->toRoute('PServerCMS/user', ['action' => 'index']);
    }

}