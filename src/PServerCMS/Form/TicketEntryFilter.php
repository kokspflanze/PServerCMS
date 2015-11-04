<?php


namespace PServerCMS\Form;

use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcBBCode\Validator\BBCodeValid;

class TicketEntryFilter extends \ZfcTicketSystem\Form\TicketEntryFilter
{
    /**
     * @param ServiceLocatorInterface $sm
     */
    public function __construct(ServiceLocatorInterface $sm)
    {
        parent::__construct();

        $memo = $this->get('memo');
        $validatorChain = $memo->getValidatorChain();
        $validatorChain->attach(new BBCodeValid($sm));

        $memo->setValidatorChain($validatorChain);
    }
}