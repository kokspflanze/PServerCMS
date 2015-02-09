<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\Users;
use PServerCMS\Helper\Format;
use PServerCMS\Keys\Entity;

class UserCodes extends InvokableBase {

	/**
	 * @var \Doctrine\Common\Persistence\ObjectRepository
	 */
	protected $repositoryManager;

	public function setCode4User( Users $oUserEntity, $sType, $iExpire = 0 ){
		$oEntityManager = $this->getEntityManager();

		$this->getRepositoryManager()->deleteCodes4User($oUserEntity->getUsrid(), $sType);

		do{
			$bFound = false;
			$sCode = Format::getCode();
			if($this->getRepositoryManager()->findOneBy(array('code' => $sCode))){
				$bFound = true;
			}
		}while($bFound);

		$oUserCodesEntity = new \PServerCMS\Entity\Usercodes();
		$oUserCodesEntity
			->setCode($sCode)
			->setUser($oUserEntity)
			->setType($sType);

		if($iExpire){
			$oDateTime = new \DateTime();
			$oUserCodesEntity->setExpire($oDateTime->setTimestamp(time()+$iExpire));
		}

		$oEntityManager->persist($oUserCodesEntity);
		$oEntityManager->flush();

		return $sCode;
	}

	/**
	 * delete a userCode from database
	 *
	 * @param \PServerCMS\Entity\Usercodes $userCode
	 */
	public function deleteCode( \PServerCMS\Entity\Usercodes $userCode ){
		$entityManager = $this->getEntityManager();
		$entityManager->remove($userCode);
		$entityManager->flush();
	}

	/**
	 * @return \Doctrine\Common\Persistence\ObjectRepository|\PServerCMS\Entity\Repository\Usercodes
	 */
	protected function getRepositoryManager(){
		if( !$this->repositoryManager ){
			$this->repositoryManager = $this->getEntityManager()->getRepository(Entity::UserCodes);
		}
		return $this->repositoryManager;
	}

}