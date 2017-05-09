<?php

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetHost = new \LaravelEPP\Registrars\Nominets\NominetHost('example07.com');
$nominetHost->setHost($host);
$nominetHost->setUsername($username);
$nominetHost->setPassword($password);

$ip = "127.0.0.1";
$response = $nominetHost->create($ip);

print_r($response['response']);
