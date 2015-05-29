<?php

namespace PServerCMS\Form;

use PServerCMS\Entity\User;
use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\ServiceManager\ServiceLocatorInterface;
use PServerCMS\Validator\SimilarText;
use Zend\ServiceManager\ServiceManager;

class PasswordFilter extends ProvidesEventsInputFilter
{
    /** @var  \PServerCMS\Validator\SimilarText */
	protected $similarText;
    /** @var  User */
	protected $user;
    protected $serviceManager;

    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     */
	public function __construct( ServiceLocatorInterface $serviceLocatorInterface )
    {
        $this->setServiceManager($serviceLocatorInterface);

		/** @var \PServerCMS\Service\ConfigRead $configService */
		$configService = $this->getServiceManager()->get( 'pserver_configread_service' );
		if($configService->get('pserver.password.secret_question')) {
			$secretQuestion = $this->getServiceManager()->get( 'pserver_secret_question' );
			$similarText    = new \PServerCMS\Validator\SimilarText( $secretQuestion );
			$this->setSimilarText( $similarText );
		}

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
	}

    /**
     * @param ServiceManager $oServiceManager
     *
     * @return $this
     */
    public function setServiceManager( ServiceManager $oServiceManager )
    {
        $this->serviceManager = $oServiceManager;

        return $this;
    }

    /**
     * @return ServiceManager
     */
    protected function getServiceManager()
    {
        return $this->serviceManager;
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

    /**
     * @return \PServerCMS\Options\PasswordOptions
     */
    protected function getPasswordOptions()
    {
        return $this->getServiceManager()->get('pserver_password_options');
    }
} 