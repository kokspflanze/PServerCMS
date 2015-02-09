<?php

namespace PServerCMS\View\Helper;


class PlayerHistory extends InvokerBase {

	/**
	 * @return int
	 */
	public function __invoke(){
		return $this->getPlayerHistory()->getCurrentPlayer();
	}
} 