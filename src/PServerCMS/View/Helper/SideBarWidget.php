<?php

namespace PServerCMS\View\Helper;

use PServerCMS\Helper\Timer;
use Zend\View\Model\ViewModel;

class SideBarWidget extends InvokerBase
{
	/** @var array */
	protected $timerService;

	/**
	 * @return string
	 */
	public function __invoke()
    {
		$template = '';
		if($this->getAuthService()->getIdentity()){
			$viewModel = new ViewModel(array(
				'user' => $this->getAuthService()->getIdentity()
			));
			$viewModel->setTemplate('helper/sidebarLoggedInWidget');
			$template = $this->getView()->render($viewModel);
		}
		$viewModel = new ViewModel(array(
			'timer' => $this->getTimer(),
			'serverInfo' => $this->getServerInfo()->getServerInfo()
		));
		$viewModel->setTemplate('helper/sidebarWidget');
		return sprintf('%s%s', $template, $this->getView()->render($viewModel));
	}

	/**
	 * @return array
	 */
	protected function getTimer()
    {
		if(!$this->timerService){
			$config = $this->getConfigService();
			$timerConfig = isset($config['pserver']['timer'])?$config['pserver']['timer']:array();
			foreach($timerConfig as $data){
				$time = 0;
				$text = '';
				if(!isset($data['type'])){
					if(isset($data['days'])){
						$time = Timer::getNextTimeDay( $data['days'], $data['hour'], $data['min'] );
					}else{
						$time = Timer::getNextTime( $data['hours'],$data['min'] );
					}
				}else{
					$text = $data['time'];
				}
				$this->timerService[] = array(
					'time' => $time,
					'text' => $text,
					'name' => $data['name'],
					'icon' => $data['icon']
				);
			}
		}

		return $this->timerService;
	}

}