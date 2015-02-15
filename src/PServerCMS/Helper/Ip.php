<?php

namespace PServerCMS\Helper;

/**
 * Class Ip
 * @package PServerCMS\Helper
 */
class Ip extends \PaymentAPI\Helper\Ip
{

    /**
     * @param $sIp
     *
     * @return bool|int
     */
    public static function getIp2Decimal( $sIp )
    {
        if (!filter_var( $sIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )) {
            return false;
        }
        $aIp = explode( '.', $sIp );
        return ( (int)$aIp[3] ) + ( $aIp[2] * 256 ) + ( $aIp[1] * 256 * 256 ) + ( $aIp[0] * 256 * 256 * 256 );
    }
}
