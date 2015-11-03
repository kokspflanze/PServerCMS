<?php

namespace PServerCMS\Form;

use PServerCMS\Entity\UserInterface;
use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\ServiceManager\ServiceLocatorInterface;
use PServerCMS\Validator\SimilarText;

class PasswordFilter extends ProvidesEventsInputFilter
{
    /** @var  \PServerCMS\Validator\SimilarText */
	protected $similarText;
    /** @var  UserInterface */
	protected $user;
	/** @var  ServiceLocatorInterface */
    protected $serviceManager;

    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     */
	public function __construct( ServiceLocatorInterface $serviceLocatorInterface )
    {
        $this->setServiceManager($serviceLocatorInterface);

		if ($this->getPasswordOptions()->isSecretQuestion()) {
			/** @var \PServerCMS\Service\SecretQuestion $secretQuestion */
			$secretQuestion = $this->getServiceManager()->get('pserver_secret_question');
			$similarText    = new \PServerCMS\Validator\SimilarText($secretQuestion);
			$this->setSimilarText($similarText);
		}

        $passwordLengthOptions = $this->getPasswordOptions()->getLength();

		$this->add([
			'name'       => 'password',
			'required'   => true,
			'filters'    => [['name' => 'StringTrim']],
			'validators' => [
				[
					'name'    => 'StringLength',
					'options' => [
						'min' => $passwordLengthOptions['min'],
						'max' => $passwordLengthOptions['max'],
					],
				],
			],
		]);

		$this->add([
			'name'       => 'passwordVerify',
			'required'   => true,
			'filters'    => [['name' => 'StringTrim']],
			'validators' => [
				[
					'name'    => 'StringLength',
					'options' => [
                        'min' => $passwordLengthOptions['min'],
                        'max' => $passwordLengthOptions['max'],
					],
				],
				[
					'name'    => 'Identical',
					'options' => [
						'token' => 'password',
					],
				],
			],
		]);
	}

    /**
     * @param ServiceLocatorInterface $oServiceManager
     *
     * @return $this
     */
    public function setServiceManager( ServiceLocatorInterface $oServiceManager )
    {
        $this->serviceManager = $oServiceManager;

        return $this;
    }

    /**
     * @return ServiceLocatorInterface
     */
    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param UserInterface $user
     */
	public function addAnswerValidation(UserInterface $user)
	{
		$similarText = $this->getSimilarText();
        if (!$similarText) {
            return;
        }

        $similarText->setUser( $user );

		$this->add([
			'name'       => 'answer',
			'required'   => true,
			'filters'    => [['name' => 'StringTrim']],
			'validators' => [
				$similarText,
			],
		]);

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