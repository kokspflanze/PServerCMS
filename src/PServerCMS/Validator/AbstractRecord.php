<?php

namespace PServerCMS\Validator;

use Zend\Validator\AbstractValidator;
use Doctrine\Common\Persistence\ObjectRepository;

abstract class AbstractRecord extends AbstractValidator
{
    /**
     * Error constants
     */
    const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    const ERROR_RECORD_FOUND = 'recordFound';
    const ERROR_NOT_ACTIVE = 'notActiveUser';

    /**
     * TODO better message
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_NO_RECORD_FOUND => "No record matching the input was found",
        self::ERROR_RECORD_FOUND    => "A record matching the input was found",
        self::ERROR_NOT_ACTIVE      => 'Your Account is not active, please confirm your email'
    ];

    /**
     * @var ObjectRepository
     */
    protected $objectRepository;

    /**
     * @var string
     */
    protected $key;

    /**
     * @param ObjectRepository $objectRepository
     * @param string           $key
     */
    public function __construct( ObjectRepository $objectRepository, $key = '' )
    {
        $this->setObjectRepository( $objectRepository );
        $this->setKey( $key );

        parent::__construct();
    }

    /**
     * getMapper
     *
     * @return ObjectRepository
     */
    public function getObjectRepository()
    {
        return $this->objectRepository;
    }

    /**
     * setMapper
     *
     * @param ObjectRepository $mapper
     *
     * @return AbstractRecord
     */
    public function setObjectRepository( ObjectRepository $objectRepository )
    {
        $this->objectRepository = $objectRepository;

        return $this;
    }

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set key.
     *
     * @param string $key
     */
    public function setKey( $key )
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Grab the user from the mapper
     *
     * @param string $value
     *
     * @return mixed
     */
    protected function query( $value )
    {

        switch ($this->getKey()) {
            case 'email':
                $result = $this->getObjectRepository()->findOneBy( array( 'email' => $value ) );
                break;

            case 'username':
                $result = $this->getObjectRepository()->findOneBy( array( 'username' => $value ) );
                break;

            case 'categoryId':
                $result = $this->getObjectRepository()->findOneBy( array( 'categoryid' => $value, 'active' => '1' ) );
                break;

            default:
                throw new \Exception( 'Invalid key used in validator' );
                break;
        }

        return $result;
    }
}
