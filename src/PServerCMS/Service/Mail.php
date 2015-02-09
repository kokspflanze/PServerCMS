<?php

namespace PServerCMS\Service;


use PServerCMS\Entity\Users;
use PServerCMS\Keys\Entity;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;
use Zend\Mime\Message as MimeMessage;
use Zend\View\Model\ViewModel;

class Mail extends InvokableBase {

	const SubjectKeyRegister = 'register';
	const SubjectKeyPasswordLost = 'password';
    const SubjectKeyConfirmCountry = 'country';

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
	 * @param Users $user
	 * @param       $code
	 */
	public function register( Users $user, $code ){

		$params = array(
			'user' => $user,
			'code' => $code
		);

		$this->send(static::SubjectKeyRegister, $user, $params);
	}

	/**
	 * @param Users $user
	 * @param       $sCode
	 */
	public function lostPw( Users $user, $sCode ){

		$aParams = array(
			'user' => $user,
			'code' => $sCode
		);

		$this->send(static::SubjectKeyPasswordLost, $user, $aParams);
	}

    /**
     * @param Users $oUser
     * @param $sCode
     */
    public function confirmCountry( Users $oUser, $sCode ){

        $aParams = array(
            'user' => $oUser,
            'code' => $sCode
        );

        $this->send(static::SubjectKeyConfirmCountry, $oUser, $aParams);
    }

	/**
	 * @param       $sSubjectKey
	 * @param Users $oUser
	 * @param       $aParams
	 */
	protected function send($sSubjectKey, Users $oUser, $aParams){
		// TODO TwigTemplateEngine
		$oRenderer = $this->getViewRenderer();
		/** @var \ZfcTwig\View\TwigResolver $oResolver */
		//$oResolver = $this->getServiceManager()->get('ZfcTwig\View\TwigResolver');
		//$oResolver->resolve(__DIR__ . '/../../../view');
		//$oRenderer->setResolver($oResolver);

		//$oRenderer->setVars($aParams);
		$oViewModel = new ViewModel();
		$oViewModel->setTemplate( 'email/tpl/'.$sSubjectKey );
		$oViewModel->setVariables($aParams);

		$sBody = $oRenderer->render($oViewModel);

		$sSubject = $this->getSubject4Key($sSubjectKey);

		try{
			set_time_limit(30);
			// make a header as html
			$oHtml = new Part($sBody);
			$oHtml->type = "text/html";
			$oBody = new MimeMessage();
			$oBody->setParts(array($oHtml));

			$oMail = new \Zend\Mail\Message();
			$oMail->setBody($oBody);
			$aConfig = $this->getMailConfig();
			$oMail->setFrom($aConfig['from'], $aConfig['fromName']);
			$oMail->setTo($oUser->getEmail());
			$oMail->setSubject($sSubject);

			$transport = new Smtp($this->getSMTPOptions());
			$transport->send($oMail);
		}catch (\Exception $e){
			// Logging if smth wrong in Configuration or SMTP Offline =)
			$oEntityManager = $this->getEntityManager();
			$sClass = Entity::Logs;
			/** @var \PServerCMS\Entity\Logs $oLogs */
			$oLogs = new $sClass();
			$oLogs->setTopic('mail_faild');
			$oLogs->setMemo($e->getMessage());
			$oLogs->setUsersUsrid($oUser);
			$oEntityManager->persist($oLogs);
			$oEntityManager->flush();
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
			$aConfig = $this->getServiceManager()->get('Config');
			$this->mailConfig = $aConfig['pserver']['mail'];
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
	 * @param $sKey
	 *
	 * @return string
	 */
	public function getSubject4Key($sKey){
		$aConfig = $this->getMailConfig();
		// added fallback if the key not exists, in the config
		return isset($aConfig['subject'][$sKey])?$sKey:$aConfig['subject'][$sKey];
	}
}