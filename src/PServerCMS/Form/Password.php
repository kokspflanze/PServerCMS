<?php

namespace PServerCMS\Form;

use PServerCMS\Entity\User;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;
use Zend\ServiceManager\ServiceLocatorInterface;

class Password extends ProvidesEventsForm
{

	/** @var  ServiceLocatorInterface */
	protected $serviceManager;
	/** @var  User */
	protected $user;
	/** @var  \Doctrine\ORM\EntityManager */
	protected $entityManager;


	public function __construct( ServiceLocatorInterface $serviceLocatorInterface )
    {
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

	/**
	 * @param User $user
	 */
	public function addSecretQuestion(User $user)
    {
		if (!$this->getServiceManager()->get('pserver_configread_service')->get('pserver.password.secret_question')) {
			return;
		}

		$this->setUser($user);
		/** @var \PServerCMS\Entity\Repository\SecretAnswer $repositorySecretAnswer */
		$repositorySecretAnswer = $this->getEntityManager()->getRepository($this->getEntityOptions()->getSecretAnswer());
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
	 * @param User $user
	 */
	public function setUser( User $user )
    {
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser()
    {
		return $this->user;
	}

	/**
	 * @param ServiceLocatorInterface $oServiceManager
	 *
	 * @return $this
	 */
	protected function setServiceManager( ServiceLocatorInterface $oServiceManager )
    {
		$this->serviceManager = $oServiceManager;

		return $this;
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
    {
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
		}

		return $this->entityManager;
	}

	/**
	 * @return ServiceLocatorInterface
	 */
	protected function getServiceManager()
    {
		return $this->serviceManager;
	}

	/**
	 * @return \PServerCMS\Options\EntityOptions
	 */
	protected function getEntityOptions()
    {
		return $this->getServiceManager()->get('pserver_entity_options');
	}
} 