<?php

namespace PServerCMS\Form;

use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcBase\InputFilter\ProvidesEventsInputFilter;

class ChangePwdFilter extends ProvidesEventsInputFilter
{
    /** @var  ServiceLocatorInterface */
    protected $serviceManager;

    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     */
    public function __construct(ServiceLocatorInterface $serviceLocatorInterface)
    {
        $this->setServiceManager($serviceLocatorInterface);

        $passwordLengthOptions = $this->getPasswordOptions()->getLength();

        $this->add([
            'name' => 'currentPassword',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => $passwordLengthOptions['min'],
                        'max' => $passwordLengthOptions['max'],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => $passwordLengthOptions['min'],
                        'max' => $passwordLengthOptions['max'],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'passwordVerify',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => $passwordLengthOptions['min'],
                        'max' => $passwordLengthOptions['max'],
                    ],
                ],
                [
                    'name' => 'Identical',
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
    public function setServiceManager(ServiceLocatorInterface $oServiceManager)
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
     * @return \PServerCMS\Options\PasswordOptions
     */
    protected function getPasswordOptions()
    {
        return $this->getServiceManager()->get('pserver_password_options');
    }
}