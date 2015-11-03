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
        self::ERROR_RECORD_FOUND => "A record matching the input was found",
        self::ERROR_NOT_ACTIVE => 'Your Account is not active, please confirm your email'
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
     * @param string $key
     */
    public function __construct(ObjectRepository $objectRepository, $key = '')
    {
        $this->setObjectRepository($objectRepository);
        $this->setKey($key);

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
     * @param ObjectRepository $objectRepository
     * @return self
     */
    public function setObjectRepository(ObjectRepository $objectRepository)
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
     * @param $key
     * @return self
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param $value
     * @return object
     * @throws \Exception
     */
    protected function query($value)
    {

        switch ($this->getKey()) {
            case 'email':
                $result = $this->getObjectRepository()->findOneBy(['email' => $value]);
                break;

            case 'username':
                $result = $this->getObjectRepository()->findOneBy(['username' => $value]);
                break;

            case 'categoryId':
                $result = $this->getObjectRepository()->findOneBy(['categoryid' => $value, 'active' => '1']);
                break;

            default:
                throw new \Exception('Invalid key used in validator');
                break;
        }

        return $result;
    }
}
