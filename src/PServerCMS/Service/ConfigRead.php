<?php

namespace PServerCMS\Service;

class ConfigRead extends InvokableBase {

    /**
	 * Caching the Config String
     * @var array
     */
    private $cache = array();

    /**
     * @param $configString
     * @param bool $default
     *
     * @return mixed
     */
    public function get( $configString, $default = false ){

		// Check if we have a cache
        if(isset($this->cache[$configString])){
            return $this->cache[$configString];
        }

        $valueList = explode('.', $configString);
        $config = $this->getServiceManager()->get( 'Config' );
        foreach($valueList as $value){
            if(!isset($config[$value])){
                $config = $default;
                break;
            }
            $config = $config[$value];
        }

		// save @ cache
		$this->cache[$configString] = $config;

        return $config;
    }
}