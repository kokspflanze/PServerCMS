<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 16.07.14
 * Time: 01:32
 */

namespace PServerCMS\Form;

use PServerCMS\Entity\Users;
use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\ServiceManager\ServiceLocatorInterface;
use PServerCMS\Validator\SimilarText;

class PasswordFilter extends ProvidesEventsInputFilter {

	protected $similarText;
	protected $user;

	public function __construct( SimilarText $similarText ){

		$this->setSimilarText($similarText);

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

	public function addAnswerValidation(Users $user){
		$similarText = $this->getSimilarText();
		$similarText->setUser($user);

		$this->add(array(
			'name'       => 'answer',
			'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				$similarText,
			),
		));

	}

	/**
	 * @param SimilarText $similarText
	 */
	protected function setSimilarText( SimilarText $similarText ){
		$this->similarText = $similarText;
	}

	/**
	 * @return SimilarText
	 */
	protected function getSimilarText(){
		return $this->similarText;
	}

} 