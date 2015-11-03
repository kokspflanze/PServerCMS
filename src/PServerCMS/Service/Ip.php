<?php


namespace PServerCMS\Service;

use PaymentAPI\Service\Ip as PaymentApiIp;

class Ip extends PaymentApiIp
{

    /**
     * @param string|null $ip
     *
     * @return bool|int
     */
    public function getIp2Decimal($ip = null)
    {
        if (!$ip) {
            $ip = $this->getIp();
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }

        $ipEntryData = explode('.', $ip);

        return ((int)$ipEntryData[3]) + ($ipEntryData[2] * 256) + ($ipEntryData[1] * 256 * 256) + ($ipEntryData[0] * 256 * 256 * 256);
    }
}