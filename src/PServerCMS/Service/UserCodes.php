<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\Users;
use PServerCMS\Helper\Format;

class UserCodes extends InvokableBase {

	/**
	 * @var \Doctrine\Common\Persistence\ObjectRepository
	 */
	protected $repositoryManager;

    /**
     * @param Users $userEntity
     * @param       $type
     * @param int   $expire
     *
     * @return string
     */
	public function setCode4User( Users $userEntity, $type, $expire = 0 ){
		$entityManager = $this->getEntityManager();

		$this->getRepositoryManager()->deleteCodes4User($userEntity->getUsrid(), $type);

		do{
			$found = false;
			$code = Format::getCode();
			if($this->getRepositoryManager()->getCode($code)){
				$found = true;
			}
		}while($found);

		$userCodesEntity = new \PServerCMS\Entity\Usercodes();
		$userCodesEntity
			->setCode($code)
			->setUser($userEntity)
			->setType($type);

		if($expire){
			$dateTime = new \DateTime();
			$userCodesEntity->setExpire($dateTime->setTimestamp(time()+$expire));
		}

		$entityManager->persist($userCodesEntity);
		$entityManager->flush();

		return $code;
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
     * @param int $limit
     *
     * @return int
     */
    public function cleanExpireCodes( $limit = 100 )
    {
        $codeList = $this->getRepositoryManager()->getExpiredCodes($limit);
        $result = 0;
        if($codeList){
            $result = $this->cleanExpireCodes4List($codeList);
        }

        return $result;
    }

    /**
     * @param \PServerCMS\Entity\Usercodes[] $codeList
     *
     * @return int
     */
    protected function cleanExpireCodes4List( array $codeList )
    {
        $i = 0;
        $entityManager = $this->getEntityManager();
        foreach ($codeList as $code) {
            // if we have a register-code, so we have to remove the user too
            if ($code->getType() == $code::TYPE_REGISTER) {
                $user = $code->getUser();
                /** @var \PServerCMS\Entity\Repository\Logs $logRepository */
                $logRepository = $entityManager->getRepository( $this->getEntityOptions()->getLogs() );
                $logRepository->setLogsNull4User( $user );
                if ($this->getServiceManager()->get( 'pserver_configread_service' )->get( 'pserver.password.secret_question' )) {
                    /** @var \PServerCMS\Entity\Repository\SecretAnswer $answerRepository */
                    $answerRepository = $entityManager->getRepository( $this->getEntityOptions()->getSecretAnswer() );
                    $answerRepository->deleteAnswer4User($user);
                }

                $entityManager->remove( $user );
            }
            $entityManager->remove($code);
            $entityManager->flush();
            ++$i;
        }

        return $i;
    }

	/**
	 * @return \Doctrine\Common\Persistence\ObjectRepository|\PServerCMS\Entity\Repository\Usercodes
	 */
	protected function getRepositoryManager(){
		if( !$this->repositoryManager ){
			$this->repositoryManager = $this->getEntityManager()->getRepository( $this->getEntityOptions()->getUserCodes() );
		}
		return $this->repositoryManager;
	}

}