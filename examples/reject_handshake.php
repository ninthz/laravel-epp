<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetHandshake;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetHandshake = new NominetHandshake();
$nominetHandshake->setHost($host);
$nominetHandshake->setUsername($username);
$nominetHandshake->setPassword($password);

$parameters = ['case_id' => '123456'];
$response = $nominetHandshake->reject($parameters);

print_r($response);
