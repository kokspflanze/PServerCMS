<?php

namespace PServerCMS\Service;

use PServerAdmin\Mapper\HydratorServerInfo;
use PServerCMS\Keys\Caching;

class ServerInfo extends InvokableBase
{
    /**
     * @return null|\PServerCMS\Entity\ServerInfo[]
     */
    public function getServerInfo()
    {
        $serverInfo = $this->getCachingHelperService()->getItem(Caching::SERVER_INFO, function () {
            return $this->getServerInfoRepository()->getActiveInfoList();
        });

        return $serverInfo;
    }

    /**
     * @return null|\PServerCMS\Entity\ServerInfo[]
     */
    public function getAllServerInfo()
    {
        return $this->getServerInfoRepository()->getInfoList();
    }

    /**
     * @param $id
     *
     * @return null|\PServerCMS\Entity\ServerInfo
     */
    public function getServerInfo4Id($id)
    {
        return $this->getServerInfoRepository()->getServerInfo4Id($id);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->getServerInfoRepository()->getQueryBuilder();
    }

    /**
     * @param array $data
     * @param null $currentServerInfo
     *
     * @return bool|\PServerCMS\Entity\ServerInfo
     */
    public function serverInfo(array $data, $currentServerInfo = null)
    {
        if ($currentServerInfo == null) {
            $class = $this->getEntityOptions()->getServerInfo();
            $currentServerInfo = new $class;
        }

        $form = $this->getAdminServerInfoForm();
        $form->setHydrator(new HydratorServerInfo());
        $form->bind($currentServerInfo);
        $form->setData($data);

        if (!$form->isValid()) {
            return false;
        }

        /** @var \PServerCMS\Entity\ServerInfo $serverInfo */
        $serverInfo = $form->getData();

        $entity = $this->getEntityManager();
        $entity->persist($serverInfo);
        $entity->flush();

        return $serverInfo;
    }

    /**
     * @return \PServerCMS\Entity\Repository\ServerInfo
     */
    protected function getServerInfoRepository()
    {
        /** @var \PServerCMS\Entity\Repository\ServerInfo $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getServerInfo());
        return $repository;
    }
} 