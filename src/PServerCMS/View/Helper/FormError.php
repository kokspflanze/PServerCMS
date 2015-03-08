<?php

namespace PServerCMS\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as OriginalFormElementErrors;

class FormError extends OriginalFormElementErrors
{
    protected $messageCloseString = '</li></ul></div>';
    protected $messageOpenFormat = '<div class="alert alert-danger"%s><ul class="list-unstyled"><li>';
    protected $messageSeparatorString = '</li><li>';

}