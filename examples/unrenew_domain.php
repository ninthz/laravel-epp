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

$response = $nominetReseller->unrenew(["domain1.co.uk"]);

print_r($response['response']);