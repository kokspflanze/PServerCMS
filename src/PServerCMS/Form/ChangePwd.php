<?php

namespace PServerCMS\Form;

use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class ChangePwd extends ProvidesEventsForm{

    public function __construct(){
        parent::__construct();

        $this->add(array(
            'name' => 'currentPassword',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'password',
                'placeholder' => 'Current Web Password',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'password',
                'placeholder' => 'New Password',
            ),
        ));

        $this->add(array(
            'name' => 'passwordVerify',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'password',
                'placeholder' => 'Confirm new Password',
            ),
        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Save')
            ->setAttributes(array(
                'class' => 'btn btn-primary',
                'type'  => 'submit',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));
    }

    /**
     * @param $which
     * @return $this
     */
    public function setWhich($which){
        $bool = $this->hasAttribute('which');
        $hidden = new Element\Hidden('which');
        $hidden->setLabel(' ');
        $hidden->setValue($which);
        $this->add($hidden);

        return $this;
    }
}



