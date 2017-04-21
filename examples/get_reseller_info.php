<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetReseller;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nr = new NominetReseller('117419');
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$response = $nr->info()->toJson();

var_dump($response);
