<?php


namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class TopCharacterWidget extends InvokerBase
{
    /**
     * @param int $limit
     * @return string
     */
    public function __invoke($limit = 10)
    {
        $characterList = $this->getCachingHelperService()->getItem('TopCharacterWidget', function () use ($limit) {
            return $this->getRankingService()->getTopCharacterEntityData($limit);
        }, 360);

        $viewModel = new ViewModel([
            'characterList' => $characterList
        ]);

        $viewModel->setTemplate('helper/topCharacterWidget');

        return $this->getView()->render($viewModel);
    }
}