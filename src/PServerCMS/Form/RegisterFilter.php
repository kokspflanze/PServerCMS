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

class RegisterFilter extends ProvidesEventsInputFilter {

	/**
	 * @var AbstractRecord
	 */
	protected $usernameValidator;


	public function __construct( AbstractRecord $usernameValidator ){
		$this->setUsernameValidator( $usernameValidator );

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
						'useMxCheck'    => true
					)
				),
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
} 