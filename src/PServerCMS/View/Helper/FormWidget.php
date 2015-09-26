<?php

namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class FormWidget extends InvokerBase
{
    /**
     * @param $form
     * @param string $template
     * @return string
     */
    public function __invoke( $form, $template = 'helper/formWidget' )
    {
        $viewModel = new ViewModel( array(
            'formWidget' => $form
        ) );
        $viewModel->setTemplate( $template );

        return $this->getView()->render( $viewModel );
    }

}