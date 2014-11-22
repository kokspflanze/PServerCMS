<?php

namespace PServerCMS\View\Helper;

class Active extends InvokerBase{

	/**
	 * @param       $routeKey
	 * @param array $params
	 *
	 * @return bool
	 */
	public function __invoke( $routeKey, $params = array()){

        $router = $this->getRouterService();
        $request = $this->getRequestService();

		$routeMatch = $router->match($request);

		if (is_null($routeMatch)){
			return false;
		}

		if($routeKey != $routeMatch->getMatchedRouteName()){
			return false;
		}

		if(is_array($params) || $params instanceof \Traversable ){
			foreach($params as $key => $param){
				if($router->match($request)->getParam($key) != $param){
					return false;
				}
			}
		}

        return true;
    }
}