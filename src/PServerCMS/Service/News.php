<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorNews;
use PServerCMS\Entity\Users;
use PServerCMS\Keys\Caching;
use PServerCMS\Keys\Entity;

class News extends InvokableBase {
	/** @var \PServerAdmin\Form\News */
	protected $newsForm;

	/**
	 * @return \PServerCMS\Entity\News[]
	 */
	public function getActiveNews(){
		$limit = $this->getConfigService()->get('pserver.news.limit', 5);
		$newsInfo = $this->getCachingHelperService()->getItem(Caching::News, function() use ($limit) {
			/** @var \PServerCMS\Entity\Repository\News $repository */
			$repository = $this->getEntityManager()->getRepository(Entity::News);
			return $repository->getActiveNews($limit);
		});

		return $newsInfo;
	}

	/**
	 * @return null|\PServerCMS\Entity\News[]
	 */
	public function getNews(){
		/** @var \PServerCMS\Entity\Repository\News $repository */
		$repository = $this->getEntityManager()->getRepository(Entity::News);
		return $repository->getNews();
	}

	/**
	 * @param $newsId
	 *
	 * @return null|\PServerCMS\Entity\News
	 */
	public function getNews4Id( $newsId ){
		/** @var \PServerCMS\Entity\Repository\News $repository */
		$repository = $this->getEntityManager()->getRepository(Entity::News);
		return $repository->getNews4Id($newsId);
	}

	/**
	 * @param array $data
	 * @param Users $user
	 *
	 * @return bool|\PServerCMS\Entity\News
	 */
	public function news( array $data, Users $user, $currentNews = null ){
		if($currentNews == null){
			$currentNews = new \PServerCMS\Entity\News();
		}

		$form = $this->getNewsForm();
		$form->setHydrator(new HydratorNews());
		$form->bind($currentNews);
		$form->setData($data);
		if(!$form->isValid()){
			return false;
		}

		/** @var \PServerCMS\Entity\News $news */
		$news = $form->getData();
		$news->setUser($this->getUser4Id($user->getUsrid()));
		
		//\Zend\Debug\Debug::dump($user);die();

		$entity = $this->getEntityManager();
		$entity->persist($news);
		//$entity->persist($user);
		$entity->flush();

		return $news;
	}

	/**
	 * @return \PServerAdmin\Form\News
	 */
	public function getNewsForm(){
		if (! $this->newsForm) {
			$this->newsForm = $this->getServiceManager()->get('pserver_admin_news_form');
		}

		return $this->newsForm;
	}
} 