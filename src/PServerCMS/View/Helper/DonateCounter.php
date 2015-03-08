<?php


namespace PServerCMS\View\Helper;


class DonateCounter extends InvokerBase
{
    /**
     * @return int
     */
    public function __invoke()
    {
        return $this->getDonateService()->getNumberOfDonations();
    }
}