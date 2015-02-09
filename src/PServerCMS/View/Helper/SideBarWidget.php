<?php

namespace PServerCMS\View\Helper;

use PServerCMS\Helper\Timer;
use Zend\View\Model\ViewModel;

class SideBarWidget extends InvokerBase {
	/** @var array */
	protected $timerService;

	/**
	 * @return string
	 */
	public function __invoke(){
		$sTemplate = '';
		if($this->getAuthService()->getIdentity()){
			$oViewModel = new ViewModel(array(
				'user' => $this->getAuthService()->getIdentity()
			));
			$oViewModel->setTemplate('helper/sidebarLoggedInWidget');
			$sTemplate = $this->getView()->render($oViewModel);
		}
		$oViewModel = new ViewModel(array(
			'timer' => $this->getTimer(),
			'serverInfo' => $this->getServerInfo()->getServerInfo()
		));
		$oViewModel->setTemplate('helper/sidebarWidget');
		return $sTemplate.$this->getView()->render($oViewModel);
	}

	/**
	 * @return array
	 */
	protected function getTimer(){
		if(!$this->timerService){
			$aConfig = $this->getConfigService();
			$aTimerConfig = isset($aConfig['pserver']['timer'])?$aConfig['pserver']['timer']:array();
			foreach($aTimerConfig as $aCurData){
				$iTime = 0;
				$sText = '';
				if(!isset($aCurData['type'])){
					if(isset($aCurData['days'])){
						$iTime = Timer::getNextTimeDay( $aCurData['days'], $aCurData['hour'], $aCurData['min'] );
					}else{
						$iTime = Timer::getNextTime( $aCurData['hours'],$aCurData['min'] );
					}
				}else{
					$sText = $aCurData['time'];
				}
				$this->timerService[] = array(
					'time' => $iTime,
					'text' => $sText,
					'name' => $aCurData['name'],
					'icon' => $aCurData['icon']
				);
			}
		}

		return $this->timerService;
	}

}