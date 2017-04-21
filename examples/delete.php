<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDelete;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nr = new NominetDelete();
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$response = $nr->delete("abc")->toArray();

var_dump($response);