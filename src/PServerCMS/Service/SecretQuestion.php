<?php

namespace PServerCMS\Service;

use PServerCMS\Entity\Users;

class SecretQuestion extends InvokableBase {

	/**
	 * @param Users $user
	 * @param       $questionId
	 * @param       $answer
	 *
	 * @return \PServerCMS\Entity\SecretAnswer
	 */
	public function setSecretAnswer( Users $user, $questionId, $answer ){
		$class = $this->getEntityOptions()->getSecretAnswer();
		/** @var \PServerCMS\Entity\SecretAnswer $secretAnswer */
		$secretAnswer = new $class;
		$secretAnswer->setUser($user)
			->setAnswer(trim($answer))
			->setQuestion($this->getQuestion4Id($questionId));

		$entity = $this->getEntityManager();
		$entity->persist($secretAnswer);
		$entity->flush();

		return $secretAnswer;
	}

	/**
	 * @param Users $user
	 * @param       $answer
	 *
	 * @return bool
	 */
	public function isAnswerAllowed( Users $user, $answer ){

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
	protected function getQuestion4Id( $questionId ){
		$repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getSecretQuestion());
		return $repository->findOneBy(array('id' => $questionId));
	}

	/**
	 * @return null|\PServerCMS\Entity\Repository\SecretAnswer
	 */
	protected function getEntityManagerAnswer(){
		return $this->getEntityManager()->getRepository($this->getEntityOptions()->getSecretAnswer());
	}

} 