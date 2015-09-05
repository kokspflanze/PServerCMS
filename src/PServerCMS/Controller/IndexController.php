<?php

namespace PServerCMS\Controller;

use PServerCMS\Helper\HelperService;
use PServerCMS\Helper\HelperServiceLocator;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    use HelperServiceLocator, HelperService;

	public function indexAction()
    {
		return [
			'aNews' => $this->getNewsService()->getActiveNews()
		];
	}

}
