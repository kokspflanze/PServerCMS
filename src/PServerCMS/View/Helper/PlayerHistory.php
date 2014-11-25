<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 25.11.2014
 * Time: 22:40
 */

namespace PServerCMS\View\Helper;


class PlayerHistory extends InvokerBase {

	/**
	 * @return int
	 */
	public function __invoke(){
		return $this->getPlayerHistory()->getCurrentPlayer();
	}
} 