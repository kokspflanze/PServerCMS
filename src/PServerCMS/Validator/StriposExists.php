<?php

namespace PServerCMS\Validator;

use PServerCMS\Helper\HelperBasic;
use PServerCMS\Helper\HelperService;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use Zend\ServiceManager\ServiceManager;

class StriposExists extends AbstractValidator
{
    use HelperBasic, HelperService;

    const TYPE_EMAIL = 'email';

    /**
     * Error constants
     */
    const ERROR_BLACKLIST = 'EntryNotAllowed';

    /**
     * TODO better message
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_BLACKLIST => "Entry not allowed"
    ];

    /** @var ServiceManager */
    protected $serviceManager;
    /** @var  string */
    protected $type;

    /**
     * @param ServiceManager $serviceManager
     * @param                              $type
     */
    public function __construct(ServiceManager $serviceManager, $type)
    {
        $this->setServiceManager($serviceManager);
        $this->setType($type);

        parent::__construct();
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     *
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $result = true;
        $this->setValue($value);
        $blackList = $this->getConfigService()->get('pserver.blacklisted.' . $this->getType(), false);

        if (!$blackList) {
            return $result;
        }

        foreach ($blackList as $entry) {
            if (stripos($value, $this->editBlackListedData($entry)) === false) {
                continue;
            }
            $result = false;
            $this->error(self::ERROR_BLACKLIST);
            break;
        }

        return $result;
    }

    /**
     * @param ServiceManager $serviceManager
     *
     * @return $this
     */
    protected function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param $type
     */
    protected function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    protected function getType()
    {
        return $this->type;
    }

    /**
     * @param $data
     *
     * @return string
     */
    protected function editBlackListedData($data)
    {
        if ($this->getType() == self::TYPE_EMAIL) {
            $data = sprintf('@%s', $data);
        }

        return $data;
    }
}