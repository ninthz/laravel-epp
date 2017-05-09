<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetPoll;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetReseller = new NominetPoll();
$nominetReseller->setHost($host);
$nominetReseller->setUsername($username);
$nominetReseller->setPassword($password);

$response = $nominetReseller->poll("req");

print_r($response['status']);