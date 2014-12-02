<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 30.11.2014
 * Time: 21:40
 */

namespace PServerCMS\Service;


use PServerCMS\Keys\Entity;
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
		$class = Entity::SecretAnswer;
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
		$repository = $this->getEntityManager()->getRepository(Entity::SecretQuestion);
		return $repository->findOneBy(array('id' => $questionId));
	}

	/**
	 * @return null|\PServerCMS\Entity\Repository\SecretAnswer
	 */
	protected function getEntityManagerAnswer(){
		return $this->getEntityManager()->getRepository(Entity::SecretAnswer);
	}

} 