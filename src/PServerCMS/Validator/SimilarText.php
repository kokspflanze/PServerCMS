<?php

namespace PServerCMS\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use PServerCMS\Entity\UserInterface;

class SimilarText extends AbstractValidator
{
    /**
     * Error constants
     */
    const ERROR_NOT_SAME = 'noRecordFound';

    /**
     * TODO better message
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_NOT_SAME => "Secret Answer is not correct"
    ];

    /** @var \PServerCMS\Service\SecretQuestion */
    protected $secretQuestionService;

    /**
     * @param \PServerCMS\Service\SecretQuestion $secretQuestionService
     */
    public function __construct(\PServerCMS\Service\SecretQuestion $secretQuestionService)
    {
        $this->setSecretQuestion($secretQuestionService);

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
        if (!$this->getSecretQuestion()->isAnswerAllowed($this->getUser(), $value)) {
            $result = false;
            $this->error(self::ERROR_NOT_SAME);
        }

        return $result;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \PServerCMS\Service\SecretQuestion $secretQuestionService
     */
    protected function setSecretQuestion(\PServerCMS\Service\SecretQuestion $secretQuestionService)
    {
        $this->secretQuestionService = $secretQuestionService;
    }

    /**
     * @return \PServerCMS\Service\SecretQuestion
     */
    protected function getSecretQuestion()
    {
        return $this->secretQuestionService;
    }

} 