<?php


namespace PServerCMS\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class RankingController extends AbstractActionController
{
    public function topPlayerAction()
    {
        return [
            'ranking' => $this->getRankingService()->getTopPlayer( $this->params()->fromRoute('page') )
        ];
    }

    /**
     * @return \PServerCMS\Service\Ranking
     */
    protected function getRankingService()
    {
        return $this->getServiceLocator()->get('pserver_ranking_service');
    }
}