<?php

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nh = new \LaravelEPP\Registrars\Nominets\NominetHost('ns1.nominet.org.uk');
$nh->setHost($host);
$nh->setUsername($username);
$nh->setPassword($password);

$response = $nh->info();

print_r($response['response']);
