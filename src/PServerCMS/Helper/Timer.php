<?php

namespace PServerCMS\Helper;

class Timer{

	/**
	 * @param array		$aHour
	 * @param integer	$iMinute
	 *
	 * @return int
	 */
	public static function getNextTime( array $aHour, $iMinute ){
		return self::nextFight( $aHour, $iMinute );
	}

	/**
	 * @param array		$aDay
	 * @param integer	$iHour
	 * @param integer	$iMinute
	 *
	 * @return int
	 */
	public static function getNextTimeDay( array $aDay, $iHour, $iMinute ){
		$iNextTime = PHP_INT_MAX;
		foreach ($aDay as $sDay) {
			if( date('l', time() ) == $sDay ){
				if( time() <= ( $time = mktime( $iHour, $iMinute, 0, date("n") , date("j") , date("Y") ) ) ){
					$iNextTime = $time;
					break;
				}
			}
			$iTime = mktime( $iHour, $iMinute, 0, date('n', strtotime( 'next '.$sDay )) , date('j', strtotime( 'next '.$sDay )) , date('Y', strtotime( 'next '.$sDay ))  );
			if($iNextTime > $iTime){
				$iNextTime = $iTime;
			}
		}
		return $iNextTime;
	}

	/**
	 * @param array $aHours
	 * @param       $iM
	 *
	 * @return int
	 */
	protected static function nextFight( array $aHours, $iM ){
		sort($aHours);
		foreach($aHours as $iHour){
			if( ( $iTime = mktime( $iHour , $iM, 0, date("n") , date("j") , date("Y") ) ) >= time() ){
				return $iTime;
			}
		}
		foreach($aHours as $iHour){
			if( ( $iTime = mktime( $iHour , $iM, 0, date("n") , date('j', strtotime( '+1 day' )) , date("Y") ) ) >= time() ){
				return $iTime;
			}
		}
		foreach($aHours as $iHour){
			if( ( $iTime = mktime( $iHour , $iM, 0, date("m")+1 , 1 , date("Y") ) ) >= time() ){
				return $iTime;
			}
		}
	}
}