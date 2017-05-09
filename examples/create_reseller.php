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
  'trading_name' => 'Test Brand1',
  'url' => 'http://www.testnominet.co.uk',
  'email' => 'support@testnominet.co.uk',
];

$response = $nominetReseller->create($parameters);

print_r($response['status']);
