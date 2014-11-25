<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 25.11.2014
 * Time: 22:33
 */

namespace PServerCMS\Service;

use PServerCMS\Keys\Entity;
use PServerCMS\Keys\Caching;

class PlayerHistory extends InvokableBase {

	/**
	 * @return int
	 */
	public function getCurrentPlayer(){
		$currentPlayer = $this->getCachingHelperService()->getItem(Caching::PlayerHistory, function() {
			/** @var \PServerCMS\Entity\Repository\PlayerHistory $repository */
			$repository = $this->getEntityManager()->getRepository(Entity::PlayerHistory);
			return $repository->getCurrentPlayer();
		});

		return $currentPlayer;
	}
} 