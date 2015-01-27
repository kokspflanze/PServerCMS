<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 14.07.14
 * Time: 23:21
 */

namespace PServerCMS\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use PServerCMS\Validator\AbstractRecord;
use PServerCMS\Keys\Entity;
use PServerCMS\Validator;
use Zend\ServiceManager\ServiceManager;

class RegisterFilter extends ProvidesEventsInputFilter {
	protected $serviceManager;
	protected $entityManager;

	/**
	 * @var AbstractRecord
	 */
	protected $usernameValidator;


	public function __construct( ServiceManager $serviceManager ){

		$this->setServiceManager($serviceManager);

		/** @var $oRepositoryUser \Doctrine\Common\Persistence\ObjectRepository */
		$oRepositoryUser = $serviceManager->get('Doctrine\ORM\EntityManager')->getRepository(Entity::Users);
		$this->setUsernameValidator( new Validator\NoRecordExists( $oRepositoryUser, 'username' ) );

		$striposValidator = new Validator\StriposExists($serviceManager, Validator\StriposExists::TypeEmail);

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
				$striposValidator
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
		$this->add(array(
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
		));
		$this->add(array(
			'name'       => 'answer',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'min' => 3,
						'max' => 255,
					),
				),
			),
		));
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
	 * @return \Doctrine\ORM\EntityManager
	 */
	protected function getEntityManager() {
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
		}

		return $this->entityManager;
	}
} 