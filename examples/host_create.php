<?php

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nh = new \LaravelEPP\Registrars\Nominets\NominetHost('example.com');
$nh->setHost($host);
$nh->setUsername($username);
$nh->setPassword($password);

$ip = "127.0.0.1";
$response = $nh->create($ip)->toArray();

var_dump($response);