<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorDownload;
use PServerCMS\Entity\DownloadList;
use PServerCMS\Keys\Caching;

class Download extends InvokableBase
{
	/**
	 * @return \PServerCMS\Entity\DownloadList[]
	 */
	public function getActiveList()
    {
		$downloadInfo = $this->getCachingHelperService()->getItem(Caching::DOWNLOAD, function() {
			return $this->getDownloadRepository()->getActiveDownloadList();
		});

		return $downloadInfo;
	}

	/**
	 * @return null|\PServerCMS\Entity\DownloadList[]
	 */
	public function getDownloadList()
    {
		return $this->getDownloadRepository()->getDownloadList();
	}

    /**
     * @param $id
     * @return null|DownloadList
     */
	public function getDownload4Id( $id )
    {
		return $this->getDownloadRepository()->getDownload4Id($id);
	}

	/**
	 * @param array $data
	 * @param null|DownloadList $currentDownload
	 *
	 * @return bool|DownloadList
	 */
	public function download( array $data, $currentDownload = null)
    {
		if ($currentDownload == null) {
			$class = $this->getEntityOptions()->getDownloadList();
			/** @var DownloadList $currentDownload */
			$currentDownload = new $class;
		}

		$form = $this->getAdminDownloadForm();
		$form->setData($data);
		$form->setHydrator(new HydratorDownload());
		$form->bind($currentDownload);
		if (!$form->isValid()) {
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
	 * @param DownloadList $downloadEntry
	 * @return mixed
	 */
	public function deleteDownloadEntry(DownloadList $downloadEntry)
	{
		return $this->getDownloadRepository()->deleteDownloadEntry($downloadEntry->getId());
	}

	/**
	 * @return \PServerCMS\Entity\Repository\DownloadList
	 */
	protected function getDownloadRepository()
	{
		return $this->getEntityManager()->getRepository($this->getEntityOptions()->getDownloadList());;
	}

} 