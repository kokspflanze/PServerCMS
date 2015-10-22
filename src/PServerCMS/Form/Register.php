<?php

namespace PServerCMS\Form;

use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcBase\Form\ProvidesEventsForm;
use Zend\Form\Element\Captcha;

class Register extends ProvidesEventsForm
{

	public function __construct( ServiceLocatorInterface $sm )
    {
		parent::__construct();

		$this->add(array(
			'type' => 'Zend\Form\Element\Csrf',
			'name' => 'eugzhoe45gh3o49ug2wrtu7gz50'
		));

		$this->add(array(
			'name' => 'username',
			'options' => array(
				'label' => 'Username',
			),
			'attributes' => array(
                'placeholder' => 'Username',
                'class' => 'form-control',
				'type' => 'text'
			),
		));

		$this->add(array(
			'name' => 'email',
			'options' => array(
				'label' => 'Email',
			),
			'attributes' => array(
                'placeholder' => 'Email',
                'class' => 'form-control',
				'type' => 'email'
			),
		));
		$this->add(array(
			'name' => 'emailVerify',
			'options' => array(
				'label' => 'Email Verify',
			),
			'attributes' => array(
                'placeholder' => 'Email Verify',
                'class' => 'form-control',
				'type' => 'email'
			),
		));

		$this->add(array(
			'name' => 'password',
			'options' => array(
				'label' => 'Password',
			),
			'attributes' => array(
                'placeholder' => 'Password',
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
                'placeholder' => 'Password Verify',
                'class' => 'form-control',
				'type' => 'password'
			),
		));

		/** @var \PServerCMS\Service\ConfigRead $configService */
		$configService = $sm->get( 'pserver_configread_service' );
		if ($configService->get('pserver.password.secret_question')) {

			/** @var \PServerCMS\Options\EntityOptions $entityOptions */
			$entityOptions = $sm->get('pserver_entity_options');

			$this->add(array(
				'name' => 'question',
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'options' => array(
					'object_manager'=> $sm->get( 'Doctrine\ORM\EntityManager' ),
					'target_class'  => $entityOptions->getSecretQuestion(),
					'property'		=> 'question',
					'label'			=> 'SecretQuestion',
					'empty_option'  => '-- select --',
					'is_method'		=> true,
					'find_method'	=> array(
						'name' => 'getQuestions',
					),
				),
				'attributes' => array(
					'class' => 'form-control',
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

        $captcha = new Captcha('captcha');
        $captcha->setCaptcha($sm->get('SanCaptcha'))
            ->setOptions([
                'label' => 'Please verify you are human.',
            ])
            ->setAttributes([
                'class' => 'form-control',
                'type' => 'text'
            ]);

        $this->add($captcha, array(
			'priority' => -90,
		));

		$submitElement = new Element\Button('submit');
		$submitElement
			->setLabel('Register')
			->setAttributes(array(
                'class' => 'btn btn-default',
				'type'  => 'submit',
			));

		$this->add($submitElement, array(
			'priority' => -100,
		));

	}
}