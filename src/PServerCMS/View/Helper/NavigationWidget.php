<?php


namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class NavigationWidget extends InvokerBase
{

    /**
     * @return string
     */
    public function __invoke()
    {
        $viewModel = new ViewModel([
            'navigation' => $this->getConfigService()['pserver']['navigation']
        ]);
        $viewModel->setTemplate('p-server-cms/navigation');

        return $this->getView()->render($viewModel);
    }
}