<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\User;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;
use Zend\Mime\Message as MimeMessage;
use Zend\View\Model\ViewModel;

class Mail extends InvokableBase {

	const SUBJECT_KEY_REGISTER = 'register';
	const SUBJECT_KEY_PASSWORD_LOST = 'password';
    const SUBJECT_KEY_CONFIRM_COUNTRY = 'country';

	/**
	 * @var \Zend\View\Renderer\PhpRenderer
	 */
	protected $viewRenderer;

	/**
	 * TODO Option
	 * @var array
	 */
	protected $mailConfig;

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
	public function register( User $user, $code ){

		$params = array(
			'user' => $user,
			'code' => $code
		);

		$this->send(static::SUBJECT_KEY_REGISTER, $user, $params);
	}

	/**
	 * @param User $user
	 * @param       $code
	 */
	public function lostPw( User $user, $code ){

		$aParams = array(
			'user' => $user,
			'code' => $code
		);

		$this->send(static::SUBJECT_KEY_PASSWORD_LOST, $user, $aParams);
	}

    /**
     * @param User $user
     * @param $code
     */
    public function confirmCountry( User $user, $code ){

        $aParams = array(
            'user' => $user,
            'code' => $code
        );

        $this->send(static::SUBJECT_KEY_CONFIRM_COUNTRY, $user, $aParams);
    }

	/**
	 * @param       $subjectKey
	 * @param User $user
	 * @param       $params
	 */
	protected function send($subjectKey, User $user, $params){
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
			set_time_limit(30);
			// make a header as html
			$html = new Part($bodyRender);
			$html->type = "text/html";
			$body = new MimeMessage();
			$body->setParts(array($html));

			$mail = new \Zend\Mail\Message();
			$mail->setBody($body);
			$config = $this->getMailConfig();
			$mail->setFrom($config['from'], $config['fromName']);
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
	public function getViewRenderer(){
		if (! $this->viewRenderer) {
			// $this->viewRenderer = $this->getServiceManager()->get('TwigViewRenderer');
			$this->viewRenderer = $this->getServiceManager()->get('ViewRenderer');
		}

		return $this->viewRenderer;
	}

	/**
	 * @return array
	 */
	protected function getMailConfig() {
		if (! $this->mailConfig) {
			$config = $this->getServiceManager()->get('Config');
			$this->mailConfig = $config['pserver']['mail'];
		}

		return $this->mailConfig;
	}

	/**
	 * @return SmtpOptions
	 */
	public function getSMTPOptions(){
		if (! $this->mailSMTPOptions) {
			$aConfig = $this->getMailConfig();
			$this->mailSMTPOptions = new SmtpOptions($aConfig['basic']);
		}

		return $this->mailSMTPOptions;
	}

	/**
	 * @param $key
	 *
	 * @return string
	 */
	public function getSubject4Key($key){
		$config = $this->getMailConfig();
		// added fallback if the key not exists, in the config
		return isset($config['subject'][$key])?$key:$config['subject'][$key];
	}
}