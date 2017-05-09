<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetContact = new NominetDomain();
$nominetContact->setHost($host);
$nominetContact->setUsername($username);
$nominetContact->setPassword($password);

$response = $nominetContact->transfer('domain1.co.uk', 'contact_id4');

print_r($response['status']);