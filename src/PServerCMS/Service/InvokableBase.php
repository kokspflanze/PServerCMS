<?php
namespace PServerCMS\Service;

use SmallUser\Service\InvokableBase as UserBase;
use Zend\Form\FormInterface;

class InvokableBase extends UserBase
{
    /** @var  array|object */
    protected $serviceCache;

    /**
     * @return \Zend\Cache\Storage\StorageInterface
     */
    protected function getCachingService()
    {
        return $this->getService('pserver_caching_service');
    }

    /**
     * @return CachingHelper
     */
    protected function getCachingHelperService()
    {
        return $this->getService('pserver_cachinghelper_service');
    }

    /**
     * @return \GameBackend\DataService\DataServiceInterface
     */
    protected function getGameBackendService()
    {
        return $this->getService('gamebackend_dataservice');
    }

    /**
     * @param $userId
     *
     * @return null|\PServerCMS\Entity\UserInterface
     */
    protected function getUser4Id( $userId )
    {
        /** @var \PServerCMS\Entity\Repository\User $userRepository */
        $userRepository = $this->getEntityManager()->getRepository( $this->getEntityOptions()->getUser() );
        return $userRepository->getUser4Id( $userId );
    }

    /**
     * @return ConfigRead
     */
    protected function getConfigService()
    {
        return $this->getService('pserver_configread_service');
    }

    /**
     * @return UserBlock
     */
    protected function getUserBlockService()
    {
        return $this->getService('pserver_user_block_service');
    }

    /**
     * @return \PServerCMS\Options\EntityOptions
     */
    protected function getEntityOptions()
    {
        return $this->getService('pserver_entity_options');
    }

    /**
     * @return \PServerCMS\Options\MailOptions
     */
    protected function getMailOptions()
    {
        return $this->getService('pserver_mail_options');
    }

    /**
     * @return \SmallUser\Service\User
     */
    protected function getUserService()
    {
        return $this->getService('small_user_service');
    }

    /**
     * @param FormInterface $form
     * @param $namespace
     */
    protected function addFormMessagesInFlashMessenger( FormInterface $form, $namespace)
    {
        $messages = $form->getMessages();
        foreach ($messages as $elementMessages) {
            foreach ($elementMessages as $message) {
                $this->getFlashMessenger()->setNamespace( $namespace )->addMessage( $message );
            }
        }
    }

    /**
     * @param $serviceName
     *
     * @return array|object
     */
    protected function getService( $serviceName )
    {
        if (!isset( $this->serviceCache[$serviceName] )) {
            $this->serviceCache[$serviceName] = $this->getServiceManager()->get( $serviceName );
        }
        return $this->serviceCache[$serviceName];
    }
} 