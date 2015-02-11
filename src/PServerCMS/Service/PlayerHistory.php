<?php

namespace PServerCMS\Service;

use PServerCMS\Keys\Caching;

class PlayerHistory extends InvokableBase {

	/**
	 * @return int
	 */
	public function getCurrentPlayer(){
		$currentPlayer = $this->getCachingHelperService()->getItem(Caching::PLAYER_HISTORY, function() {
			/** @var \PServerCMS\Entity\Repository\PlayerHistory $repository */
			$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getPlayerHistory());
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

		$class = $this->getEntityOptions()->getPlayerHistory();
		/** @var \PServerCMS\Entity\PlayerHistory $playerHistory */
		$playerHistory = new $class();
		$playerHistory->setPlayer($player);

		$entityManager = $this->getEntityManager();
		$entityManager->persist($playerHistory);
		$entityManager->flush();
	}
} 