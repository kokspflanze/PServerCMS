<?php

namespace PServerCMS\Form;

use PServerCMS\Helper\HelperBasic;
use PServerCMS\Helper\HelperOptions;
use PServerCMS\Helper\HelperService;
use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use PServerCMS\Validator\AbstractRecord;
use PServerCMS\Validator;
use Zend\ServiceManager\ServiceManager;

class RegisterFilter extends ProvidesEventsInputFilter
{
	use HelperOptions, HelperBasic, HelperService;

	/** @var ServiceManager */
	protected $serviceManager;

    /**
     * @param ServiceManager $serviceManager
     */
	public function __construct( ServiceManager $serviceManager )
    {
		$this->setServiceManager($serviceManager);

		$validationUsernameOptions = $this->getValidationOptions()->getUsername();

		$this->add(array(
			'name'       => 'username',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => $validationUsernameOptions['length']['min'],
                        'max' => $validationUsernameOptions['length']['max'],
                    ),
                ),
                array(
                    'name'    => 'Alnum',
                ),
				$this->getUsernameValidator(),
                $this->getUserNameBackendNotExistsValidator()
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

		if (!$this->getRegisterOptions()->isDuplicateEmail()) {
			$element = $this->get('email');
			/** @var \Zend\Validator\ValidatorChain $chain */
			$chain = $element->getValidatorChain();
			$chain->attach($this->getEmailValidator());
			$element->setValidatorChain($chain);
		}

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

        $passwordLengthOptions = $this->getPasswordOptions()->getLength();

		$this->add(array(
			'name'       => 'password',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
                        'min' => $passwordLengthOptions['min'],
                        'max' => $passwordLengthOptions['max'],
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
                        'min' => $passwordLengthOptions['min'],
                        'max' => $passwordLengthOptions['max'],
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
	 * @param ServiceManager $serviceManager
	 *
	 * @return $this
	 */
	public function setServiceManager( ServiceManager $serviceManager )
    {
		$this->serviceManager = $serviceManager;

		return $this;
	}

	/**
	 * @return ServiceManager
	 */
	public function getServiceManager()
    {
		return $this->serviceManager;
	}

	/**
	 * @return array
	 */
	protected function getSecretQuestionList()
    {
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
	public function getUsernameValidator()
	{
		/** @var $repositoryUser \Doctrine\Common\Persistence\ObjectRepository */
		$repositoryUser = $this->getServiceManager()
			->get('Doctrine\ORM\EntityManager')
			->getRepository($this->getEntityOptions()->getUser());

		return new Validator\NoRecordExists( $repositoryUser, 'username' );
	}

	/**
	 * @return AbstractRecord
	 */
	public function getEmailValidator()
	{
		/** @var $repositoryUser \Doctrine\Common\Persistence\ObjectRepository */
		$repositoryUser = $this->getServiceManager()
			->get('Doctrine\ORM\EntityManager')
			->getRepository($this->getEntityOptions()->getUser());

		return new Validator\NoRecordExists( $repositoryUser, 'email' );
	}

	/**
	 * @return Validator\StriposExists
	 */
	public function getStriposValidator()
    {
        return new Validator\StriposExists($this->getServiceManager(), Validator\StriposExists::TYPE_EMAIL);
	}

    /**
     * @return Validator\UserNameBackendNotExists
     */
    public function getUserNameBackendNotExistsValidator()
    {
        return new Validator\UserNameBackendNotExists($this->getServiceManager());
    }


} 