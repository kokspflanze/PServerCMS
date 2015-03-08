<?php


namespace PServerCMS\View\Helper;


class DonateSum extends InvokerBase
{
    /**
     * @return int
     */
    public function __invoke()
    {
        return $this->getDonateService()->getSumOfDonations();
    }

}