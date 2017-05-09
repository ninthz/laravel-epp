<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetContact;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$contactId = '11DA596DDD880-01';

$nominetContact = new NominetContact($contactId);
$nominetContact->setHost($host);
$nominetContact->setUsername($username);
$nominetContact->setPassword($password);

$response = $nominetContact->validate()->toJson();

print_r($response);
