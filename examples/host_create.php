<?php

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nh = new \LaravelEPP\Registrars\Nominets\NominetHost('example07.com');
$nh->setHost($host);
$nh->setUsername($username);
$nh->setPassword($password);

$ip = "127.0.0.1";
$response = $nh->create($ip);

print_r($response['response']);