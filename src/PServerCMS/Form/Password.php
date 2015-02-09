<?php

namespace PServerCMS\Form;

use PServerCMS\Entity\Users;
use PServerCMS\Keys\Entity;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;
use Zend\ServiceManager\ServiceLocatorInterface;

class Password extends ProvidesEventsForm {

	protected $serviceManager;
	protected $user;
	protected $entityManager;


	public function __construct( ServiceLocatorInterface $serviceLocatorInterface ) {
		parent::__construct();
		$this->setServiceManager($serviceLocatorInterface);

		$this->add(array(
			'type' => 'Zend\Form\Element\Csrf',
			'name' => 'eugzhoe45gh3o49ug2wrtu7gz50'
		));

		$this->add(array(
			'name' => 'password',
			'options' => array(
				'label' => 'Password',
			),
			'attributes' => array(
                'class' => 'form-control',
				'type' => 'password'
			),
		));

		$this->add(array(
			'name' => 'passwordVerify',
			'options' => array(
				'label' => 'Password Verify',
			),
			'attributes' => array(
                'class' => 'form-control',
				'type' => 'password'
			),
		));

		$submitElement = new Element\Button('submit');
		$submitElement
			->setLabel('Submit')
			->setAttributes(array(
                'class' => 'btn btn-default',
				'type'  => 'submit',
			));

		$this->add($submitElement, array(
			'priority' => -100,
		));
	}

	public function addSecretQuestion(Users $user){
		$this->setUser($user);
		/** @var \PServerCMS\Entity\Repository\SecretAnswer $repositorySecretAnswer */
		$repositorySecretAnswer = $this->getEntityManager()->getRepository(Entity::SecretAnswer);
		$answer = $repositorySecretAnswer->getAnswer4UserId($this->getUser()->getId());

		$this->add(array(
			'name' => 'question',
			'options' => array(
				'label' => 'SecretQuestion',
			),
			'attributes' => array(
				'placeholder' => 'Question',
				'class' => 'form-control',
				'type' => 'text',
				'disabled' => 'true',
				'value' => $answer->getQuestion()->getQuestion()
			),
		));

		$this->add(array(
			'name' => 'answer',
			'options' => array(
				'label' => 'SecretAnswer',
			),
			'attributes' => array(
				'placeholder' => 'Answer',
				'class' => 'form-control',
				'type' => 'text'
			),
		));

	}

	/**
	 * @param Users $user
	 */
	public function setUser( Users $user ){
		$this->user = $user;
	}

	/**
	 * @return Users
	 */
	public function getUser(){
		return $this->user;
	}

	/**
	 * @param ServiceLocatorInterface $oServiceManager
	 *
	 * @return $this
	 */
	protected function setServiceManager( ServiceLocatorInterface $oServiceManager ) {
		$this->serviceManager = $oServiceManager;

		return $this;
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager() {
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
		}

		return $this->entityManager;
	}

	/**
	 * @return ServiceLocatorInterface
	 */
	protected function getServiceManager() {
		return $this->serviceManager;
	}
} 