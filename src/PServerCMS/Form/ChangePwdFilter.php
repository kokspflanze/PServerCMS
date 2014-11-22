<?php

namespace PServerCMS\Form;

class ChangePwdFilter extends PasswordFilter{


    public function __construct(){
        parent::__construct();

        $this->add(array(
            'name'       => 'currentPassword',
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
    }
}