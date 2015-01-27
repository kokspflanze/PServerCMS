<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 27.01.2015
 * Time: 23:59
 */

namespace PServerCMS\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use Zend\ServiceManager\ServiceManager;

class StriposExists extends AbstractValidator {

	const TypeEmail = 'email';

	/**
	 * Error constants
	 */
	const ERROR_NOT_SAME    = 'noRecordFound';

	/**
	 * TODO better message
	 * @var array Message templates
	 */
	protected $messageTemplates = array(
		self::ERROR_NOT_SAME => "Entry not allowed"
	);

	/** @var ServiceManager */
	protected $serviceManager;
	/** @var  string */
	protected $type;

	/**
	 * @param ServiceManager $serviceManager
	 * @param                              $type
	 */
	function __construct( ServiceManager $serviceManager, $type ) {
		$this->setServiceManager($serviceManager);
		$this->setType($type);
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
	public function isValid( $value ) {
		$result = true;
		$this->setValue($value);
		$blackList = $this->getConfigHelper()->get('pserver.blacklisted.'.$this->getType(),false);
		if(!$blackList){
			return $result;
		}
		$value = strtolower($value);
		foreach($blackList as $entry){
			if(stripos($value, $entry) !== true){
				continue;
			}
			$result = false;
			$this->error(self::ERROR_NOT_SAME);
			break;
		}

		return $result;
	}

	/**
	 * @param ServiceManager $oServiceManager
	 *
	 * @return $this
	 */
	protected function setServiceManager( ServiceManager $oServiceManager ) {
		$this->serviceManager = $oServiceManager;

		return $this;
	}

	/**
	 * @return ServiceManager
	 */
	protected function getServiceManager() {
		return $this->serviceManager;
	}

	/**
	 * @param $type
	 */
	protected function setType( $type ){
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	protected function getType(){
		return $this->type;
	}

	/**
	 * @return \PServerCMS\Service\ConfigRead
	 */
	protected function getConfigHelper(){
		return $this->getServiceManager()->get('pserver_configread_service');
	}

	/**
	 * @param $data
	 *
	 * @return string
	 */
	protected function editBlackListedData( $data ) {
		if($this->getType() == self::TypeEmail){
			$data = sprintf('@%s', $data);
		}

		return $data;
	}
}