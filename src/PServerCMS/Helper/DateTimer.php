<?php

namespace PServerCMS\Helper;

/**
 * Class DateTimer
 * @package PServerCMS\Helper
 */
class DateTimer {

	/**
	 * @param $iTimeStamp
	 *
	 * @return \DateTime
	 */
	public static function getDateTime4TimeStamp( $iTimeStamp ){
		$oDateTime = new \DateTime();
		$oDateTime->setTimestamp($iTimeStamp);
		return $oDateTime;
	}
} 