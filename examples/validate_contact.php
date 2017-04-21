<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetContact;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$contactId = '11DA596DDD880-01';

$nc = new NominetContact($contactId);
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$response = $nc->validate()->toJson();

print_r($response);
