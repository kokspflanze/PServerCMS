<?php


namespace PServerCMS\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class GuildController extends AbstractActionController
{
    public function indexAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $guild = $this->getGuildService()->getGuild4Id($id);
        if(!$guild){
            return $this->redirect()->toRoute('home');
        }

        return [
            'guild' => $guild
        ];
    }

    /**
     * @return \PServerCMS\Service\Guild
     */
    protected function getGuildService()
    {
        return $this->getServiceLocator()->get('pserver_guild_service');
    }
}