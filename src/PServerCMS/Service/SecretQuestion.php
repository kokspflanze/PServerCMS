<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorSecretQuestion;
use PServerCMS\Entity\UserInterface;
use PServerCMS\Entity\SecretQuestion as Entity;

class SecretQuestion extends InvokableBase
{

	/**
	 * @param UserInterface $user
	 * @param $questionId
	 * @param $answer
	 *
	 * @return \PServerCMS\Entity\SecretAnswer
	 */
	public function setSecretAnswer( UserInterface $user, $questionId, $answer )
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
	 * @param UserInterface $user
	 * @param       $answer
	 *
	 * @return bool
	 */
	public function isAnswerAllowed( UserInterface $user, $answer )
    {
		$answerEntity = $this->getEntityManagerAnswer()->getAnswer4UserId($user->getId());

		$realAnswer = strtolower(trim($answerEntity->getAnswer()));
		$plainAnswer = strtolower(trim($answer));

		return $realAnswer === $plainAnswer;
	}

	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	public function getQuestionQueryBuilder()
	{
		return $this->getQuestionRepository()->getQuestionQueryBuilder();
	}


	/**
	 * @param array $data
	 * @param null|Entity $currentSecretQuestion
	 *
	 * @return bool|Entity
	 */
	public function secretQuestion(array $data, $currentSecretQuestion = null)
	{
		if ($currentSecretQuestion == null) {
			$class = $this->getEntityOptions()->getSecretQuestion();
			/** @var Entity $currentSecretQuestion */
			$currentSecretQuestion = new $class;
		}

		$form = $this->getAdminSecretQuestionForm();
		$form->setData($data);
		$form->setHydrator(new HydratorSecretQuestion());
		$form->bind($currentSecretQuestion);
		if (!$form->isValid()) {
			return false;
		}

		/** @var Entity $secretQuestion */
		$secretQuestion = $form->getData();

		$entity = $this->getEntityManager();
		$entity->persist($secretQuestion);
		$entity->flush();

		return $secretQuestion;
	}

	/**
	 * @param $questionId
	 *
	 * @return null|\PServerCMS\Entity\SecretQuestion
	 */
	protected function getQuestion4Id( $questionId )
    {
		return $this->getQuestionRepository()->getQuestion4Id( $questionId );
	}

	/**
	 * @return null|\PServerCMS\Entity\Repository\SecretAnswer
	 */
	protected function getEntityManagerAnswer()
    {
		return $this->getEntityManager()->getRepository($this->getEntityOptions()->getSecretAnswer());
	}

	/**
	 * @return \PServerCMS\Entity\Repository\SecretQuestion $repository
	 */
	protected function getQuestionRepository()
	{
		return $this->getEntityManager()->getRepository($this->getEntityOptions()->getSecretQuestion());
	}

} 