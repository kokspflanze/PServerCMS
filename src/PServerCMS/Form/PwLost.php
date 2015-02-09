<?php

namespace PServerCMS\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class PwLost extends ProvidesEventsForm {

	public function __construct() {
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
                'class' => 'form-control',
				'type' => 'text'
			),
		));

		$submitElement = new Element\Button('submit');
		$submitElement
			->setLabel('PwLost')
			->setAttributes(array(
                'class' => 'btn btn-default',
				'type'  => 'submit',
			));

		$this->add($submitElement, array(
			'priority' => -100,
		));

	}
} 