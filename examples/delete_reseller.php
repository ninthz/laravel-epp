<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetReseller;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetReseller = new NominetReseller('RESELLER01');
$nominetReseller->setHost($host);
$nominetReseller->setUsername($username);
$nominetReseller->setPassword($password);

$response = $nominetReseller->delete();

print_r($response['dom']);
