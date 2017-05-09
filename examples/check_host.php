<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetHost;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetHost = new NominetHost('ns1.nominet.org.uk');
$nominetHost->setHost($host);
$nominetHost->setUsername($username);
$nominetHost->setPassword($password);

$response = $nominetHost->check();

print_r($response['response']);
