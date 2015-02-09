<?php

namespace PServerCMS\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class PlayerHistory extends EntityRepository {

	/**
	 * @return integer
	 */
	public function getCurrentPlayer( ){
		$query = $this->createQueryBuilder('p')
			->select('p')
			->orderBy('p.created','desc')
			->setMaxResults(1)
			->getQuery();

		/** @var \PServerCMS\Entity\PlayerHistory $result */
		$result = $query->getOneOrNullResult();

		return is_null($result)?0:$result->getPlayer();
	}
} 