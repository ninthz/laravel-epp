<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetReseller;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nr = new NominetReseller();
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);


$parameters = [
  'reference' => '344942',
  'trading_name' => 'South West Broadband',
  'url' => 'http://www.swbroadband.co.uk',
  'email' => 'support@swbroadband.co.uk',
  'telephone' => '0441872672050',
];
$response = $nr->create($parameters);

var_dump($response);
