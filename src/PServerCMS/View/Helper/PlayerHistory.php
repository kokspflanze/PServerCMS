<?php

namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class PlayerHistory extends InvokerBase
{
    /**
     * @param bool|false $showView
     * @return string
     */
    public function __invoke($showView = false)
    {
        $currentPlayer = $this->getPlayerHistory()->getCurrentPlayer();
        $result = $currentPlayer;

        if ($showView) {
            $viewModel = new ViewModel([
                'currentPlayer' => $currentPlayer,
                'maxPlayer' => $this->getGeneralOptions()->getMaxPlayer(),
            ]);
            $viewModel->setTemplate('helper/playerHistory');

            $result = $this->getView()->render($viewModel);
        }

        return $result;
    }
}