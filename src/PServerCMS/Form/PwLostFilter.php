<?php

namespace PServerCMS\Form;

use PServerCMS\Validator\AbstractRecord;
use ZfcBase\InputFilter\ProvidesEventsInputFilter;

class PwLostFilter extends ProvidesEventsInputFilter
{
    /** @var  AbstractRecord */
    protected $userValidator;

    /**
     * @param AbstractRecord $userValidator
     */
    public function __construct(AbstractRecord $userValidator)
    {
        $this->setUserValidator($userValidator);

        $this->add([
            'name' => 'username',
            'required' => true,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 16,
                    ],
                ],
                $this->getUserValidator(),
            ],
        ]);
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