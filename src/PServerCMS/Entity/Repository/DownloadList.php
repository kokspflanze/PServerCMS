<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 27.07.14
 * Time: 22:18
 */

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class DownloadList extends EntityRepository {

	/**
	 * @return null|\PServerCMS\Entity\Downloadlist[]
	 */
	public function getActiveDownloadList() {
		$query = $this->createQueryBuilder('p')
			->select('p')
			->where('p.active = :active')
			->setParameter('active', '1')
			->orderBy('p.sortkey','asc')
			->getQuery();
		return $query->getResult();
	}

	/**
	 * @return null|\PServerCMS\Entity\Downloadlist[]
	 */
	public function getDownloadList(){
		$query = $this->createQueryBuilder('p')
			->select('p')
			->getQuery();
		return $query->getResult();
	}

	/**
	 * @param $id
	 *
	 * @return null|\PServerCMS\Entity\Downloadlist
	 */
	public function getDownload4Id( $id ){
		$query = $this->createQueryBuilder('p')
			->select('p')
			->where('p.did = :did')
			->setParameter('did', $id)
			->setMaxResults(1)
			->getQuery();

		return $query->getOneOrNullResult();
	}
}