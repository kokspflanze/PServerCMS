<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\Userblock as UserBlockEntity;
use PServerCMS\Entity\UserInterface;

class UserBlock extends InvokableBase {

	/**
	 * We want to block a user
	 * @param UserInterface $user
	 * @param       $expire
	 * @param       $reason
	 *
	 * @TODO Block @ GameBackend
	 * @return bool
	 */
	public function blockUser( UserInterface $user, $expire, $reason ){
		$class = $this->getEntityOptions()->getUserBlock();
		/** @var UserBlockEntity $userBlock */
		$userBlock = new $class;
		$userBlock->setUser($user);
		$userBlock->setReason($reason);
		$userBlock->setExpire($expire);

		$entityManager = $this->getEntityManager();
		$entityManager->persist($userBlock);
		$entityManager->flush();

		return true;
	}

} 