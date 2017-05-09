<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetReseller = new NominetDomain();
$nominetReseller->setHost($host);
$nominetReseller->setUsername($username);
$nominetReseller->setPassword($password);

$response = $nominetReseller->renew("domain1.co.uk", '2022-05-05', 'y', 3);

print_r($response['response']);