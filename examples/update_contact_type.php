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
  'contact_id' => '2E5B7DE5BB406-05',
  'type' => NominetContact::CONTACT_TYPE_NON_UK_COPERATION,
];
$response = $nc->updateType($parameters);

var_dump($response);
