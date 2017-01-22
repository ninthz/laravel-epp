<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nd = new NominetDomain();
$nd->setHost($host);
$nd->setUsername($username);
$nd->setPassword($password);

$parameters = [
  'reference' => '',
  'domain' => '',
];
$response = $nd->updateReseller($parameters);

var_dump($response);
