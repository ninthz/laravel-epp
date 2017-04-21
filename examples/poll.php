<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetPoll;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nr = new NominetPoll();
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$response = $nr->poll("req")->toArray();

var_dump($response);