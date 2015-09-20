<?php

namespace PServerCMS\Form;

use PServerCMS\Entity\UserInterface;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;
use Zend\ServiceManager\ServiceLocatorInterface;

class Password extends ProvidesEventsForm
{
	/** @var  ServiceLocatorInterface */
	protected $serviceManager;
	/** @var  UserInterface */
	protected $user;
	/** @var  \Doctrine\ORM\EntityManager */
	protected $entityManager;

	/**
	 * @param ServiceLocatorInterface $serviceLocatorInterface
	 */
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
	 * @param UserInterface $user
	 */
	public function addSecretQuestion(UserInterface $user)
    {
		if (!$this->getPasswordOptions()->isSecretQuestion()) {
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
	 * @param UserInterface $user
	 */
	public function setUser( UserInterface $user )
    {
		$this->user = $user;
	}

	/**
	 * @return UserInterface
	 */
	public function getUser()
    {
		return $this->user;
	}

	/**
	 * @param ServiceLocatorInterface $serviceManager
	 *
	 * @return $this
	 */
	protected function setServiceManager( ServiceLocatorInterface $serviceManager )
    {
		$this->serviceManager = $serviceManager;

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

	/**
	 * @return \PServerCMS\Options\PasswordOptions
	 */
	public function getPasswordOptions()
	{
		return $this->getServiceManager()->get('pserver_password_options');
	}
} 