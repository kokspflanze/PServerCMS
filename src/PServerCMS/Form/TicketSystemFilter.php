<?php


namespace PServerCMS\Form;

use ZfcBBCode\Validator\BBCodeValid;
use Zend\ServiceManager\ServiceLocatorInterface;

class TicketSystemFilter extends \ZfcTicketSystem\Form\TicketSystemFilter
{
    /**
     * @param ServiceLocatorInterface $sm
     */
    public function __construct( ServiceLocatorInterface $sm )
    {
        parent::__construct( $sm );
        $memo = $this->get( 'memo' );
        /** @var \Zend\Validator\ValidatorChain $validatorChain */
        $validatorChain = $memo->getValidatorChain();
        $validatorChain->attach( new BBCodeValid( $sm ) );

        $memo->setValidatorChain( $validatorChain );
    }
}