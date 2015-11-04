<?php

namespace PServerCMS\Form;

use Zend\Form\Element;
use Zend\Form\Element\Captcha;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcBase\Form\ProvidesEventsForm;

class Register extends ProvidesEventsForm
{

    /**
     * Register constructor.
     * @param ServiceLocatorInterface $sm
     */
    public function __construct(ServiceLocatorInterface $sm)
    {
        parent::__construct();

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'eugzhoe45gh3o49ug2wrtu7gz50'
        ]);

        $this->add([
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'placeholder' => 'Username',
                'class' => 'form-control',
                'type' => 'text'
            ],
        ]);

        $this->add([
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'placeholder' => 'Email',
                'class' => 'form-control',
                'type' => 'email'
            ],
        ]);
        $this->add([
            'name' => 'emailVerify',
            'options' => [
                'label' => 'Email Verify',
            ],
            'attributes' => [
                'placeholder' => 'Email Verify',
                'class' => 'form-control',
                'type' => 'email'
            ],
        ]);

        $this->add([
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'placeholder' => 'Password',
                'class' => 'form-control',
                'type' => 'password'
            ],
        ]);

        $this->add([
            'name' => 'passwordVerify',
            'options' => [
                'label' => 'Password Verify',
            ],
            'attributes' => [
                'placeholder' => 'Password Verify',
                'class' => 'form-control',
                'type' => 'password'
            ],
        ]);

        /** @var \PServerCMS\Service\ConfigRead $configService */
        $configService = $sm->get('pserver_configread_service');
        if ($configService->get('pserver.password.secret_question')) {

            /** @var \PServerCMS\Options\EntityOptions $entityOptions */
            $entityOptions = $sm->get('pserver_entity_options');

            $this->add([
                'name' => 'question',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => [
                    'object_manager' => $sm->get('Doctrine\ORM\EntityManager'),
                    'target_class' => $entityOptions->getSecretQuestion(),
                    'property' => 'question',
                    'label' => 'SecretQuestion',
                    'empty_option' => '-- select --',
                    'is_method' => true,
                    'find_method' => [
                        'name' => 'getQuestions',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]);

            $this->add([
                'name' => 'answer',
                'options' => [
                    'label' => 'SecretAnswer',
                ],
                'attributes' => [
                    'placeholder' => 'Answer',
                    'class' => 'form-control',
                    'type' => 'text'
                ],
            ]);
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

        $this->add($captcha, [
            'priority' => -90,
        ]);

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Register')
            ->setAttributes([
                'class' => 'btn btn-default',
                'type' => 'submit',
            ]);

        $this->add($submitElement, [
            'priority' => -100,
        ]);

    }
}