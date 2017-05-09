<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetContact;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nominetContact = new NominetContact();
$nominetContact->setHost($host);
$nominetContact->setUsername($username);
$nominetContact->setPassword($password);

$parameters = [
  'contact_id' => 'NEO_63785850',
  'opt_out' => false,
];
$response = $nominetContact->optOut($parameters);

var_dump($response);
