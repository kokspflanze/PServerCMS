<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 23.07.14
 * Time: 21:28
 */

namespace PServerCMS\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class PwLost extends ProvidesEventsForm {

	public function __construct() {
		parent::__construct();
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