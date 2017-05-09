<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetContact;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetContact = new NominetContact('contact_id1');
$nominetContact->setHost($host);
$nominetContact->setUsername($username);
$nominetContact->setPassword($password);

$response = $nominetContact->info();

print_r($response);
