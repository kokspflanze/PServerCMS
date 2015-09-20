<?php

namespace PServerCMS\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use PServerCMS\Validator\AbstractRecord;

class PwLostFilter extends ProvidesEventsInputFilter
{
    /** @var  AbstractRecord */
    protected $userValidator;

    /**
     * @param AbstractRecord $userValidator
     */
	public function __construct( AbstractRecord $userValidator )
    {
        $this->setUserValidator( $userValidator );

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
                $this->getUserValidator(),
			),
		));
	}

    /**
     * @return AbstractRecord
     */
    public function getUserValidator()
    {
        return $this->userValidator;
    }

    /**
     * @param AbstractRecord $userValidator
     *
     * @return $this
     */
    public function setUserValidator($userValidator)
    {
        $this->userValidator = $userValidator;
        return $this;
    }
} 