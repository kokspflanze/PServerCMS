<?php

namespace PServerCMS\Service;

use PServerCMS\Entity\User;

class SecretQuestion extends InvokableBase
{

	/**
	 * @param User $user
	 * @param       $questionId
	 * @param       $answer
	 *
	 * @return \PServerCMS\Entity\SecretAnswer
	 */
	public function setSecretAnswer( User $user, $questionId, $answer )
    {
		$class = $this->getEntityOptions()->getSecretAnswer();
		/** @var \PServerCMS\Entity\SecretAnswer $secretAnswer */
		$secretAnswer = new $class;
		$secretAnswer->setUser($user)
			->setAnswer(trim($answer))
			->setQuestion( $this->getQuestion4Id($questionId) );

		$entity = $this->getEntityManager();
		$entity->persist($secretAnswer);
		$entity->flush();

		return $secretAnswer;
	}

	/**
	 * @param User $user
	 * @param       $answer
	 *
	 * @return bool
	 */
	public function isAnswerAllowed( User $user, $answer )
    {
		$answerEntity = $this->getEntityManagerAnswer()->getAnswer4UserId($user->getId());

		$realAnswer = strtolower(trim($answerEntity->getAnswer()));
		$plainAnswer = strtolower(trim($answer));


		return $realAnswer == $plainAnswer;
	}

	/**
	 * @param $questionId
	 *
	 * @return null|\PServerCMS\Entity\Repository\SecretQuestion
	 */
	protected function getQuestion4Id( $questionId )
    {
        /** @var \PServerCMS\Entity\Repository\SecretQuestion $repository */
		$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getSecretQuestion());


		return $repository->getQuestion4Id( $questionId );
	}

	/**
	 * @return null|\PServerCMS\Entity\Repository\SecretAnswer
	 */
	protected function getEntityManagerAnswer(){
		return $this->getEntityManager()->getRepository($this->getEntityOptions()->getSecretAnswer());
	}

} 