<?php


namespace PServerCMS\Form\Element;

use Zend\Form\Element\DateTimeLocal;

class DateTimeJQuery extends DateTimeLocal
{
    /** @var string */
    const DATETIME_LOCAL_FORMAT = 'Y-m-d';

    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'text',
    ];

    /** @var string */
    protected $format = self::DATETIME_LOCAL_FORMAT;

}