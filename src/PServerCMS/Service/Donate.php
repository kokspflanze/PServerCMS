<?php

namespace PServerCMS\Service;

use PServerCMS\Helper\DateTimer;

class Donate extends InvokableBase
{
    /**
     * @param int $lastDays
     *
     * @return array
     */
    public function getStatisticData( $lastDays = 10 )
    {
        $timestamp = DateTimer::getZeroTimeStamp( time() ) - $lastDays * 60 * 60 * 24;
        $dateTime  = DateTimer::getDateTime4TimeStamp( $timestamp );

        return $this->getDonateLogEntity()->getDonateHistorySuccess( $dateTime );
    }

    /**
     * @return \PServerCMS\Entity\Repository\DonateLog
     */
    protected function getDonateLogEntity()
    {
        return $this->getEntityManager()->getRepository( $this->getEntityOptions()->getDonateLog() );
    }

} 