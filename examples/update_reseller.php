<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetReseller;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nr = new NominetReseller('RESELLER01');
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$parameters = [
  'trading_name' => 'NetEarth UK Ltd',
  'url' => 'www.netearthone.co.uk',
  'email' => 'support@netearthone.com',
  'telephone' => '+44.8707707154',
];

$response = $nr->update($parameters);

print_r($response['dom']);
