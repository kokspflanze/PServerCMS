<?php

namespace PServerCMS\Controller;

use PServerCMS\Keys\Entity;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController {
	/** @var \PServerCMS\Service\News */
	protected $newsService;

	public function indexAction() {
		return array(
			'aNews' => $this->getNewsService()->getActiveNews()
		);
	}

	/**
	 * @return \PServerCMS\Service\News
	 */
	protected function getNewsService(){
		if (!$this->newsService) {
			$this->newsService = $this->getServiceLocator()->get('pserver_news_service');
		}

		return $this->newsService;
	}
}
