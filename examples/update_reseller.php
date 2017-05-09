<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetReseller;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetReseller = new NominetReseller('RESELLER01');
$nominetReseller->setHost($host);
$nominetReseller->setUsername($username);
$nominetReseller->setPassword($password);

$parameters = [
  'trading_name' => 'NetEarth UK Ltd',
  'url' => 'www.netearthone.co.uk',
  'email' => 'support@netearthone.com',
  'telephone' => '+44.8707707154',
];

$response = $nominetReseller->update($parameters);

print_r($response['dom']);
