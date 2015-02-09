<?php

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ServerInfo extends EntityRepository {

	/**
	 * @return null|\PServerCMS\Entity\ServerInfo[]
	 */
	public function getActiveInfos() {
		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->where('p.active = :active')
			->setParameter('active', '1')
			->orderBy('p.sortkey','asc')
			->getQuery();
		return $oQuery->getResult();
	}

	/**
	 * @return null|\PServerCMS\Entity\ServerInfo[]
	 */
	public function getInfos() {
		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->getQuery();
		return $oQuery->getResult();
	}

	/**
	 * @param $id
	 *
	 * @return null|\PServerCMS\Entity\ServerInfo
	 */
	public function getServerInfo4Id( $id ){
		$query = $this->createQueryBuilder('p')
			->select('p')
			->where('p.id = :id')
			->setParameter('id', $id)
			->setMaxResults(1)
			->getQuery();

		return $query->getOneOrNullResult();
	}
} 