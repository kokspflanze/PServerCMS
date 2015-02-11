<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorServerInfo;
use PServerCMS\Keys\Caching;

class ServerInfo extends InvokableBase {
	/** @var \PServerAdmin\Form\ServerInfo */
	protected $serverInfoForm;

	/**
	 * @return null|\PServerCMS\Entity\ServerInfo[]
	 */
	public function getServerInfo(){
		$serverInfo = $this->getCachingHelperService()->getItem(Caching::SERVER_INFO, function() {
			/** @var \PServerCMS\Entity\Repository\ServerInfo $repository */
			$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getServerInfo());
			return $repository->getActiveInfos();
		});

		return $serverInfo;
	}

	/**
	 * @return null|\PServerCMS\Entity\ServerInfo[]
	 */
	public function getAllServerInfo(){
		/** @var \PServerCMS\Entity\Repository\ServerInfo $repository */
		$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getServerInfo());
		return $repository->getInfos();
	}

	/**
	 * @param $id
	 *
	 * @return null|\PServerCMS\Entity\ServerInfo
	 */
	public function getServerInfo4Id( $id ){
		/** @var \PServerCMS\Entity\Repository\ServerInfo $repository */
		$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getServerInfo());
		return $repository->getServerInfo4Id($id);
	}

	/**
	 * @param array $data
	 * @param null  $currentServerInfo
	 *
	 * @return bool|\PServerCMS\Entity\ServerInfo
	 */
	public function serverInfo( array $data, $currentServerInfo = null ){
		if($currentServerInfo == null){
			$class = $this->getEntityOptions()->getServerInfo();
			$currentServerInfo = new $class;
		}

		$form = $this->getServerInfoForm();
		$form->setHydrator(new HydratorServerInfo());
		$form->bind($currentServerInfo);
		$form->setData($data);
		if(!$form->isValid()){
			return false;
		}

		/** @var \PServerCMS\Entity\ServerInfo $serverInfo */
		$serverInfo = $form->getData();

		$entity = $this->getEntityManager();
		$entity->persist($serverInfo);
		$entity->flush();

		return $serverInfo;
	}

	/**
	 * @return \PServerAdmin\Form\ServerInfo
	 */
	public function getServerInfoForm(){
		if(!$this->serverInfoForm){
			$this->serverInfoForm = $this->getServiceManager()->get('pserver_admin_server_info_form');
		}
		return $this->serverInfoForm;
	}
} 