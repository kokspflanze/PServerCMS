<?php


namespace PServerCMS\Service;


class Timer extends InvokableBase
{

    /**
     * @param array   $hourList
     * @param integer $minute
     *
     * @return int
     */
    public function getNextTime( array $hourList, $minute )
    {
        return $this->nextFight( $hourList, $minute );
    }

    /**
     * @param array   $dayList
     * @param integer $hour
     * @param integer $minute
     *
     * @return int
     */
    public function getNextTimeDay( array $dayList, $hour, $minute )
    {
        $nextTime = PHP_INT_MAX;
        $currentTimeStamp = $this->getCurrentTimeStamp();

        $nDate = date("n", $currentTimeStamp);
        $yDate = date("Y", $currentTimeStamp);
        $jDate = date("j", $currentTimeStamp);

        foreach ($dayList as $day) {
            if (date( 'l', $currentTimeStamp ) == $day) {
                if ($currentTimeStamp <= ( $time = mktime( $hour, $minute, 0, $nDate, $jDate, $yDate) )) {
                    $nextTime = $time;
                    break;
                }
            }
            $timeStamp = mktime(
                $hour,
                $minute,
                0,
                date( 'n', strtotime('next ' . $day, $currentTimeStamp) ),
                date( 'j', strtotime( 'next ' . $day, $currentTimeStamp ) ),
                date( 'Y', strtotime( 'next ' . $day, $currentTimeStamp ) )
            );
            if ($nextTime > $timeStamp) {
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
    protected function nextFight( array $hourList, $minute )
    {
        sort( $hourList );
        $result = 0;

        $timeStamp = $this->getCurrentTimeStamp();

        $nDate = date("n", $timeStamp);
        $yDate = date("Y", $timeStamp);
        $jDate = date("j", $timeStamp);
        $mDate = date("m", $timeStamp);

        foreach ($hourList as $hour) {
            // same day
            if (( $result = mktime( $hour, $minute, 0, $nDate, $jDate, $yDate ) ) >= $timeStamp) {
                break;
            } else {
                $result = 0;
            }
        }

        if (!$result) {
            // next day
            foreach ($hourList as $hour) {
                if (( $result = mktime( $hour, $minute, 0, $nDate, date( 'j', strtotime('+1 day', $timeStamp)), $yDate ) ) >=
                    $timeStamp) {
                    break;
                }
            }
        }

        if (!$result) {
            // next month
            foreach ($hourList as $hour) {
                if (( $result = mktime( $hour, $minute, 0, $mDate + 1, 1, $yDate ) ) >= $timeStamp) {
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * @return int current timestamp
     */
    protected function getCurrentTimeStamp()
    {
        return time();
    }
}