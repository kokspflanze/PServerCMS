<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorDownload;
use PServerCMS\Entity\Downloadlist;
use PServerCMS\Keys\Caching;
use PServerCMS\Keys\Entity;

class Download extends InvokableBase {
	/** @var \PServerAdmin\Form\Download */
	protected $downloadForm;

	/**
	 * @return \PServerCMS\Entity\DownloadList[]
	 */
	public function getActiveList(){

		$downloadInfo = $this->getCachingHelperService()->getItem(Caching::Download, function() {
			/** @var \PServerCMS\Entity\Repository\DownloadList $repository */
			$repository = $this->getEntityManager()->getRepository(Entity::DownloadList);
			return $repository->getActiveDownloadList();
		});

		return $downloadInfo;
	}

	/**
	 * @return null|\PServerCMS\Entity\Downloadlist[]
	 */
	public function getDownloadList(){
		/** @var \PServerCMS\Entity\Repository\DownloadList $repository */
		$repository = $this->getEntityManager()->getRepository(Entity::DownloadList);
		return $repository->getDownloadList();
	}

	public function getDownload4Id( $id ){
		/** @var \PServerCMS\Entity\Repository\DownloadList $repository */
		$repository = $this->getEntityManager()->getRepository(Entity::DownloadList);
		return $repository->getDownload4Id($id);
	}

	/**
	 * @param array $data
	 * @param null  $currentDownload
	 *
	 * @return bool|Downloadlist
	 */
	public function download( array $data, $currentDownload = null){
		if($currentDownload == null){
			$currentDownload = new Downloadlist();
		}

		$form = $this->getDownloadForm();
		$form->setData($data);
		$form->setHydrator(new HydratorDownload());
		$form->bind($currentDownload);
		if(!$form->isValid()){
			return false;
		}

		/** @var Downloadlist $download */
		$download = $form->getData();

		$entity = $this->getEntityManager();
		$entity->persist($download);
		$entity->flush();

		return $download;
	}

	/**
	 * @return \PServerAdmin\Form\Download
	 */
	public function getDownloadForm(){
		if(!$this->downloadForm){
			$this->downloadForm = $this->getServiceManager()->get('pserver_admin_download_form');
		}
		return $this->downloadForm;
	}
} 