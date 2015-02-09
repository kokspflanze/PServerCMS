<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorPageInfo;
use PServerCMS\Keys\Caching;
use PServerCMS\Keys\Entity;

class PageInfo extends InvokableBase {

	/** @var \PServerAdmin\Form\PageInfo */
	protected $pageInfoForm;

	/**
	 * @param $type
	 *
	 * @return \PServerCMS\Entity\PageInfo|null
	 */
	public function getPage4Type( $type ){
		$cachingKey = Caching::PAGE_INFO . '_' . $type;

		$pageInfo = $this->getCachingHelperService()->getItem($cachingKey, function() use ($type) {
			/** @var \PServerCMS\Entity\Repository\PageInfo $repository */
			$repository = $this->getEntityManager()->getRepository(Entity::PageInfo);
			return $repository->getPageData4Type($type);
		});

		return $pageInfo;
	}

	/**
	 * @param array $data
	 * @param null  $currentPageInfo
	 *
	 * @return bool|\PServerCMS\Entity\PageInfo
	 */
	public function pageInfo( array $data, $type ){
		$form = $this->getPageInfoForm();
		$form->setHydrator(new HydratorPageInfo());
		$form->bind( new \PServerCMS\Entity\PageInfo() );
		$form->setData($data);
		if(!$form->isValid()){
			return false;
		}

		/** @var \PServerCMS\Entity\PageInfo $pageInfo */
		$pageInfo = $form->getData();
		$pageInfo->setType($type);

		$entity = $this->getEntityManager();
		$entity->persist($pageInfo);
		$entity->flush();

		return $pageInfo;
	}

	/**
	 * @return array
	 */
	public function getPossiblePageInfoTypes(){
		return $this->getConfigService()->get('pserver.pageinfotype', array());
	}

	/**
	 * @return \PServerAdmin\Form\PageInfo
	 */
	public function getPageInfoForm(){
		if (! $this->pageInfoForm) {
			$this->pageInfoForm = $this->getServiceManager()->get('pserver_admin_page_info_form');
		}

		return $this->pageInfoForm;
	}

} 