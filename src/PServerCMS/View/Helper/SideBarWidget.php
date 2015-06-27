<?php

namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class SideBarWidget extends InvokerBase
{
    /**
	 * @return string
	 */
	public function __invoke()
    {
		$viewModel = new ViewModel();
		$viewModel->setTemplate('helper/sidebarWidget');

		return $this->getView()->render($viewModel);
	}
}