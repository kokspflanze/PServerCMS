<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 11.10.2014
 * Time: 02:05
 */

namespace PServerCMS\Service;


use PServerCMS\Entity\Users;
use PServerCMS\Entity\Userblock as UserBlockEntity;

class UserBlock extends InvokableBase {

	/**
	 * We want to block a user
	 * @param Users $user
	 * @param       $expire
	 * @param       $reason
	 *
	 * @TODO Block @ GameBackend
	 * @return bool
	 */
	public function blockUser( Users $user, $expire, $reason ){
		$userBlock = new UserBlockEntity();
		$userBlock->setUser($user);
		$userBlock->setReason($reason);
		$userBlock->setExpire($expire);
		$entityManager = $this->getEntityManager();
		$entityManager->persist($userBlock);
		$entityManager->flush();

		return true;
	}

} 