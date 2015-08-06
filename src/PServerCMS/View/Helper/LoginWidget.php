<?php


namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class LoginWidget extends InvokerBase
{
    /**
     * @return string
     */
    public function __invoke()
    {
        $template = '';

        if (!$this->getAuthService()->hasIdentity()) {
            $viewModel = new ViewModel([
                'loginForm' => $this->getUserService()->getLoginForm(),
            ]);
            $viewModel->setTemplate('helper/sidebarLoginWidget');
            $template = $this->getView()->render($viewModel);
        }

        return $template;
    }

}