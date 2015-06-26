<?php


namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class NewsWidget extends InvokerBase
{

    /**
     * @return string
     */
    public function __invoke()
    {
        $viewModel = new ViewModel([
            'newsList' => $this->getNewsService()->getActiveNews()
        ]);
        $viewModel->setTemplate('helper/newsWidget');

        return $this->getView()->render($viewModel);
    }
}