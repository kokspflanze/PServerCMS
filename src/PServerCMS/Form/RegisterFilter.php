<?php

namespace PServerCMS\Form;

use PServerCMS\Helper\HelperBasic;
use PServerCMS\Helper\HelperOptions;
use PServerCMS\Helper\HelperService;
use PServerCMS\Validator;
use PServerCMS\Validator\AbstractRecord;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\InputFilter\ProvidesEventsInputFilter;

class RegisterFilter extends ProvidesEventsInputFilter
{
    use HelperOptions, HelperBasic, HelperService;

    /** @var ServiceManager */
    protected $serviceManager;

    /**
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->setServiceManager($serviceManager);

        $validationUsernameOptions = $this->getValidationOptions()->getUsername();

        $this->add([
            'name' => 'username',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => $validationUsernameOptions['length']['min'],
                        'max' => $validationUsernameOptions['length']['max'],
                    ],
                ],
                [
                    'name' => 'Alnum',
                ],
                $this->getUsernameValidator(),
                $this->getUserNameBackendNotExistsValidator()
            ],
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                        'useMxCheck' => true,
                        'useDeepMxCheck' => true
                    ]
                ],
                $this->getStriposValidator()
            ],
        ]);

        if (!$this->getRegisterOptions()->isDuplicateEmail()) {
            $element = $this->get('email');
            /** @var \Zend\Validator\ValidatorChain $chain */
            $chain = $element->getValidatorChain();
            $chain->attach($this->getEmailValidator());
            $element->setValidatorChain($chain);
        }

        $this->add([
            'name' => 'emailVerify',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 255,
                    ],
                ],
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'email',
                    ],
                ],
            ],
        ]);

        $passwordLengthOptions = $this->getPasswordOptions()->getLength();

        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => $passwordLengthOptions['min'],
                        'max' => $passwordLengthOptions['max'],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'passwordVerify',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => $passwordLengthOptions['min'],
                        'max' => $passwordLengthOptions['max'],
                    ],
                ],
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'password',
                    ],
                ],
            ],
        ]);

        if ($this->getPasswordOptions()->isSecretQuestion()) {
            $this->add([
                'name' => 'question',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'InArray',
                        'options' => [
                            'haystack' => $this->getSecretQuestionList(),
                        ],
                    ],
                ],
            ]);
            $this->add([
                'name' => 'answer',
                'required' => true,
                'filters' => [['name' => 'StringTrim']],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 3,
                            'max' => 255,
                        ],
                    ],
                ],
            ]);
        }
    }

    /**
     * @param ServiceManager $serviceManager
     *
     * @return $this
     */
    public function setServiceManager(ServiceManager $serviceManager)
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
     * @return array
     */
    protected function getSecretQuestionList()
    {
        /** @var \PServerCMS\Entity\Repository\SecretQuestion $secret */
        $secret = $this->getEntityManager()->getRepository('PServerCMS\Entity\SecretQuestion');
        $secretQuestion = $secret->getQuestions();

        $result = [];
        foreach ($secretQuestion as $entry) {
            $result[] = $entry->getId();
        }

        return $result;
    }

    /**
     * @return AbstractRecord
     */
    public function getUsernameValidator()
    {
        /** @var $repositoryUser \Doctrine\Common\Persistence\ObjectRepository */
        $repositoryUser = $this->getEntityManager()->getRepository($this->getEntityOptions()->getUser());

        return new Validator\NoRecordExists($repositoryUser, 'username');
    }

    /**
     * @return AbstractRecord
     */
    public function getEmailValidator()
    {
        /** @var $repositoryUser \Doctrine\Common\Persistence\ObjectRepository */
        $repositoryUser = $this->getEntityManager()->getRepository($this->getEntityOptions()->getUser());

        return new Validator\NoRecordExists($repositoryUser, 'email');
    }

    /**
     * @return Validator\StriposExists
     */
    public function getStriposValidator()
    {
        return new Validator\StriposExists($this->getServiceManager(), Validator\StriposExists::TYPE_EMAIL);
    }

    /**
     * @return Validator\UserNameBackendNotExists
     */
    public function getUserNameBackendNotExistsValidator()
    {
        return new Validator\UserNameBackendNotExists($this->getServiceManager());
    }


} 