<?php


namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class TopGuildWidget extends InvokerBase
{
    /**
     * @param int $limit
     * @return string
     */
    public function __invoke($limit = 10)
    {
        $guildList = $this->getCachingHelperService()->getItem('TopGuildWidget', function () use ($limit) {
            return $this->getRankingService()->getTopGuildEntityData($limit);
        }, 360);

        $viewModel = new ViewModel([
            'guildList' => $guildList
        ]);

        $viewModel->setTemplate('helper/topGuildWidget');

        return $this->getView()->render($viewModel);
    }
}