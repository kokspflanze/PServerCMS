<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 22.08.14
 * Time: 21:43
 */

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorServerInfo;
use PServerCMS\Keys\Entity;
use PServerCMS\Keys\Caching;

class ServerInfo extends InvokableBase {
	/** @var \PServerAdmin\Form\ServerInfo */
	protected $serverInfoForm;

	/**
	 * @return null|\PServerCMS\Entity\ServerInfo[]
	 */
	public function getServerInfo(){
		$serverInfo = $this->getCachingHelperService()->getItem(Caching::ServerInfo, function() {
			/** @var \PServerCMS\Entity\Repository\ServerInfo $repository */
			$repository = $this->getEntityManager()->getRepository(Entity::ServerInfo);
			return $repository->getActiveInfos();
		});

		return $serverInfo;
	}

	/**
	 * @return null|\PServerCMS\Entity\ServerInfo[]
	 */
	public function getAllServerInfo(){
		/** @var \PServerCMS\Entity\Repository\ServerInfo $repository */
		$repository = $this->getEntityManager()->getRepository(Entity::ServerInfo);
		return $repository->getInfos();
	}

	/**
	 * @param $id
	 *
	 * @return null|\PServerCMS\Entity\ServerInfo
	 */
	public function getServerInfo4Id( $id ){
		/** @var \PServerCMS\Entity\Repository\ServerInfo $repository */
		$repository = $this->getEntityManager()->getRepository(Entity::ServerInfo);
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
			$currentServerInfo = new \PServerCMS\Entity\ServerInfo();
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