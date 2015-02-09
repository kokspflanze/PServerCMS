<?php

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

	/**
	 * read from gamebackend the current player [or] as param and save them in database
	 *
	 * @param int $player
	 */
	public function setCurrentPlayer( $player = 0 ){
		if(!$player){
			$player = $this->getGameBackendService()->getCurrentPlayerNumber();
		}

		$playerHistory = new \PServerCMS\Entity\PlayerHistory();
		$playerHistory->setPlayer($player);

		$entityManager = $this->getEntityManager();
		$entityManager->persist($playerHistory);
		$entityManager->flush();
	}
} 