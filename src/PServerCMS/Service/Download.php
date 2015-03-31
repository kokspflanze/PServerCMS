<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorDownload;
use PServerCMS\Entity\DownloadList;
use PServerCMS\Keys\Caching;

class Download extends InvokableBase {
	/** @var \PServerAdmin\Form\Download */
	protected $downloadForm;

	/**
	 * @return \PServerCMS\Entity\DownloadList[]
	 */
	public function getActiveList(){

		$downloadInfo = $this->getCachingHelperService()->getItem(Caching::DOWNLOAD, function() {
			/** @var \PServerCMS\Entity\Repository\DownloadList $repository */
			$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getDownloadList());
			return $repository->getActiveDownloadList();
		});

		return $downloadInfo;
	}

	/**
	 * @return null|\PServerCMS\Entity\DownloadList[]
	 */
	public function getDownloadList(){
		/** @var \PServerCMS\Entity\Repository\DownloadList $repository */
		$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getDownloadList());
		return $repository->getDownloadList();
	}

	public function getDownload4Id( $id ){
		/** @var \PServerCMS\Entity\Repository\DownloadList $repository */
		$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getDownloadList());
		return $repository->getDownload4Id($id);
	}

	/**
	 * @param array $data
	 * @param null  $currentDownload
	 *
	 * @return bool|DownloadList
	 */
	public function download( array $data, $currentDownload = null){
		if($currentDownload == null){
			$currentDownload = new DownloadList();
		}

		$form = $this->getDownloadForm();
		$form->setData($data);
		$form->setHydrator(new HydratorDownload());
		$form->bind($currentDownload);
		if(!$form->isValid()){
			return false;
		}

		/** @var DownloadList $download */
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