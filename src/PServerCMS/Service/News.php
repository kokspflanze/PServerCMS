<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorNews;
use PServerCMS\Entity\User;
use PServerCMS\Entity\UserInterface;
use PServerCMS\Keys\Caching;

class News extends InvokableBase
{
	/**
	 * @return \PServerCMS\Entity\News[]
	 */
	public function getActiveNews()
    {
		$limit = $this->getConfigService()->get('pserver.news.limit', 5);
		$newsInfo = $this->getCachingHelperService()->getItem(Caching::NEWS, function() use ($limit) {
			/** @var \PServerCMS\Entity\Repository\News $repository */
			$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getNews());
			return $repository->getActiveNews($limit);
		});

		return $newsInfo;
	}

	/**
	 * @return null|\PServerCMS\Entity\News[]
	 */
	public function getNews()
    {
		/** @var \PServerCMS\Entity\Repository\News $repository */
		$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getNews());
		return $repository->getNews();
	}

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNewsQueryBuilder()
    {
        /** @var \PServerCMS\Entity\Repository\News $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getNews());
        return $repository->getQueryBuilder();
    }

	/**
	 * @param $newsId
	 *
	 * @return null|\PServerCMS\Entity\News
	 */
	public function getNews4Id( $newsId )
    {
		/** @var \PServerCMS\Entity\Repository\News $repository */
		$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getNews());
		return $repository->getNews4Id($newsId);
	}

	/**
	 * @param array $data
	 * @param UserInterface $user
	 *
	 * @return bool|\PServerCMS\Entity\News
	 */
	public function news( array $data, UserInterface $user, $currentNews = null )
    {
		if (!$currentNews) {
			$currentNews = new \PServerCMS\Entity\News();
		}

		$form = $this->getNewsForm();
		$form->setHydrator(new HydratorNews());
		$form->bind($currentNews);
		$form->setData($data);
		if (!$form->isValid()) {
			return false;
		}

		/** @var \PServerCMS\Entity\News $news */
		$news = $form->getData();
		$news->setUser($this->getUser4Id($user->getId()));
		
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
	public function getNewsForm()
    {
		return $this->getService('pserver_admin_news_form');
	}
} 