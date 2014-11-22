<?php

namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class FormWidget extends InvokerBase {

	/**
	 * @param $oForm
	 *
	 * @return string
	 */
	public function __invoke($oForm){

        $oViewModel = new ViewModel(array(
			'formWidget' => $oForm
		));
        $oViewModel->setTemplate('helper/formWidget');

        return $this->getView()->render($oViewModel);
    }

}