<?php

namespace PServerCMS\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use PServerCMS\Validator\AbstractRecord;
use PServerCMS\Validator;
use Zend\ServiceManager\ServiceManager;

class RegisterFilter extends ProvidesEventsInputFilter {
	protected $serviceManager;
	protected $entityManager;

	/** @var AbstractRecord */
	protected $usernameValidator;
	/** @var Validator\StriposExists */
	protected $striposValidator;


	public function __construct( ServiceManager $serviceManager ){

		$this->setServiceManager($serviceManager);

		/** @var $oRepositoryUser \Doctrine\Common\Persistence\ObjectRepository */
		$oRepositoryUser = $serviceManager->get('Doctrine\ORM\EntityManager')->getRepository($this->getEntityOptions()->getUser());
		$this->setUsernameValidator( new Validator\NoRecordExists( $oRepositoryUser, 'username' ) );
		$this->setStriposValidator( new Validator\StriposExists($serviceManager, Validator\StriposExists::TYPE_EMAIL) );

		$this->add(array(
			'name'       => 'username',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'min' => 3,
						'max' => 16,
					),
				),
				$this->getUsernameValidator(),
			),
		));

		$this->add(array(
			'name'       => 'email',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name' => 'EmailAddress',
					'options' => array(
						'allow' 		=> \Zend\Validator\Hostname::ALLOW_DNS,
						'useMxCheck'    => true,
						'useDeepMxCheck'  => true
					)
				),
				$this->getStriposValidator()
			),
		));

		$this->add(array(
			'name'       => 'emailVerify',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'min' => 6,
						'max' => 255,
					),
				),
				array(
					'name'    => 'Identical',
					'options' => array(
						'token' => 'email',
					),
				),
			),
		));

		$this->add(array(
			'name'       => 'password',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'min' => 6,
						'max' => 16,
					),
				),
			),
		));

		$this->add(array(
			'name'       => 'passwordVerify',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'min' => 6,
						'max' => 16,
					),
				),
				array(
					'name'    => 'Identical',
					'options' => array(
						'token' => 'password',
					),
				),
			),
		));


		/** @var \PServerCMS\Service\ConfigRead $configService */
		$configService = $serviceManager->get( 'pserver_configread_service' );
		if($configService->get('pserver.password.secret_question')) {
			$this->add( array(
				'name'       => 'question',
				'required'   => true,
				'validators' => array(
					array(
						'name'    => 'InArray',
						'options' => array(
							'haystack' => $this->getSecretQuestionList(),
						),
					),
				),
			) );
			$this->add( array(
				'name'       => 'answer',
				'required'   => true,
				'filters'    => array( array( 'name' => 'StringTrim' ) ),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'min' => 3,
							'max' => 255,
						),
					),
				),
			) );
		}
	}

	/**
	 * @param ServiceManager $oServiceManager
	 *
	 * @return $this
	 */
	public function setServiceManager( ServiceManager $oServiceManager ) {
		$this->serviceManager = $oServiceManager;

		return $this;
	}

	/**
	 * @return ServiceManager
	 */
	protected function getServiceManager() {
		return $this->serviceManager;
	}

	/**
	 * @return array
	 */
	protected function getSecretQuestionList(){
		/** @var \PServerCMS\Entity\Repository\SecretQuestion $secret */
		$secret = $this->getEntityManager()->getRepository('PServerCMS\Entity\SecretQuestion');
		$secretQuestion = $secret->getQuestions();

		$result = array();
		foreach($secretQuestion as $entry){
			$result[] = $entry->getId();
		}
		return $result;
	}

	/**
	 * @return AbstractRecord
	 */
	public function getUsernameValidator()	{
		return $this->usernameValidator;
	}

	/**
	 * @param AbstractRecord $usernameValidator
	 *
	 * @return $this
	 */
	public function setUsernameValidator($usernameValidator) {
		$this->usernameValidator = $usernameValidator;
		return $this;
	}

	/**
	 * @return Validator\StriposExists
	 */
	public function getStriposValidator()	{
		return $this->striposValidator;
	}

	/**
	 * @param Validator\StriposExists $striposValidator
	 *
	 * @return $this
	 */
	public function setStriposValidator($striposValidator) {
		$this->striposValidator = $striposValidator;
		return $this;
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	protected function getEntityManager() {
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
		}

		return $this->entityManager;
	}

	/**
	 * @return \PServerCMS\Options\EntityOptions
	 */
	protected function getEntityOptions(){
		return $this->getServiceManager()->get('pserver_entity_options');
	}
} 