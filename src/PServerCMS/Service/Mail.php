<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\UserInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part;
use Zend\View\Model\ViewModel;
use ZfcTicketSystem\Entity\TicketEntry;
use ZfcTicketSystem\Entity\TicketSubject;

class Mail extends InvokableBase
{
    const SUBJECT_KEY_REGISTER = 'register';
    const SUBJECT_KEY_PASSWORD_LOST = 'password';
    const SUBJECT_KEY_CONFIRM_COUNTRY = 'country';
    const SUBJECT_KEY_SECRET_LOGIN = 'secretLogin';
    const SUBJECT_KEY_TICKET_ANSWER = 'ticketAnswer';

    /**
     * @var SmtpOptions
     */
    protected $mailSMTPOptions;

    /**
     * RegisterMail
     *
     * @param UserInterface $user
     * @param       $code
     */
    public function register(UserInterface $user, $code)
    {
        $params = [
            'user' => $user,
            'code' => $code
        ];

        $this->send(self::SUBJECT_KEY_REGISTER, $user, $params);
    }

    /**
     * @param UserInterface $user
     * @param       $code
     */
    public function lostPw(UserInterface $user, $code)
    {
        $params = [
            'user' => $user,
            'code' => $code
        ];

        $this->send(self::SUBJECT_KEY_PASSWORD_LOST, $user, $params);
    }

    /**
     * @param UserInterface $user
     * @param $code
     */
    public function confirmCountry(UserInterface $user, $code)
    {
        $params = [
            'user' => $user,
            'code' => $code
        ];

        $this->send(self::SUBJECT_KEY_CONFIRM_COUNTRY, $user, $params);
    }

    /**
     * @param UserInterface $user
     * @param $code
     */
    public function secretLogin(UserInterface $user, $code)
    {
        $params = [
            'user' => $user,
            'code' => $code
        ];

        $this->send(self::SUBJECT_KEY_SECRET_LOGIN, $user, $params);
    }

    /**
     * @param UserInterface $user
     * @param TicketSubject $ticketSubject
     * @param TicketEntry $ticketEntry
     */
    public function ticketAnswer(UserInterface $user, TicketSubject $ticketSubject, TicketEntry $ticketEntry)
    {
        $params = [
            'user' => $user,
            'ticketSubject' => $ticketSubject,
            'ticketEntry' => $ticketEntry,
        ];

        $this->send(self::SUBJECT_KEY_TICKET_ANSWER, $user, $params);
    }

    /**
     * @param $subjectKey
     * @param UserInterface $user
     * @param $params
     */
    protected function send($subjectKey, UserInterface $user, $params)
    {
        // we have no mail, so we can skip it
        if (!$user->getEmail()) {
            return;
        }

        // TODO TwigTemplateEngine
        $renderer = $this->getViewRenderer();
        //$oResolver = $this->getServiceManager()->get('ZfcTwig\View\TwigResolver');
        //$oResolver->resolve(__DIR__ . '/../../../view');
        //$oRenderer->setResolver($oResolver);

        //$oRenderer->setVars($aParams);
        $viewModel = new ViewModel();
        $viewModel->setTemplate('email/tpl/' . $subjectKey);
        $viewModel->setVariables($params);

        $bodyRender = $renderer->render($viewModel);

        $subject = $this->getSubject4Key($subjectKey);

        try {
            // make a header as html
            $html = new Part($bodyRender);
            $html->type = "text/html";
            $body = new MimeMessage();
            $body->setParts([$html]);

            $mail = new Message();
            $mail->setBody($body);
            $mailOptions = $this->getMailOptions();
            $mail->setFrom($mailOptions->getFrom(), $mailOptions->getFromName());
            $mail->setTo($user->getEmail());
            $mail->setSubject($subject);

            $transport = new Smtp($this->getSMTPOptions());
            $transport->send($mail);
        } catch (\Exception $e) {
            // Logging if smth wrong in Configuration or SMTP Offline =)
            $entityManager = $this->getEntityManager();
            $class = $this->getEntityOptions()->getLogs();
            /** @var \PServerCMS\Entity\Logs $logEntity */
            $logEntity = new $class();
            $logEntity->setTopic('mail_faild');
            $logEntity->setMemo($e->getMessage());
            $logEntity->setUser($user);
            $entityManager->persist($logEntity);
            $entityManager->flush();
        }
    }

    /**
     * @return \Zend\View\Renderer\PhpRenderer
     */
    public function getViewRenderer()
    {
        return $this->getService('ViewRenderer');
    }

    /**
     * @return SmtpOptions
     */
    public function getSMTPOptions()
    {
        if (!$this->mailSMTPOptions) {
            $this->mailSMTPOptions = new SmtpOptions($this->getMailOptions()->getBasic());
        }

        return $this->mailSMTPOptions;
    }

    /**
     * @param $key
     *
     * @return string
     */
    public function getSubject4Key($key)
    {
        $subjectList = $this->getMailOptions()->getSubject();
        // added fallback if the key not exists, in the config
        return isset($subjectList[$key]) ? $subjectList[$key] : $key;
    }
}