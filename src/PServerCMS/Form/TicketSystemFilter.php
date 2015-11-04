<?php


namespace PServerCMS\Form;

use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcBBCode\Validator\BBCodeValid;

class TicketSystemFilter extends \ZfcTicketSystem\Form\TicketSystemFilter
{
    /**
     * @param ServiceLocatorInterface $sm
     */
    public function __construct(ServiceLocatorInterface $sm)
    {
        parent::__construct($sm);

        $memo = $this->get('memo');
        $validatorChain = $memo->getValidatorChain();
        $validatorChain->attach(new BBCodeValid($sm));

        $memo->setValidatorChain($validatorChain);
    }
}