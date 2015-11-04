<?php

namespace PServerCMS\Form;

use PServerCMS\Validator\AbstractRecord;

class LoginFilter extends \SmallUser\Form\LoginFilter
{
    /**
     * @param AbstractRecord $userValidator
     */
    public function __construct(AbstractRecord $userValidator)
    {
        parent::__construct();

        $element = $this->get('username');
        $chain = $element->getValidatorChain();
        $chain->attach($userValidator);
        $element->setValidatorChain($chain);
    }
}