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
        /** @var \PServerCMS\Options\GeneralOptions $options */
        $options = $this->getServiceLocator()->get('pserver_general_options');

        return $options->getDatetime()['format']['time'];
    }
}