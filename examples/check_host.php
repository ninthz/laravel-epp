<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetHost;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nc = new NominetHost('ns1.nominet.org.uk');
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$response = $nc->check();

print_r($response['response']);