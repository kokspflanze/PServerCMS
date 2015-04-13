<?php
namespace PServerCMS\Service;

use SmallUser\Service\InvokableBase as UserBase;
use Zend\Form\FormInterface;

class InvokableBase extends UserBase
{
    /** @var \Zend\Cache\Storage\StorageInterface */
    protected $cachingService;
    /** @var  CachingHelper */
    protected $cachingHelperService;
    /** @var  \GameBackend\DataService\DataServiceInterface */
    protected $gameBackendService;
    /** @var  ConfigRead */
    protected $configReadService;
    /** @var  UserBlock */
    protected $userBlockService;
    /** @var \PServerCMS\Options\EntityOptions */
    protected $entityOptions;
    /** @var \PServerCMS\Options\MailOptions */
    protected $mailOptions;
    /** @var  \SmallUser\Service\User */
    protected $userService;

    /**
     * @return \Zend\Cache\Storage\StorageInterface
     */
    protected function getCachingService()
    {
        if (!$this->cachingService) {
            $this->cachingService = $this->getServiceManager()->get( 'pserver_caching_service' );
        }

        return $this->cachingService;
    }

    /**
     * @return CachingHelper
     */
    protected function getCachingHelperService()
    {
        if (!$this->cachingHelperService) {
            $this->cachingHelperService = $this->getServiceManager()->get( 'pserver_cachinghelper_service' );
        }

        return $this->cachingHelperService;
    }

    /**
     * @return \GameBackend\DataService\DataServiceInterface
     */
    protected function getGameBackendService()
    {
        if (!$this->gameBackendService) {
            $this->gameBackendService = $this->getServiceManager()->get( 'gamebackend_dataservice' );
        }

        return $this->gameBackendService;
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
        if (!$this->configReadService) {
            $this->configReadService = $this->getServiceManager()->get( 'pserver_configread_service' );
        }

        return $this->configReadService;
    }

    /**
     * @return UserBlock
     */
    protected function getUserBlockService()
    {
        if (!$this->userBlockService) {
            $this->userBlockService = $this->getServiceManager()->get( 'pserver_user_block_service' );
        }

        return $this->userBlockService;
    }

    /**
     * @return \PServerCMS\Options\EntityOptions
     */
    protected function getEntityOptions()
    {
        if (!$this->entityOptions) {
            $this->entityOptions = $this->getServiceManager()->get( 'pserver_entity_options' );
        }

        return $this->entityOptions;
    }

    /**
     * @return \PServerCMS\Options\MailOptions
     */
    protected function getMailOptions()
    {
        if (!$this->mailOptions) {
            $this->mailOptions = $this->getServiceManager()->get( 'pserver_mail_options' );
        }

        return $this->mailOptions;
    }

    /**
     * @return \SmallUser\Service\User
     */
    protected function getUserService()
    {
        if (!$this->userService) {
            $this->userService = $this->getServiceManager()->get( 'small_user_service' );
        }

        return $this->userService;
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
} 