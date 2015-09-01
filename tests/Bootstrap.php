<?php

include __DIR__ . '/../vendor/autoload.php';

use PServerCMSTest\Util\ServiceManagerFactory;

ini_set('error_reporting', E_ALL);

if (file_exists(__DIR__ . '/TestConfig.php')) {
    $config = require __DIR__ . '/TestConfig.php';
} else {
    throw new \Exception('text config missing');
}

ServiceManagerFactory::setConfig($config);
unset($config);

