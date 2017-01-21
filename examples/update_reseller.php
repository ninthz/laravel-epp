<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetReseller;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nr = new NominetReseller();
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);


$parameters = [
  'reference' => '123456',
  'trading_name' => 'South West Broadband',
  'url' => 'http://www.swbroadband.co.uk',
  'email' => 'support@swbroadband.co.uk',
  'telephone' => '0441872672050',
];
$response = $nr->update($parameters);

var_dump($response);
