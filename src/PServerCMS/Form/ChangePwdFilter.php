<?php

namespace PServerCMS\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class ChangePwdFilter extends ProvidesEventsInputFilter
{
    protected $serviceManager;

    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     */
    public function __construct( ServiceLocatorInterface $serviceLocatorInterface )
    {
        $this->setServiceManager($serviceLocatorInterface);

        $passwordLengthOptions = $this->getPasswordOptions()->getLength();

        $this->add(array(
            'name'       => 'currentPassword',
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
     * @return \PServerCMS\Options\PasswordOptions
     */
    protected function getPasswordOptions()
    {
        return $this->getServiceManager()->get('pserver_password_options');
    }
}