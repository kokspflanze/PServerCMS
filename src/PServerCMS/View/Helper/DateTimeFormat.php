<?php


namespace PServerCMS\View\Helper;


class DateTimeFormat extends InvokerBase
{
    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function __invoke( \DateTime $dateTime )
    {
        return $dateTime->format($this->getConfigFormat());
    }

    /**
     * @return string
     */
    public function getConfigFormat()
    {
        return $this->getGeneralOptions()->getDatetime()['format']['time'];
    }
}