<?php


namespace PServerCMS\Helper;


trait HelperForm
{


    /**
     * @param $serviceName
     *
     * @return array|object
     */
    abstract function getService( $serviceName );
}