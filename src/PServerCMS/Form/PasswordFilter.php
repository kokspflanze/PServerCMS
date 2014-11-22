<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 16.07.14
 * Time: 01:32
 */

namespace PServerCMS\Form;


use ZfcBase\InputFilter\ProvidesEventsInputFilter;

class PasswordFilter extends ProvidesEventsInputFilter {

	public function __construct( ){

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
} 