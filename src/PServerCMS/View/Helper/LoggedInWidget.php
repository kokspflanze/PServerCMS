<?php


namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class LoggedInWidget extends InvokerBase
{
    /**
     * @return string
     */
    public function __invoke()
    {
        $template = '';

        if ($this->getAuthService()->hasIdentity()) {
            $viewModel = new ViewModel([
                'user' => $this->getAuthService()->getIdentity()
            ]);
            $viewModel->setTemplate('helper/sidebarLoggedInWidget');
            $template = $this->getView()->render($viewModel);
        }

        return $template;
    }
}