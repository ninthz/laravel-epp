<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetTag;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetReseller = new NominetTag();
$nominetReseller->setHost($host);
$nominetReseller->setUsername($username);
$nominetReseller->setPassword($password);

$response = $nominetReseller->list();

print_r($response['dom']);