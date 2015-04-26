<?php


namespace PServerCMS\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class GuildController extends AbstractActionController
{
    public function detailAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $guild = $this->getGuildService()->getGuild4Id($id);
        if(!$guild){
            return $this->redirect()->toRoute('PServerCMS/home');
        }

        return [
            'guild' => $guild,
            'member' => $this->getGuildService()->getGuildMember4GuildId($id)
        ];
    }

    public function memberAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $guild = $this->getGuildService()->getGuild4Id($id);
        if(!$guild){
            return $this->redirect()->toRoute('PServerCMS/home');
        }
        $page = (int) $this->params()->fromRoute('page');

        return [
            'guild' => $guild,
            'member' => $this->getGuildService()->getGuildMember4GuildId($id, $page)
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