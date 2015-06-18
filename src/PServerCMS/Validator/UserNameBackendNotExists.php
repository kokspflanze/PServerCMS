<?php


namespace PServerCMS\Validator;

use PServerCMS\Helper\HelperBasic;
use PServerCMS\Helper\HelperOptions;
use PServerCMS\Helper\HelperService;
use Zend\Validator\AbstractValidator;
use Zend\ServiceManager\ServiceManager;

class UserNameBackendNotExists extends AbstractValidator
{
    use HelperBasic, HelperService, HelperOptions;

    const ERROR_RECORD_FOUND = 'recordFound';

    /**
     * TODO better message
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_RECORD_FOUND    => "A record matching the input was found",
    ];


    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @param ServiceManager $serviceManager
     */
    public function __construct( ServiceManager $serviceManager )
    {
        $this->setServiceManager($serviceManager);

        parent::__construct();
    }

    /**
     * @param mixed $value
     *
     * @return bool
     * @throws \Exception
     */
    public function isValid( $value )
    {
        $valid = true;
        $this->setValue( $value );

        $result = $this->query( $value );
        if ($result) {
            $valid = false;
            $this->error( self::ERROR_RECORD_FOUND );
        }

        return $valid;
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param ServiceManager $serviceManager
     * @return UserNameBackendNotExists
     */
    public function setServiceManager( ServiceManager $serviceManager )
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function query( $value )
    {
        $class = $this->getEntityOptions()->getUser();
        /** @var \PServerCMS\Entity\UserInterface $user */
        $user = new $class();
        $user->setUsername($value);

        return $this->getGameBackendService()->isUserNameExists( $user );
    }
}