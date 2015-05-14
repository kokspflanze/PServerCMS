<?php

namespace PServerCMS\Form;

use PServerCMS\Entity\User;
use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\ServiceManager\ServiceLocatorInterface;
use PServerCMS\Validator\SimilarText;

class PasswordFilter extends ProvidesEventsInputFilter
{
    /** @var  \PServerCMS\Validator\SimilarText */
	protected $similarText;
    /** @var  User */
	protected $user;

    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     */
	public function __construct( ServiceLocatorInterface $serviceLocatorInterface )
    {
		/** @var \PServerCMS\Service\ConfigRead $configService */
		$configService = $serviceLocatorInterface->get( 'pserver_configread_service' );
		if($configService->get('pserver.password.secret_question')) {
			$secretQuestion = $serviceLocatorInterface->get( 'pserver_secret_question' );
			$similarText    = new \PServerCMS\Validator\SimilarText( $secretQuestion );
			$this->setSimilarText( $similarText );
		}

		$this->add(array(
			'name'       => 'password',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'min' => 6,
						'max' => 32,
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
						'max' => 32,
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
	}

    /**
     * @param User $user
     */
	public function addAnswerValidation(User $user){
		$similarText = $this->getSimilarText();
        if (!$similarText) {
            return;
        }

        $similarText->setUser( $user );

		$this->add(array(
			'name'       => 'answer',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				$similarText,
			),
		));

	}

	/**
	 * @param SimilarText $similarText
	 */
	protected function setSimilarText( SimilarText $similarText )
    {
		$this->similarText = $similarText;
	}

	/**
	 * @return SimilarText
	 */
	protected function getSimilarText()
    {
		return $this->similarText;
	}

} 