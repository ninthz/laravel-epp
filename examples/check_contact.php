<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetContact;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$contactId = 'contact_id1';
$nominetContact = new NominetContact($contactId);
$nominetContact->setHost($host);
$nominetContact->setUsername($username);
$nominetContact->setPassword($password);

$response = $nominetContact->check();

var_dump($response);
