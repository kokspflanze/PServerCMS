<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 27.07.14
 * Time: 22:56
 */

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