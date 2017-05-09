<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nominetReseller = new NominetDomain();
$nominetReseller->setHost($host);
$nominetReseller->setUsername($username);
$nominetReseller->setPassword($password);

$year = 2016;
$month = 11;

$response = $nominetReseller->list($year, $month);

print_r($response['response']);