<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 14.07.14
 * Time: 22:51
 */

namespace PServerCMS\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class Register extends ProvidesEventsForm {

	public function __construct() {
		parent::__construct();
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

		/*
		$this->add(array(
			'name' => 'security',
			'type' => 'Zend\Form\Element\Csrf'
		));
		*/

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