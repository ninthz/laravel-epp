<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetReseller;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nr = new NominetReseller('123456');
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$parameters = [
  'trading_name' => 'Test Brand',
  'url' => 'http://www.testnominet.co.uk',
  'email' => 'support@testnominet.co.uk',
  'telephone' => '+66123456789',
];

$response = $nr->create($parameters);

var_dump($response->toJson());
