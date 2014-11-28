<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 19.08.14
 * Time: 20:48
 */

namespace PServerCMS\Service;


class CachingHelper extends InvokableBase {

	/**
	 * @param          $cacheKey
	 * @param callable $closure
	 * @param null     $lifetime
	 *
	 * @return mixed
	 */
	public function getItem( $cacheKey, \Closure $closure, $lifetime = null ){
		$data = $this->getCachingService()->getItem($cacheKey);
		if(!$data){
			$data = $closure();
			if($lifetime > 0){
				$this->cachingService->setOptions($this->getCachingService()->getOptions()->setTtl($lifetime));
			}
			$this->getCachingService()->setItem($cacheKey, $data);
		}

		return $data;
	}

	public function delItem( $cacheKey ){
		$this->getCachingService()->removeItem($cacheKey);
	}

} 