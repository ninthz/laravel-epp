<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nr = new NominetDomain();
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$year = 2016;
$month = 11;

$response = $nr->list($year, $month);

print_r($response['response']);