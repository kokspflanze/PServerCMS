<?php


namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class ServerInfoWidget extends InvokerBase
{
    /**
     * @return string
     */
    public function __invoke()
    {
        $viewModel = new ViewModel([
            'serverInfo' => $this->getServerInfoService()->getServerInfo()
        ]);
        $viewModel->setTemplate('helper/sidebarServerInfoWidget');

        return $this->getView()->render($viewModel);
    }
}