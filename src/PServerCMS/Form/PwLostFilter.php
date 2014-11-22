<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 23.07.14
 * Time: 21:28
 */

namespace PServerCMS\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use PServerCMS\Validator\AbstractRecord;

class PwLostFilter extends ProvidesEventsInputFilter {

	/**
	 * @var AbstractRecord
	 */
	protected $usernameValidator;


	public function __construct( AbstractRecord $usernameValidator ){
		$this->setUsernameValidator( $usernameValidator );

		$this->add(array(
			'name'       => 'username',
			'required'   => true,
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