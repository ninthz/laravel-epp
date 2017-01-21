<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetContact;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nc = new NominetContact();
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$parameters = [
  'contact_id' => 'MNT2A046505128',
  'opt_out' => true
];
$response = $nc->optOut($parameters);

var_dump($response);
