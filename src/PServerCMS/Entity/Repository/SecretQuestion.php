<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SecretQuestion extends EntityRepository {

	/**
	 * @return \PServerCMS\Entity\SecretQuestion[]|null
	 */
	public function getQuestions(){
		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->orderBy('p.sortKey','asc')
			->getQuery();
		return $oQuery->getResult();
	}
} 