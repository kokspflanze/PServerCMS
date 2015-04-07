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
        $timestamp = DateTimer::getZeroTimeStamp( time() ) - ($lastDays - 1) * 60 * 60 * 24;
        $dateTime  = DateTimer::getDateTime4TimeStamp( $timestamp );

        $donateEntity = $this->getDonateLogEntity();
        $typList = $donateEntity->getDonateTypes();
        $donateHistory = $donateEntity->getDonateHistorySuccess($dateTime);
        $result = [];

        // set some default values
        $range = DateTimer::getDateRange4Period($dateTime, new \DateTime());
        foreach($range as $date){
            foreach($typList as $type){
                $result[$date->format('Y-m-d')][$type] = ['amount' => 0, 'coins' => 0];
            }
        }

        if($donateHistory){
            foreach($donateHistory as $donateData){
                $result[$donateData['date']][$donateData['type']] = $donateData;
            }
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getSumOfDonations()
    {
        $donateData = $this->getDonationDataSuccess();

        return (int)$donateData['coins'];
    }

    /**
     * @return int
     */
    public function getNumberOfDonations()
    {
        $donateData = $this->getDonationDataSuccess();

        return (int)$donateData['amount'];
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getDonateQueryBuilder()
    {
        /** @var \PServerCMS\Entity\Repository\DonateLog $repository */
        $repository = $this->getEntityManager()->getRepository($this->getEntityOptions()->getDonateLog());
        return $repository->getDonateQueryBuilder();
    }

    /**
     * @return array
     */
    protected function getDonationDataSuccess(){
        $timestamp = DateTimer::getZeroTimeStamp( time() );
        $dateTime  = DateTimer::getDateTime4TimeStamp( $timestamp );

        $donateEntity = $this->getDonateLogEntity();
        $donateData = $donateEntity->getDonationDataSuccess($dateTime);

        return $donateData;
    }

    /**
     * @return \PServerCMS\Entity\Repository\DonateLog
     */
    protected function getDonateLogEntity()
    {
        return $this->getEntityManager()->getRepository( $this->getEntityOptions()->getDonateLog() );
    }

} 