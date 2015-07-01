<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\User;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;
use Zend\Mime\Message as MimeMessage;
use Zend\View\Model\ViewModel;

class Mail extends InvokableBase
{
	const SUBJECT_KEY_REGISTER = 'register';
	const SUBJECT_KEY_PASSWORD_LOST = 'password';
    const SUBJECT_KEY_CONFIRM_COUNTRY = 'country';
    const SUBJECT_KEY_SECRET_LOGIN = 'secretLogin';

	/**
	 * @var SmtpOptions
	 */
	protected $mailSMTPOptions;

	/**
	 * RegisterMail
	 *
	 * @param User $user
	 * @param       $code
	 */
	public function register( User $user, $code )
    {
		$params = array(
			'user' => $user,
			'code' => $code
		);

		$this->send(self::SUBJECT_KEY_REGISTER, $user, $params);
	}

	/**
	 * @param User $user
	 * @param       $code
	 */
	public function lostPw( User $user, $code )
    {
		$params = array(
			'user' => $user,
			'code' => $code
		);

		$this->send(self::SUBJECT_KEY_PASSWORD_LOST, $user, $params);
	}

    /**
     * @param User $user
     * @param $code
     */
    public function confirmCountry( User $user, $code )
    {
        $params = array(
            'user' => $user,
            'code' => $code
        );

        $this->send(self::SUBJECT_KEY_CONFIRM_COUNTRY, $user, $params);
    }

    /**
     * @param User $user
     * @param $code
     */
    public function secretLogin( User $user, $code )
    {
        $params = array(
            'user' => $user,
            'code' => $code
        );

        $this->send(self::SUBJECT_KEY_SECRET_LOGIN, $user, $params);
    }

	/**
	 * @param       $subjectKey
	 * @param User $user
	 * @param       $params
	 */
	protected function send($subjectKey, User $user, $params)
    {
		// TODO TwigTemplateEngine
		$renderer = $this->getViewRenderer();
		/** @var \ZfcTwig\View\TwigResolver $oResolver */
		//$oResolver = $this->getServiceManager()->get('ZfcTwig\View\TwigResolver');
		//$oResolver->resolve(__DIR__ . '/../../../view');
		//$oRenderer->setResolver($oResolver);

		//$oRenderer->setVars($aParams);
		$viewModel = new ViewModel();
		$viewModel->setTemplate( 'email/tpl/'.$subjectKey );
		$viewModel->setVariables($params);

		$bodyRender = $renderer->render($viewModel);

		$subject = $this->getSubject4Key($subjectKey);

		try{
			// make a header as html
			$html = new Part($bodyRender);
			$html->type = "text/html";
			$body = new MimeMessage();
			$body->setParts(array($html));

			$mail = new \Zend\Mail\Message();
			$mail->setBody($body);
			$mailOptions = $this->getMailOptions();
			$mail->setFrom($mailOptions->getFrom(), $mailOptions->getFromName());
			$mail->setTo($user->getEmail());
			$mail->setSubject($subject);

			$transport = new Smtp($this->getSMTPOptions());
			$transport->send($mail);
		}catch (\Exception $e){
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
		if (! $this->mailSMTPOptions) {
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
		return isset($subjectList[$key])?$subjectList[$key]:$key;
	}
}