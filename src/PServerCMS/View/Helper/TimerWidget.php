<?php


namespace PServerCMS\View\Helper;

use Zend\View\Model\ViewModel;

class TimerWidget extends InvokerBase
{
    /** @var array */
    protected $timerService;

    /**
     * @return string
     */
    public function __invoke()
    {
        $viewModel = new ViewModel(array(
            'timer' => $this->getTimer(),
        ));
        $viewModel->setTemplate('helper/sidebarTimerWidget');

        return $this->getView()->render($viewModel);
    }

    /**
     * @return array
     */
    protected function getTimer()
    {
        if (!$this->timerService) {
            $config = $this->getConfig();
            $timerConfig = isset($config['pserver']['timer'])?$config['pserver']['timer']:[];

            if ($timerConfig) {
                foreach ($timerConfig as $data) {
                    $time = 0;
                    $text = '';

                    if (!isset($data['type'])) {
                        if (isset($data['days'])) {
                            $time = $this->getTimerService()->getNextTimeDay( $data['days'], $data['hour'], $data['min'] );
                        } else {
                            $time = $this->getTimerService()->getNextTime( $data['hours'], $data['min'] );
                        }
                    } else {
                        $text = $data['time'];
                    }

                    $this->timerService[] = [
                        'time' => $time,
                        'text' => $text,
                        'name' => $data['name'],
                        'icon' => $data['icon']
                    ];
                }
            }
        }

        return $this->timerService;
    }
}