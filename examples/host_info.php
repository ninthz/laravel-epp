<?php

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nh = new \LaravelEPP\Registrars\Nominets\NominetHost();
$nh->setHost($host);
$nh->setUsername($username);
$nh->setPassword($password);

$hostName = 'ns1.nominet.org.uk';
$response = $nh->info($hostName)->toArray();

print_r($response['dom']->getHostInfo());
