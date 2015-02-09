<?php

namespace PServerCMS\Helper;

class Timer{

	/**
	 * @param array		$hourList
	 * @param integer	$minute
	 *
	 * @return int
	 */
	public static function getNextTime( array $hourList, $minute ){
		return self::nextFight( $hourList, $minute );
	}

	/**
	 * @param array		$dayList
	 * @param integer	$hour
	 * @param integer	$minute
	 *
	 * @return int
	 */
	public static function getNextTimeDay( array $dayList, $hour, $minute ){
		$nextTime = PHP_INT_MAX;
		foreach ($dayList as $day) {
			if( date('l', time() ) == $day ){
				if( time() <= ( $time = mktime( $hour, $minute, 0, date("n") , date("j") , date("Y") ) ) ){
					$nextTime = $time;
					break;
				}
			}
			$timeStamp = mktime( $hour, $minute, 0, date('n', strtotime( 'next '.$day )) , date('j', strtotime( 'next '.$day )) , date('Y', strtotime( 'next '.$day ))  );
			if($nextTime > $timeStamp){
				$nextTime = $timeStamp;
			}
		}
		return $nextTime;
	}

	/**
	 * @param array $hourList
	 * @param       $minute
	 *
	 * @return int
	 */
	protected static function nextFight( array $hourList, $minute ){
		sort($hourList);
		$result = 0;

		foreach($hourList as $hour){
			if( ( $result = mktime( $hour , $minute, 0, date("n") , date("j") , date("Y") ) ) >= time() ){
				break;
			}
		}

		if(!$result){
			foreach($hourList as $hour){
				if( ( $result = mktime( $hour , $minute, 0, date("n") , date('j', strtotime( '+1 day' )) , date("Y") ) ) >= time() ){
					break;
				}
			}
		}

		if(!$result){
			foreach($hourList as $hour){
				if( ( $result = mktime( $hour , $minute, 0, date("m")+1 , 1 , date("Y") ) ) >= time() ){
					break;
				}
			}
		}

		return $result;
	}
}